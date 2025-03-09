# 1xBet Aviator Docker Project

Этот проект предоставляет настроенную среду Docker для развертывания сайта 1xBet Aviator с использованием WordPress и Caddy в качестве веб-сервера с поддержкой HTTPS.

## Особенности

- WordPress с преднастроенной темой Aviator
- Caddy сервер с автоматическим получением SSL-сертификатов
- Оптимизированные Docker-образы по лучшим практикам
- Полностью настраиваемое окружение через переменные окружения

## Требования

- Docker 19.03+
- Docker Compose 1.27+
- Доступ к Docker Hub для публикации образов

## Быстрый старт

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/yourusername/docker-1xbet-aviator.git
   cd docker-1xbet-aviator
   ```

2. Создайте файл .env на основе примера:
   ```bash
   cp .env.example .env
   # Отредактируйте значения в .env файле
   ```

3. Соберите и опубликуйте образы:
   ```bash
   ./build-and-push.sh yourusername
   ```

4. Запустите контейнеры:
   ```bash
   docker-compose -f docker-compose.prod.yml up -d
   ```

5. Откройте сайт в браузере: https://ваш-домен/

## Документация

- [Документация по лучшим практикам Docker](DOCKER-BEST-PRACTICES.md)
- [Инструкция по настройке HTTPS](README-HTTPS.md)
- [Руководство по продакшн-окружению](README-PRODUCTION.md)

## Структура проекта

```
.
├── Dockerfile.wordpress - Dockerfile для WordPress с темой Aviator
├── Dockerfile.caddy - Dockerfile для Caddy сервера
├── docker-compose.yml - Файл Docker Compose для разработки
├── docker-compose.prod.yml - Файл Docker Compose для продакшна
├── Caddyfile - Конфигурация Caddy
├── setup-wordpress.sh - Скрипт настройки WordPress
├── build-and-push.sh - Скрипт сборки и публикации образов
└── wp-content/ - Контент WordPress (темы, плагины)
```

## Лицензия

MIT 