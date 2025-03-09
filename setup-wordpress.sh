#!/bin/bash
set -eo pipefail

# Функция для логирования
log() {
  echo "$(date '+%Y-%m-%d %H:%M:%S') - $1"
}

# Функция для обработки ошибок
handle_error() {
  log "ОШИБКА: Произошла ошибка в строке $1"
  exit 1
}

# Установка trap для перехвата ошибок
trap 'handle_error $LINENO' ERR

# Функция для проверки подключения к базе данных
wait_for_db() {
  log "Проверка подключения к базе данных..."
  local retries=30
  local wait_time=2
  
  if [ -z "$WORDPRESS_DB_HOST" ]; then
    log "ОШИБКА: Не указан хост базы данных (WORDPRESS_DB_HOST)"
    exit 1
  fi
  
  while ! mysql -h"$WORDPRESS_DB_HOST" -u"$WORDPRESS_DB_USER" -p"$WORDPRESS_DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1; do
    retries=$((retries - 1))
    if [ $retries -eq 0 ]; then
      log "ОШИБКА: Не удалось подключиться к базе данных после нескольких попыток"
      exit 1
    fi
    log "База данных недоступна, повторная попытка через $wait_time секунд... (осталось попыток: $retries)"
    sleep $wait_time
  done
  
  log "Соединение с базой данных установлено"
}

# Функция для настройки WordPress
setup_wordpress() {
  log "Начало настройки WordPress..."
  
  # Проверяем, установлен ли уже WordPress
  if wp --allow-root core is-installed; then
    log "WordPress уже установлен"
    return 0
  fi
  
  log "Установка WordPress..."
  # Установка WordPress с безопасными параметрами
  wp --allow-root core install \
    --url="${WORDPRESS_SITE_URL:-https://1xbet-install.com}" \
    --title="Aviator Game Site" \
    --admin_user="$WORDPRESS_ADMIN_USER" \
    --admin_password="$WORDPRESS_ADMIN_PASSWORD" \
    --admin_email="${WORDPRESS_ADMIN_EMAIL:-admin@example.com}" \
    --skip-email
  
  # Активируем тему
  log "Активация темы aviator-theme..."
  wp --allow-root theme activate aviator-theme
  
  # Активируем плагины
  log "Активация плагинов..."
  wp --allow-root plugin activate wordpress-importer
  wp --allow-root plugin activate wordfence
  
  # Настраиваем основные параметры сайта
  log "Настройка параметров сайта..."
  wp --allow-root option update blogname "1xBet Aviator"
  wp --allow-root option update blogdescription "Aviator Game - A Simple and Exciting Game"
  wp --allow-root option update permalink_structure "/%postname%/"
  
  # Обновляем настройки безопасности
  log "Настройка параметров безопасности..."
  wp --allow-root option update blog_public 0
  
  # Импортируем демо-контент, если файл существует
  local demo_file="/var/www/html/wp-content/themes/aviator-theme/demo-content.xml"
  if [ -f "$demo_file" ]; then
    log "Импорт демо-контента..."
    wp --allow-root import "$demo_file" --authors=create
    log "Демо-контент успешно импортирован"
  else
    log "Файл демо-контента не найден: $demo_file"
  fi
  
  log "Настройка WordPress завершена успешно"
}

# Проверяем наличие переменных окружения с паролями
if [ -z "$WORDPRESS_ADMIN_PASSWORD" ]; then
  WORDPRESS_ADMIN_PASSWORD="$(openssl rand -base64 12)"
  log "ВНИМАНИЕ: Установлен случайный пароль для администратора WordPress: $WORDPRESS_ADMIN_PASSWORD"
fi

if [ -z "$WORDPRESS_ADMIN_USER" ]; then
  WORDPRESS_ADMIN_USER="admin"
fi

# Основные функции
if [ ! -z "$WORDPRESS_DB_HOST" ]; then
  wait_for_db
  setup_wordpress
else
  log "Пропуск настройки WordPress - не найдены переменные окружения для базы данных"
fi

# Продолжаем обычный запуск
log "Запуск основного процесса..."
exec "$@" 