# Настройка HTTPS с Caddy для Aviator Theme

## Введение
Эта инструкция поможет вам настроить HTTPS для вашего сайта с использованием Caddy - современного веб-сервера с автоматическим получением SSL сертификатов.

## Требования
- Docker и Docker Compose
- Доступ к DNS записям вашего домена (для настройки на реальном домене)
- Открытые порты 80 и 443 на вашем сервере

## Локальная разработка

### 1. Настройка локальных доменов

Для локальной разработки добавьте следующие записи в файл hosts:

**Windows**: `C:\Windows\System32\drivers\etc\hosts`  
**Linux/Mac**: `/etc/hosts`

```
127.0.0.1 aviator-game.local
127.0.0.1 adminer.aviator-game.local
```

### 2. Запуск с Caddy

```bash
docker-compose up -d
```

После запуска, ваш сайт будет доступен по адресам:
- HTTPS: https://aviator-game.local (с самоподписанным SSL сертификатом)
- HTTP: http://aviator-game.local (с автоматическим перенаправлением на HTTPS)
- Adminer: https://adminer.aviator-game.local

> **Примечание**: При первом посещении сайта в браузере вы увидите предупреждение о недоверенном сертификате, это нормально для локальной разработки. Вы можете принять исключение для этого сертификата.

## Настройка для рабочего сервера

Для использования на реальном сервере:

1. Настройте ваш DNS, указав A-записи, которые указывают на IP-адрес вашего сервера:
   - aviator-game.com
   - adminer.aviator-game.com

2. Измените значение DOMAIN_NAME в файле .env:
   ```
   DOMAIN_NAME=aviator-game.com
   ```

3. Обновите Caddyfile, заменив строку `tls internal` на `tls {
        email your-email@example.com
    }` для получения настоящего SSL сертификата от Let's Encrypt.

4. Перезапустите контейнеры:
   ```bash
   docker-compose down
   docker-compose up -d
   ```

## Проверка SSL

Для проверки SSL сертификата вы можете использовать следующие команды:

```bash
# Проверка состояния Caddy
docker-compose exec caddy caddy status

# Проверка SSL сертификата
echo | openssl s_client -servername aviator-game.local -connect aviator-game.local:443 2>/dev/null | openssl x509 -noout -dates
```

## Устранение неполадок

1. **Ошибка "too many redirects"**: Проверьте настройки WP_HOME и WP_SITEURL в WordPress.

2. **Сертификат не выдается**: Убедитесь, что порты 80 и 443 открыты на вашем сервере.

3. **Логи Caddy**: Проверьте логи для диагностики проблем:
   ```bash
   docker-compose logs caddy
   ```

## Дополнительная информация

- [Документация Caddy](https://caddyserver.com/docs/)
- [Let's Encrypt](https://letsencrypt.org/)
- [WordPress HTTPS](https://wordpress.org/support/article/administration-over-ssl/) 