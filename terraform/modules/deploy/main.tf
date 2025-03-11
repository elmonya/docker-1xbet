# Модуль для деплоя WordPress на существующую VM через Terraform и null_resource

terraform {
  required_providers {
    null = {
      source  = "hashicorp/null"
      version = "~> 3.0"
    }
  }
}

# Используем null_resource и provisioner для настройки существующей VM
resource "null_resource" "install_docker" {
  # Запускаем только при изменении триггера
  triggers = {
    always_run = "${timestamp()}" # Для тестов можно всегда запускать
    # vm_id = var.vm_resource_id # Для продакшена лучше привязать к VM ID
  }

  # Устанавливаем Docker и Docker Compose
  provisioner "remote-exec" {
    inline = [
      "#!/bin/bash",
      "echo 'Проверка и установка Docker...'",
      "if ! command -v docker &> /dev/null; then",
      "  sudo apt-get update",
      "  sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common",
      "  curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -",
      "  sudo add-apt-repository \"deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable\"",
      "  sudo apt-get update",
      "  sudo apt-get install -y docker-ce",
      "  sudo systemctl enable docker",
      "  sudo systemctl start docker",
      "  sudo usermod -aG docker $USER",
      "fi",
      "echo 'Docker установлен!'",
      
      "echo 'Проверка и установка Docker Compose...'",
      "if ! command -v docker-compose &> /dev/null; then",
      "  sudo curl -L \"https://github.com/docker/compose/releases/download/v2.20.0/docker-compose-$(uname -s)-$(uname -m)\" -o /usr/local/bin/docker-compose",
      "  sudo chmod +x /usr/local/bin/docker-compose",
      "fi",
      "echo 'Docker Compose установлен!'"
    ]

    connection {
      type        = "ssh"
      user        = var.vm_username
      private_key = file(var.ssh_private_key_path)
      host        = var.vm_public_ip
    }
  }
}

# Создаем директорию проекта и копируем файлы
resource "null_resource" "setup_project" {
  depends_on = [null_resource.install_docker]
  
  triggers = {
    always_run = "${timestamp()}" # Для тестов можно всегда запускать
  }

  # Создаем директорию и подготавливаем проект
  provisioner "remote-exec" {
    inline = [
      "mkdir -p ${var.project_dir}",
      "mkdir -p ${var.project_dir}/logs/caddy"
    ]

    connection {
      type        = "ssh"
      user        = var.vm_username
      private_key = file(var.ssh_private_key_path)
      host        = var.vm_public_ip
    }
  }
  
  # Копируем все файлы проекта
  provisioner "file" {
    source      = "../"  # Текущая директория проекта
    destination = var.project_dir

    connection {
      type        = "ssh"
      user        = var.vm_username
      private_key = file(var.ssh_private_key_path)
      host        = var.vm_public_ip
    }
  }

  # Создаем .env файл
  provisioner "remote-exec" {
    inline = [
      "cat > ${var.project_dir}/.env << EOL",
      "DOMAIN_NAME=${var.domain_name}",
      "MYSQL_ROOT_PASSWORD=${var.mysql_root_password}",
      "MYSQL_DATABASE=${var.mysql_database}",
      "MYSQL_USER=${var.mysql_user}",
      "MYSQL_PASSWORD=${var.mysql_password}",
      "WORDPRESS_DEBUG=0",
      "DOCKER_USERNAME=${var.docker_username}",
      "EOL",
      "chmod 600 ${var.project_dir}/.env"
    ]

    connection {
      type        = "ssh"
      user        = var.vm_username
      private_key = file(var.ssh_private_key_path)
      host        = var.vm_public_ip
    }
  }
}

# Запускаем Docker контейнеры
resource "null_resource" "deploy_containers" {
  depends_on = [null_resource.setup_project]
  
  triggers = {
    always_run = "${timestamp()}" # Для тестов можно всегда запускать
  }

  provisioner "remote-exec" {
    inline = [
      "cd ${var.project_dir}",
      "echo 'Логин в Docker Hub...'",
      "echo ${var.docker_password} | docker login -u ${var.docker_username} --password-stdin",
      
      "echo 'Остановка существующих контейнеров...'",
      "docker-compose -f docker-compose.prod.yml down -v || true",
      
      "echo 'Загрузка последних образов...'",
      "docker-compose -f docker-compose.prod.yml pull",
      
      "echo 'Запуск контейнеров...'",
      "docker-compose -f docker-compose.prod.yml up -d",
      
      "echo 'Проверка статуса контейнеров...'",
      "docker-compose -f docker-compose.prod.yml ps",
      
      "echo 'Деплой успешно завершен!'"
    ]

    connection {
      type        = "ssh"
      user        = var.vm_username
      private_key = file(var.ssh_private_key_path)
      host        = var.vm_public_ip
    }
  }
} 