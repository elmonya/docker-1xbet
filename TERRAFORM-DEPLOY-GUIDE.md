# Руководство по деплою на Azure VM с помощью Terraform

Этот документ описывает настройку автоматизированного деплоя WordPress проекта на существующую Azure VM с использованием Terraform и GitHub Actions.

## Почему Terraform?

Terraform позволяет описать инфраструктуру в виде кода (Infrastructure as Code), что дает следующие преимущества:

1. **Воспроизводимость** - конфигурация инфраструктуры хранится в виде кода и может быть воспроизведена в любой момент.
2. **История изменений** - все изменения в инфраструктуре отслеживаются в системе контроля версий.
3. **Автоматизация** - интеграция с CI/CD снижает время на ручные операции.
4. **Документация** - код Terraform служит документацией по инфраструктуре.

## Предварительные требования

1. **Существующая VM в Azure** с установленной Ubuntu/Debian
2. **Service Principal в Azure** для работы Terraform
3. **Аккаунт GitHub** с настроенным репозиторием для проекта
4. **Аккаунт Docker Hub** для хранения образов Docker

## Секреты и переменные для GitHub Actions

Добавьте следующие секреты в настройках вашего GitHub репозитория (Settings → Secrets and variables → Actions):

### Доступ к Azure

- `AZURE_CLIENT_ID` - ID клиента Service Principal для Terraform
- `AZURE_CLIENT_SECRET` - Секрет клиента Service Principal
- `AZURE_SUBSCRIPTION_ID` - ID подписки Azure
- `AZURE_TENANT_ID` - ID арендатора Azure

### Информация о VM

- `AZURE_RESOURCE_GROUP` - Имя ресурсной группы, где находится VM
- `AZURE_VM_NAME` - Имя виртуальной машины в Azure
- `AZURE_VM_HOST` - Публичный IP-адрес VM
- `AZURE_VM_USERNAME` - Имя пользователя для SSH-подключения
- `AZURE_VM_SSH_KEY` - Приватный SSH-ключ для подключения (всё содержимое файла)

### Docker Hub

- `DOCKER_USERNAME` - Имя пользователя Docker Hub
- `DOCKER_PASSWORD` - Пароль или токен Docker Hub

### Настройки для WordPress и MySQL

- `DOMAIN_NAME` - Доменное имя вашего сайта
- `MYSQL_ROOT_PASSWORD` - Пароль для пользователя root MySQL
- `MYSQL_DATABASE` - Имя базы данных
- `MYSQL_USER` - Имя пользователя базы данных
- `MYSQL_PASSWORD` - Пароль пользователя базы данных

## Настройка Service Principal в Azure

Для работы Terraform с Azure требуется Service Principal:

```bash
# Войдите в Azure CLI
az login

# Получите ID вашей подписки
az account list --output table

# Создайте Service Principal с правами Contributor на вашу подписку
az ad sp create-for-rbac --name "TerraformSP" --role Contributor --scopes /subscriptions/YOUR_SUBSCRIPTION_ID

# В выводе команды будут ID клиента, секрет и другие данные, которые нужно сохранить в секретах GitHub
```

## Как запустить деплой

### Первоначальная настройка

1. Клонируйте репозиторий на локальную машину:
   ```bash
   git clone https://github.com/yourusername/docker_wordpress.git
   cd docker_wordpress
   ```

2. Убедитесь, что структура проекта содержит папку `terraform` с конфигурационными файлами.

3. Создайте файл `terraform/terraform.tfvars` на основе примера:
   ```bash
   cp terraform/terraform.tfvars.example terraform/terraform.tfvars
   # Отредактируйте значения в файле
   ```

4. Проверьте конфигурацию локально:
   ```bash
   cd terraform
   terraform init
   terraform plan
   ```

5. Если план выглядит правильно, отправьте изменения в GitHub:
   ```bash
   git add .
   git commit -m "Add Terraform configuration for deployment"
   git push origin main
   ```

### Ручной запуск через GitHub Actions

1. В репозитории перейдите в раздел "Actions"
2. Выберите workflow "Terraform Deploy to Azure VM"
3. Нажмите "Run workflow"
4. Выберите ветку main
5. Нажмите "Run workflow"

### Автоматический запуск

GitHub Actions будет автоматически запускать деплой при push-событиях в ветку main, если были изменены:
- Файлы в директории `terraform/`
- Файл `docker-compose.prod.yml`
- Файлы `Dockerfile.*`
- Сам файл workflow `.github/workflows/terraform-deploy.yml`

## Структура Terraform конфигурации

Проект использует следующие файлы Terraform:

- `main.tf` - Основная конфигурация, описывающая провайдеры и модули
- `variables.tf` - Объявление переменных
- `terraform.tfvars` - Конкретные значения переменных (не хранятся в репозитории)
- `modules/deploy/main.tf` - Модуль для деплоя на существующую VM
- `modules/deploy/variables.tf` - Переменные модуля

## Поиск и устранение неисправностей

### Проблемы с подключением к Azure

Проверьте правильность следующих секретов:
- `AZURE_CLIENT_ID`, `AZURE_CLIENT_SECRET`, `AZURE_SUBSCRIPTION_ID`, `AZURE_TENANT_ID`

### Проблемы с SSH-подключением к VM

1. Убедитесь, что VM запущена и доступна по IP-адресу
2. Проверьте, что приватный ключ в `AZURE_VM_SSH_KEY` соответствует публичному ключу на VM
3. Проверьте имя пользователя в `AZURE_VM_USERNAME`

### Ошибки Terraform

Большинство ошибок Terraform будут отображены в логах GitHub Actions. Для детального анализа:

1. Скачайте лог выполнения из GitHub Actions
2. Проверьте состояние Terraform на временной машине runner
3. При необходимости, выполните команды локально для отладки

## Дополнительные возможности

### Управление состоянием Terraform в Azure Storage

Для совместной работы над проектом рекомендуется хранить состояние Terraform в Azure Storage:

1. Создайте Storage Account и Container в Azure
2. Раскомментируйте блок backend в `main.tf` и укажите правильные значения
3. Добавьте необходимые секреты для доступа к Storage Account в GitHub 