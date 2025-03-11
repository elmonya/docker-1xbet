# Настройка GitHub Actions для деплоя на Azure VM

Этот документ описывает процесс настройки GitHub Actions для автоматического развертывания проекта на виртуальной машине Azure.

## Требования

- GitHub репозиторий с кодом проекта
- Доступ к виртуальной машине Azure с установленным Docker и docker-compose
- Учетная запись Docker Hub для хранения образов

## Шаг 1: Добавление секретов в GitHub

В репозитории GitHub перейдите в раздел Settings -> Secrets and variables -> Actions и добавьте следующие секреты:

### Для Docker Hub

- `DOCKER_USERNAME`: Имя пользователя Docker Hub
- `DOCKER_PASSWORD`: Пароль или токен Docker Hub

### Для базы данных

- `MYSQL_ROOT_PASSWORD`: Пароль root пользователя MySQL
- `MYSQL_DATABASE`: Имя базы данных MySQL
- `MYSQL_USER`: Имя пользователя MySQL
- `MYSQL_PASSWORD`: Пароль пользователя MySQL

### Для WordPress

- `DOMAIN_NAME`: Доменное имя вашего сайта (например, 1xbet-install.com)

### Для подключения к Azure VM

- `AZURE_VM_HOST`: IP-адрес или имя хоста вашей виртуальной машины Azure
- `AZURE_VM_USERNAME`: Имя пользователя для подключения к VM
- `AZURE_VM_SSH_KEY`: Приватный SSH-ключ для подключения к VM (полное содержимое файла)
- `AZURE_VM_SSH_PORT`: Порт SSH (обычно 22)

## Шаг 2: Настройка SSH-доступа к Azure VM

1. Создайте пару SSH-ключей, если у вас её ещё нет:
   ```bash
   ssh-keygen -t rsa -b 4096 -C "github-actions"
   ```

2. Добавьте публичный ключ в файл `~/.ssh/authorized_keys` на вашей VM:
   ```bash
   # На локальном компьютере
   cat ~/.ssh/id_rsa.pub | ssh username@your-vm-ip "cat >> ~/.ssh/authorized_keys"
   ```

3. Настройте разрешения для директории `.ssh` и файла `authorized_keys` на VM:
   ```bash
   chmod 700 ~/.ssh
   chmod 600 ~/.ssh/authorized_keys
   ```

4. Добавьте приватный ключ (содержимое файла `~/.ssh/id_rsa`) в секрет `AZURE_VM_SSH_KEY` в GitHub.

## Шаг 3: Подготовка VM для деплоя

1. Установите Docker и docker-compose на вашей VM:
   ```bash
   # Установка Docker
   sudo apt-get update
   sudo apt-get install -y docker.io
   sudo systemctl enable docker
   sudo systemctl start docker
   
   # Добавление пользователя в группу docker
   sudo usermod -aG docker $USER
   
   # Установка docker-compose
   sudo curl -L "https://github.com/docker/compose/releases/download/v2.18.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
   sudo chmod +x /usr/local/bin/docker-compose
   ```

2. Создайте целевую директорию для проекта:
   ```bash
   mkdir -p ~/docker_wordpress
   ```

## Шаг 4: Запуск рабочего процесса GitHub Actions

1. Убедитесь, что файл `.github/workflows/deploy.yml` добавлен в ваш репозиторий.

2. Отправьте изменения в ветку `main` вашего репозитория:
   ```bash
   git add .
   git commit -m "Add GitHub Actions workflow for deployment"
   git push origin main
   ```

3. Перейдите в раздел "Actions" вашего репозитория на GitHub, чтобы увидеть запущенный рабочий процесс.

## Шаг 5: Ручной запуск деплоя

Вы также можете запустить деплой вручную через GitHub Actions:

1. Перейдите в раздел "Actions" вашего репозитория
2. Выберите рабочий процесс "Build and Deploy to Azure VM"
3. Нажмите кнопку "Run workflow"
4. Выберите ветку и, если нужно, окружение развертывания (staging или production)
5. Нажмите "Run workflow"

## Устранение неполадок

### Проблемы с доступом по SSH

Если GitHub Actions не может подключиться к вашей VM:

1. Проверьте правильность значений `AZURE_VM_HOST`, `AZURE_VM_USERNAME` и `AZURE_VM_SSH_PORT`
2. Убедитесь, что приватный ключ в секрете `AZURE_VM_SSH_KEY` соответствует публичному ключу в `~/.ssh/authorized_keys` на VM
3. Проверьте настройки брандмауэра VM, чтобы разрешить входящие подключения по SSH

### Проблемы с Docker Hub

Если не удается отправить образы в Docker Hub:

1. Проверьте правильность значений `DOCKER_USERNAME` и `DOCKER_PASSWORD`
2. Убедитесь, что токен Docker Hub (если используется вместо пароля) имеет права на запись

### Проблемы с запуском контейнеров

Если контейнеры не запускаются после деплоя:

1. Подключитесь к VM по SSH и проверьте логи:
   ```bash
   cd ~/docker_wordpress
   docker-compose -f docker-compose.prod.yml logs
   ```

2. Проверьте статус контейнеров:
   ```bash
   docker-compose -f docker-compose.prod.yml ps
   ```

3. Проверьте настройки в файле .env 