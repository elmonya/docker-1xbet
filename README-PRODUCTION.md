# Руководство по развертыванию сайта на 1xbet-install.com

Это руководство поможет вам настроить и развернуть сайт на домене 1xbet-install.com с принудительным HTTPS-соединением.

## Требования

- Сервер Linux (рекомендуется Ubuntu 20.04 или новее)
- Docker и Docker Compose
- DNS настроенный на домен 1xbet-install.com
- Открытый порт 443 (для HTTPS)

## Шаги по развертыванию

### 1. Подготовка сервера

```bash
# Обновление системы
sudo apt update && sudo apt upgrade -y

# Установка необходимых пакетов
sudo apt install -y curl git docker.io docker-compose

# Добавление текущего пользователя в группу docker
sudo usermod -aG docker $USER

# Перезапуск сессии (либо выйти и войти заново)
newgrp docker
```

### 2. Настройка DNS

Убедитесь, что у вас есть A-запись для домена 1xbet-install.com, указывающая на IP-адрес вашего сервера:

```
1xbet-install.com.         IN A      YOUR_SERVER_IP
adminer.1xbet-install.com. IN A      YOUR_SERVER_IP
```

### 3. Клонирование репозитория и настройка

```bash
# Клонирование репозитория
git clone <url_репозитория> 1xbet-site
cd 1xbet-site

# Создайте или отредактируйте файл .env
cat > .env << EOL
# Основные настройки домена
DOMAIN_NAME=1xbet-install.com

# Настройки базы данных (измените пароли на надежные)
MYSQL_ROOT_PASSWORD=secureRootPassword
MYSQL_DATABASE=wordpress
MYSQL_USER=wpuser
MYSQL_PASSWORD=secureUserPassword

# Параметры WordPress
WORDPRESS_DEBUG=0
EOL
```

### 4. Запуск контейнеров

```bash
# Запуск контейнеров
docker-compose up -d
```

### 5. Проверка работоспособности

После запуска контейнеров, ваш сайт должен быть доступен по адресу:
- https://1xbet-install.com

Обратите внимание:
- Сайт доступен ТОЛЬКО по HTTPS
- Порт 443 НЕ указывается в URL (стандартный порт для HTTPS)
- Adminer (инструмент для управления базой данных) доступен по адресу: https://adminer.1xbet-install.com
  Логин: admin
  Пароль: верный пароль был предоставлен отдельно

### 6. Настройка WordPress

После установки, вы можете войти в панель администратора:
- URL: https://1xbet-install.com/wp-admin
- Пользователь: admin
- Пароль: admin

**ВАЖНО**: Обязательно смените пароль администратора после первого входа!

```bash
# Смена пароля администратора через командную строку
docker-compose exec wp-cli wp user update admin --user_pass=newSecurePassword
```

## Обслуживание сайта

### Обновление WordPress и плагинов

```bash
# Обновление ядра WordPress
docker-compose exec wp-cli wp core update

# Обновление плагинов
docker-compose exec wp-cli wp plugin update --all

# Обновление темы
docker-compose exec wp-cli wp theme update aviator-theme
```

### Резервное копирование

```bash
# Резервное копирование базы данных
docker-compose exec db mysqldump -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > backup-$(date +%F).sql

# Резервное копирование файлов WordPress
tar -czvf wordpress-files-$(date +%F).tar.gz ./wp-content
```

### Просмотр логов

```bash
# Логи Caddy
docker-compose logs caddy

# Логи WordPress
docker-compose logs wordpress
```

## Устранение неполадок

### SSL-сертификат не выдается

Если Caddy не может получить SSL-сертификат, проверьте:

1. DNS настройки домена (A-запись должна указывать на ваш сервер)
2. Открыт ли порт 443 на вашем сервере
3. Логи Caddy для дополнительной информации:
   ```bash
   docker-compose logs caddy
   ```

### Сайт недоступен

Проверьте состояние контейнеров:
```bash
docker-compose ps
```

Все контейнеры должны иметь статус "Up". Если какой-то контейнер не запущен, проверьте его логи:
```bash
docker-compose logs <container_name>
```

## Безопасность

1. Сайт настроен для работы только через HTTPS
2. Настроены строгие заголовки безопасности (HSTS, CSP и др.)
3. Защита от брутфорс-атак на wp-login.php
4. Ограничен доступ к критическим файлам WordPress
5. Обратите внимание, что вам следует регулярно:
   - Менять пароли
   - Обновлять WordPress и плагины
   - Следить за логами на предмет подозрительной активности 