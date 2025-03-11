#!/bin/bash
# Скрипт для подготовки существующей Azure VM к деплою через GitHub Actions

# Цвета для вывода
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}====== Подготовка Azure VM для GitHub Actions ======${NC}"

# Проверка наличия sudo прав
if [ "$EUID" -ne 0 ]; then
  echo -e "${YELLOW}Для установки некоторых компонентов потребуются права sudo.${NC}"
  echo -e "${YELLOW}Продолжить? (y/n)${NC}"
  read answer
  if [ "$answer" != "y" ]; then
    echo "Операция отменена."
    exit 1
  fi
fi

echo -e "\n${GREEN}=== 1. Обновление системы ===${NC}"
sudo apt-get update
sudo apt-get upgrade -y

echo -e "\n${GREEN}=== 2. Установка Docker ===${NC}"
if command -v docker &> /dev/null; then
  echo -e "${YELLOW}Docker уже установлен. Пропускаем...${NC}"
else
  echo "Установка Docker..."
  sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common
  curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
  sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
  sudo apt-get update
  sudo apt-get install -y docker-ce
  sudo systemctl enable docker
  sudo systemctl start docker
  echo -e "${GREEN}Docker успешно установлен!${NC}"
fi

echo -e "\n${GREEN}=== 3. Добавление текущего пользователя в группу docker ===${NC}"
sudo usermod -aG docker $USER
echo -e "${YELLOW}Примечание: Изменения группы вступят в силу после перелогинивания.${NC}"

echo -e "\n${GREEN}=== 4. Установка Docker Compose ===${NC}"
if command -v docker-compose &> /dev/null; then
  echo -e "${YELLOW}Docker Compose уже установлен. Пропускаем...${NC}"
else
  echo "Установка Docker Compose..."
  sudo curl -L "https://github.com/docker/compose/releases/download/v2.20.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
  sudo chmod +x /usr/local/bin/docker-compose
  echo -e "${GREEN}Docker Compose успешно установлен!${NC}"
fi

echo -e "\n${GREEN}=== 5. Настройка SSH для GitHub Actions ===${NC}"
mkdir -p ~/.ssh
chmod 700 ~/.ssh

echo -e "${YELLOW}Хотите создать новый SSH ключ для GitHub Actions? (y/n)${NC}"
read create_key
if [ "$create_key" = "y" ]; then
  echo "Введите email для SSH ключа (или оставьте пустым для github-actions@example.com):"
  read email
  email=${email:-github-actions@example.com}
  
  ssh-keygen -t rsa -b 4096 -C "$email" -f ~/.ssh/github_actions_key
  
  echo -e "\n${GREEN}SSH ключ создан. Публичный ключ:${NC}"
  cat ~/.ssh/github_actions_key.pub
  
  echo -e "\n${YELLOW}Добавляем публичный ключ в authorized_keys...${NC}"
  cat ~/.ssh/github_actions_key.pub >> ~/.ssh/authorized_keys
  chmod 600 ~/.ssh/authorized_keys
  
  echo -e "\n${GREEN}Теперь скопируйте ПРИВАТНЫЙ ключ и добавьте его в секреты GitHub:${NC}"
  echo -e "${YELLOW}------ Начало приватного ключа (скопируйте всё что ниже) ------${NC}"
  cat ~/.ssh/github_actions_key
  echo -e "${YELLOW}------ Конец приватного ключа ------${NC}"
else
  echo -e "${YELLOW}Пожалуйста, убедитесь, что у вас уже настроен SSH доступ для GitHub Actions.${NC}"
  echo -e "${YELLOW}Ваш публичный ключ должен быть добавлен в ~/.ssh/authorized_keys${NC}"
fi

echo -e "\n${GREEN}=== 6. Создание рабочей директории для проекта ===${NC}"
mkdir -p ~/docker_wordpress
echo "Директория ~/docker_wordpress создана."

echo -e "\n${GREEN}=== 7. Проверка портов ===${NC}"
echo -e "${YELLOW}Убедитесь, что порты 80 и 443 открыты в настройках брандмауэра Azure.${NC}"
echo -e "${YELLOW}Также убедитесь, что порт 22 (или ваш кастомный SSH порт) доступен для GitHub Actions.${NC}"

echo -e "\n${GREEN}====== Подготовка завершена! ======${NC}"
echo -e "Теперь вы можете:"
echo -e "1. Добавить приватный SSH ключ в секреты GitHub (если создали новый)"
echo -e "2. Заполнить остальные секреты в GitHub (DOCKER_USERNAME, DOCKER_PASSWORD и т.д.)"
echo -e "3. Запустить GitHub Actions workflow для деплоя"

echo -e "\n${YELLOW}Важно: Вам может потребоваться перелогиниться для применения изменений в группах пользователя.${NC}"
echo -e "${YELLOW}После перелогинивания выполните команду 'docker ps', чтобы проверить работу Docker.${NC}" 