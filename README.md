# 1xBet Aviator - WordPress в Docker с Terraform и GitHub Actions

Проект представляет собой полностью автоматизированное развертывание WordPress сайта с темой Aviator, использующий Docker для контейнеризации, Terraform для управления инфраструктурой и GitHub Actions для CI/CD.

## Особенности проекта

- WordPress с предустановленной темой Aviator
- Caddy сервер с автоматическим HTTPS
- Docker контейнеризация всех компонентов
- Terraform для управления инфраструктурой как код
- GitHub Actions для автоматического деплоя
- Единый файл переменных окружения для всех компонентов

## Быстрый старт

### Локальная разработка

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/yourusername/docker-1xbet-aviator.git
   cd docker-1xbet-aviator
   ```

2. Создайте файл `.env` на основе шаблона:
   ```bash
   cp .env.template .env
   # Отредактируйте значения в .env файле
   ```

3. Запустите контейнеры:
   ```bash
   docker-compose up -d
   ```

4. Откройте сайт в браузере: http://localhost:8080

### Деплой на Azure VM

1. Подготовьте виртуальную машину Azure с Ubuntu/Debian

2. Настройте переменные окружения в файле `.env`

3. Загрузите переменные в GitHub Actions:
   ```bash
   ./load-env-to-github.sh
   ```

4. Отправьте изменения в GitHub:
   ```bash
   git add .
   git commit -m "Initial setup"
   git push origin main
   ```

5. GitHub Actions автоматически запустит деплой или запустите workflow вручную через интерфейс GitHub

## Структура проекта

```
.
├── .env.template - Шаблон переменных окружения
├── docker-compose.yml - Конфигурация для разработки
├── docker-compose.prod.yml - Конфигурация для продакшена
├── Dockerfile.wordpress - Сборка WordPress с темой Aviator
├── Dockerfile.caddy - Настройка Caddy сервера
├── Caddyfile - Конфигурация Caddy
├── setup-wordpress.sh - Скрипт настройки WordPress
├── load-env-to-github.sh - Скрипт загрузки переменных в GitHub
├── terraform/ - Конфигурация Terraform
│   ├── main.tf - Основные настройки и модули
│   ├── variables.tf - Определения переменных
│   └── modules/deploy/ - Модуль для развертывания
└── .github/workflows/ - GitHub Actions
    └── terraform-deploy.yml - Workflow для Terraform
```

## Управление переменными окружения

Проект использует единый файл `.env` для всех переменных. Категории переменных:

- **Основные настройки**: домен, окружение
- **Docker**: учетные данные Docker Hub, версии образов
- **MySQL**: настройки базы данных
- **WordPress**: учетные данные администратора
- **Ресурсы контейнеров**: лимиты памяти и CPU
- **Azure**: настройки для Terraform и Service Principal

### Загрузка переменных в GitHub Actions

Для автоматического деплоя через GitHub Actions необходимо загрузить переменные окружения в секреты репозитория. Используйте скрипт `load-env-to-github.sh`:

```bash
# Установите GitHub CLI, если еще не установлен
# https://cli.github.com/manual/installation

# Авторизуйтесь в GitHub
gh auth login

# Запустите скрипт загрузки переменных
./load-env-to-github.sh
```

## Terraform и инфраструктура

Terraform используется для управления инфраструктурой и деплоя на существующую Azure VM:

1. **Подготовка Service Principal**:
   ```bash
   az login
   az account list --output table
   az ad sp create-for-rbac --name "TerraformSP" --role Contributor \
     --scopes /subscriptions/YOUR_SUBSCRIPTION_ID
   ```

2. **Локальное тестирование Terraform**:
   ```bash
   cd terraform
   terraform init
   terraform plan
   terraform apply
   ```

## GitHub Actions

Проект включает два рабочих процесса GitHub Actions:

1. **terraform-deploy.yml** - Деплой с использованием Terraform
   - Запускается при изменении файлов в директории `terraform/`
   - Строит и публикует Docker образы
   - Применяет Terraform конфигурацию

## Устранение неисправностей

### Проблемы с переменными окружения

Убедитесь, что все необходимые переменные определены в файле `.env` и загружены в GitHub Actions.

### Ошибки Terraform

Проверьте логи GitHub Actions и выполните локальное тестирование:
```bash
cd terraform
terraform init
terraform plan
```

### Проблемы с Docker

Проверьте статус контейнеров и логи:
```bash
docker-compose ps
docker-compose logs
```

## Лицензия

MIT 