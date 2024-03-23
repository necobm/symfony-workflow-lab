# Symfony Workflows Lab

## Description

This is a testing project with the purpose of showcase some practical use cases for using Symfony Workflows Bundle ()
into our projects.

## Local Environment

- `nginx`, as reverse proxy server.
- `php`, the PHP-FPM container with the 8.2 version of PHP.
- `db` which is the MySQL database container with a **MySQL 8.0** image.

## Installation

1. 😀 Clone this repo.

2. Create the file `./.docker/.env.nginx.local` using `./.docker/.env.nginx` as template. The value of the variable `NGINX_BACKEND_DOMAIN` is the `server_name` used in NGINX.
3. Use the following value for the DATABASE_URL environment variable:

```
DATABASE_URL=mysql://app_user:helloworld@db:3306/app_db?serverVersion=8.0.33&charset=utf8mb4
```

4. Go inside folder `./docker` and run `docker compose up -d` to start containers.

5. You should work inside the `php` container. This project is configured to work with [Remote Container](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) extension for Visual Studio Code, so you could run `Reopen in container` command after open the project.

6. Inside the `php` container, run `composer install` to install dependencies from `/var/www/symfony` folder.

