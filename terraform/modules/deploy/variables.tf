variable "vm_resource_id" {
  description = "ID ресурса виртуальной машины в Azure"
  type        = string
}

variable "vm_public_ip" {
  description = "Публичный IP-адрес виртуальной машины"
  type        = string
}

variable "vm_username" {
  description = "Имя пользователя для SSH-подключения к VM"
  type        = string
}

variable "ssh_private_key_path" {
  description = "Путь к файлу приватного SSH-ключа для подключения к VM"
  type        = string
}

variable "docker_username" {
  description = "Имя пользователя Docker Hub"
  type        = string
}

variable "docker_password" {
  description = "Пароль или токен Docker Hub"
  type        = string
  sensitive   = true
}

variable "domain_name" {
  description = "Доменное имя для WordPress сайта"
  type        = string
}

variable "mysql_root_password" {
  description = "Пароль root пользователя MySQL"
  type        = string
  sensitive   = true
}

variable "mysql_database" {
  description = "Имя базы данных MySQL"
  type        = string
}

variable "mysql_user" {
  description = "Имя пользователя MySQL"
  type        = string
}

variable "mysql_password" {
  description = "Пароль пользователя MySQL"
  type        = string
  sensitive   = true
}

variable "project_dir" {
  description = "Директория на VM для файлов проекта"
  type        = string
  default     = "/home/azureuser/docker_wordpress"
} 