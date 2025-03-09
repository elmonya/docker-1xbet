#!/bin/bash
set -e

# Проверяем наличие имени пользователя Docker Hub
if [ -z "$1" ]; then
  echo "Укажите имя пользователя Docker Hub: build-and-push.sh <docker_username>"
  exit 1
fi

DOCKER_USERNAME=$1
WORDPRESS_TAG="$DOCKER_USERNAME/1xbet-aviator-wordpress:latest"
CADDY_TAG="$DOCKER_USERNAME/1xbet-aviator-caddy:latest"

# Экспортируем имя пользователя в файл .env
echo "DOCKER_USERNAME=$DOCKER_USERNAME" > .env.docker

# Собираем образы
echo "Собираем WordPress образ..."
docker build -t $WORDPRESS_TAG -f Dockerfile.wordpress .

echo "Собираем Caddy образ..."
docker build -t $CADDY_TAG -f Dockerfile.caddy .

# Логинимся в Docker Hub
echo "Авторизуемся в Docker Hub..."
docker login

# Публикуем образы
echo "Публикуем WordPress образ..."
docker push $WORDPRESS_TAG

echo "Публикуем Caddy образ..."
docker push $CADDY_TAG

echo "Образы успешно опубликованы в Docker Hub:"
echo "- $WORDPRESS_TAG"
echo "- $CADDY_TAG"
echo "Для запуска этих образов используйте: docker-compose -f docker-compose.prod.yml up -d" 