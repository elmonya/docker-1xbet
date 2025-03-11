#!/bin/bash
# Скрипт для загрузки переменных окружения из .env в GitHub Actions
# Требуется установленный GitHub CLI (gh)

set -e

# Проверяем наличие файла .env
if [ ! -f ".env" ]; then
  echo "Ошибка: Файл .env не найден!"
  echo "Создайте файл .env на основе .env.template"
  exit 1
fi

# Проверяем наличие GitHub CLI
if ! command -v gh &> /dev/null; then
  echo "Ошибка: GitHub CLI (gh) не установлен!"
  echo "Установите GitHub CLI: https://cli.github.com/manual/installation"
  exit 1
fi

# Проверяем авторизацию в GitHub
if ! gh auth status &> /dev/null; then
  echo "Вы не авторизованы в GitHub CLI. Авторизуйтесь с помощью команды:"
  echo "gh auth login"
  exit 1
fi

# Получаем имя репозитория
REPO=$(gh repo view --json nameWithOwner -q .nameWithOwner)
if [ -z "$REPO" ]; then
  echo "Не удалось определить текущий репозиторий."
  echo "Убедитесь, что вы находитесь в директории с Git репозиторием."
  exit 1
fi

echo "Загрузка переменных окружения из .env в репозиторий $REPO"
echo "Это может занять некоторое время..."

# Загружаем каждую переменную из .env в GitHub Actions secrets
while IFS= read -r line || [[ -n "$line" ]]; do
  # Пропускаем комментарии и пустые строки
  if [[ "$line" =~ ^#.*$ ]] || [[ -z "${line// }" ]]; then
    continue
  fi

  # Извлекаем ключ и значение
  key=$(echo "$line" | cut -d= -f1)
  value=$(echo "$line" | cut -d= -f2-)

  # Загружаем секрет
  echo "Загрузка $key..."
  echo "$value" | gh secret set "$key" --repo="$REPO"
done < .env

echo ""
echo "✅ Готово! Все переменные окружения загружены в GitHub Actions secrets."
echo "   Теперь вы можете использовать их в ваших рабочих процессах GitHub Actions." 