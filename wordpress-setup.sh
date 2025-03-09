#!/bin/bash
set -e

# Создаем директорию для логов
mkdir -p logs/caddy

# Проверяем наличие файла .env
if [ ! -f ".env" ]; then
  echo "Файл .env не найден. Создаем из примера .env.example..."
  cp .env.example .env
  echo "Пожалуйста, отредактируйте файл .env и задайте свои значения"
  exit 1
fi

# Останавливаем все контейнеры, если они уже запущены
docker-compose down -v

# Запускаем базу данных и WordPress
docker-compose up -d db wordpress caddy adminer

# Ждем, пока WordPress запустится
echo "Ожидание запуска WordPress..."
sleep 30

# Запускаем отдельно контейнер wp-cli для настройки
echo "Настройка WordPress..."
docker-compose run --rm wp-cli /bin/sh -c '
# Исправление прав доступа
echo "Настройка прав доступа..."
mkdir -p /var/www/html/wp-content/upgrade
chmod -R 755 /var/www/html/wp-content

# Установка WordPress
echo "Настройка WordPress..."
wp core install --path="/var/www/html" --url="${DOMAIN_NAME}" --title="Aviator Game Site" --admin_user=admin --admin_password=admin --admin_email=admin@example.com --skip-email || true

# Настройка темы и плагинов
echo "Активация темы..."
wp theme activate aviator-theme --path="/var/www/html" || true

echo "Установка плагинов..."
wp plugin install wordpress-importer --activate --path="/var/www/html" || true
wp plugin install wordfence --activate --path="/var/www/html" || true

echo "Настройка параметров сайта..."
wp option update blogname "1xBet Aviator" --path="/var/www/html" || true
wp option update blogdescription "Aviator Game - A Simple and Exciting Game" --path="/var/www/html" || true
wp option update permalink_structure "/%postname%/" --path="/var/www/html" || true
'

echo "Настройка WordPress завершена!"
echo "Теперь вы можете открыть свой сайт по адресу: https://localhost:8080"
echo "Панель администратора: https://localhost:8080/wp-admin/ (логин: admin, пароль: admin)"
echo "Adminer для управления базой данных: http://localhost:8080:8081" 