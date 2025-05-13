# LAMP stack built with Docker Compose
template by [SprintCube](https://www.sprintcube.com/)

A basic LAMP stack environment built using Docker Compose. It consists of the following:

- PHP
- Apache
- MySQL
- phpMyAdmin
- MongoDB

```bash
cp sample.env .env
# modify sample.env as needed
docker compose up -d
```

Your LAMP stack is now ready!! You can access it via `http://localhost`.

## Configuration and Usage

### General Information

This Docker Stack is build for local development and not for production usage.

### Configuration

This package comes with default configuration options. You can modify them by creating `.env` file in your root directory.
To make it easy, just copy the content from `sample.env` file and update the environment variable values as per your need.

### Configuration Variables

There are following configuration variables available and you can customize them by overwritting in your own `.env` file.

---

#### PHP

---

_**PHPVERSION**_
Is used to specify which PHP Version you want to use. Defaults always to latest PHP Version.

_**PHP_INI**_
Define your custom `php.ini` modification to meet your requirments.

---

#### Apache

---

_**DOCUMENT_ROOT**_

It is a document root for Apache server. The default value for this is `./scripts`. All your sites will go here and will be synced automatically.

_**APACHE_DOCUMENT_ROOT**_

Apache config file value. The default value for this is `/var/www/html`.

_**VHOSTS_DIR**_

This is for virtual hosts. The default value for this is `./docker/config/vhosts`. You can place your virtual hosts conf files here.

> Make sure you add an entry to your system's `hosts` file for each virtual host.

_**APACHE_LOG_DIR**_

This will be used to store Apache logs. The default value for this is `./docker/logs/apache2`.

---

#### Database

---

> For Apple Silicon Users:
> Please select Mariadb as Database. Oracle doesn't build their SQL Containers for the arm Architecture

_**MYSQL_INITDB_DIR**_

When a container is started for the first time files in this directory with the extensions `.sh`, `.sql`, `.sql.gz` and
`.sql.xz` will be executed in alphabetical order. `.sh` files without file execute permission are sourced rather than executed.
The default value for this is `./docker/config/initdb`.

_**MYSQL_DATA_DIR**_

This is MySQL data directory. The default value for this is `./docker/data/mysql`. All your MySQL data files will be stored here.

_**MYSQL_LOG_DIR**_

This will be used to store Apache logs. The default value for this is `./docker/logs/mysql`.

## Web Server

Apache is configured to run on port 80. So, you can access it via `http://localhost`.

#### Connect via SSH

You can connect to web server using `docker compose exec` command to perform various operation on it. Use below command to login to container via ssh.

```shell
docker compose exec webserver bash
```

#### Extensions

Following extensions are installed.

- mysqli
- pdo_sqlite
- pdo_mysql
- mbstring
- zip
- intl
- mcrypt
- curl
- json
- iconv
- xml
- xmlrpc
- gd
- mongodb

> If you want to install more extension, just update `./docker/bin/webserver/Dockerfile`. You can also generate a PR and we will merge if it seems good for general purpose.
> You have to rebuild the docker image by running `docker compose build` and restart the docker containers.

## phpMyAdmin

phpMyAdmin is configured to run on port 8080. Use following default credentials.

http://localhost:8080/  
username: root  
password: root
