terraform {
  required_providers {
    azurerm = {
      source  = "hashicorp/azurerm"
      version = "~> 3.0"
    }
  }
  
  # Если хотите использовать Terraform Cloud или хранилище состояния Azure, раскомментируйте:
  # backend "azurerm" {
  #   resource_group_name  = "terraform-state-rg"
  #   storage_account_name = "terraformstate1xbet"
  #   container_name       = "tfstate"
  #   key                  = "wordpress.terraform.tfstate"
  # }
}

provider "azurerm" {
  features {}
}

# Для существующей VM мы будем использовать data source
data "azurerm_virtual_machine" "wordpress_vm" {
  name                = var.vm_name
  resource_group_name = var.resource_group_name
}

# Модуль для деплоя WordPress на существующую VM
module "wordpress_deploy" {
  source = "./modules/deploy"
  
  vm_resource_id       = data.azurerm_virtual_machine.wordpress_vm.id
  vm_public_ip         = var.vm_public_ip
  vm_username          = var.vm_username
  ssh_private_key_path = var.ssh_private_key_path
  
  docker_username      = var.docker_username
  docker_password      = var.docker_password
  domain_name          = var.domain_name
  
  mysql_root_password  = var.mysql_root_password
  mysql_database       = var.mysql_database
  mysql_user           = var.mysql_user
  mysql_password       = var.mysql_password
  
  project_dir          = "/home/${var.vm_username}/docker_wordpress"
} 