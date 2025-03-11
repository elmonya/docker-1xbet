variable "vm_resource_id" {
  description = "82aa94ac-50f1-4c46-af94-c387f9a717c4"
  type        = string
}

variable "vm_public_ip" {
  description = "40.69.45.51"
  type        = string
}

variable "vm_username" {
  description = "azureuser"
  type        = string
}

variable "ssh_private_key_path" {
  description = "/home/serkas/.ssh/id_rsa.pub"
  type        = string
}

variable "docker_username" {
  description = "skas"
  type        = string
}

variable "docker_password" {
  description = "Monya01"
  type        = string
  sensitive   = true
}

variable "domain_name" {
  description = "1xbet-install.com"
  type        = string
}

variable "mysql_root_password" {
  description = "password"
  type        = string
  sensitive   = true
}

variable "mysql_database" {
  description = "wordpress"
  type        = string
}

variable "mysql_user" {
  description = "root"
  type        = string
}

variable "mysql_password" {
  description = "password"
  type        = string
  sensitive   = true
}

variable "project_dir" {
  description = "Директория на VM для файлов проекта"
  type        = string
  default     = "/home/azureuser/docker_wordpress"
} 