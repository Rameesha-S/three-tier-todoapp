# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

   # --- 1. The WEB Server (Frontend) ---
  config.vm.define "web" do |web|
    web.vm.box = "ubuntu/focal64"
    web.vm.hostname = "web-server"
    web.vm.network "private_network", ip: "192.168.56.10"
    # web.vm.network "public_network", bridge: "Wi-Fi", ip: "192.168.215.51"
    web.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "0.0.0.0"   # optional fallback
    web.vm.provider "virtualbox" do |vb|
      vb.memory = "1024"
      vb.cpus = 1
    end
    web.vm.provision "shell", inline: <<-SHELL
      sudo apt-get update
      sudo apt-get install -y nginx
      sudo systemctl enable nginx
      sudo systemctl start nginx
    SHELL
  end

  # --- 2. The APP Server (Backend API) ---
  config.vm.define "app" do |app|
    app.vm.box = "ubuntu/focal64"
    app.vm.hostname = "app-server"
    app.vm.network "private_network", ip: "192.168.56.11"
   # app.vm.network "public_network", bridge: "Wi-Fi", ip: "192.168.215.50"
    app.vm.network "forwarded_port", guest: 80, host: 8081, host_ip: "0.0.0.0"   # optional fallback
    app.vm.provider "virtualbox" do |vb|
      vb.memory = "2048"
      vb.cpus = 2
    end
    # Provisioning script using PHP 7.4 (the working version)
    app.vm.provision "shell", inline: <<-SHELL
      sudo apt-get update
      sudo apt-get install -y nginx php7.4-fpm php7.4-mysql php7.4-mbstring php7.4-xml php7.4-curl php7.4-zip unzip git curl
      sudo systemctl enable nginx
      sudo systemctl start nginx
      sudo systemctl enable php7.4-fpm
      sudo systemctl start php7.4-fpm
      curl -sS https://getcomposer.org/installer | php
      sudo mv composer.phar /usr/local/bin/composer
      sudo chmod +x /usr/local/bin/composer
    SHELL
  end

  # --- 3. The DATABASE Server ---
  config.vm.define "db" do |db|
    db.vm.box = "ubuntu/focal64"
    db.vm.hostname = "db-server"
    db.vm.network "private_network", ip: "192.168.56.12"
    db.vm.provider "virtualbox" do |vb|
      vb.memory = "1024"
      vb.cpus = 1
    end
    # Provisioning script for the database server
    db.vm.provision "shell", inline: <<-SHELL
      sudo apt-get update
      sudo apt-get install -y mysql-server
      sudo systemctl enable mysql
      sudo systemctl start mysql
      # Create a database and user for our app
      sudo mysql -e "CREATE DATABASE IF NOT EXISTS todo_app;"
      sudo mysql -e "CREATE USER IF NOT EXISTS 'todo_user'@'%' IDENTIFIED BY 'password';"
      sudo mysql -e "GRANT ALL PRIVILEGES ON todo_app.* TO 'todo_user'@'%';"
      sudo mysql -e "FLUSH PRIVILEGES;"
      # Allow connections from other machines
      sudo sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
      sudo systemctl restart mysql
    SHELL
  end

  # --- 4. The CACHE Server (Redis) ---
  config.vm.define "cache" do |cache|
    cache.vm.box = "ubuntu/focal64"
    cache.vm.hostname = "cache-server"
    cache.vm.network "private_network", ip: "192.168.56.13"
    cache.vm.provider "virtualbox" do |vb|
      vb.memory = "512"
      vb.cpus = 1
    end
    # Provisioning script for the Redis cache server
    cache.vm.provision "shell", inline: <<-SHELL
      sudo apt-get update
      sudo apt-get install -y redis-server
      sudo systemctl enable redis-server
      sudo systemctl start redis-server
      # Allow connections from other machines on the private network
      sudo sed -i "s/bind 127.0.0.1/bind 0.0.0.0/g" /etc/redis/redis.conf
      sudo systemctl restart redis-server
    SHELL
  end
end