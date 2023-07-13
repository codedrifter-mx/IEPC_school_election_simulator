# Desarrollo del simulador de elecciones escolares en modo virtual

Este proyecto es una aplicación web que permite la documentacion virtual y simulacion de elecciones escolares de manera digital, esto permite que las escuelas puedan organizar elecciones mientras que el IEPC pueda monitorear estas actividades.

Puedes interactuar aqui: https://iepcdurango.mx/school_election_simulator-main/project/public/index.php

Alternativa AWS: http://schoolelectionsimulator-env.eba-vximfvvp.us-east-1.elasticbeanstalk.com/

## Tech Stack

* Laravel 9 (PHP 8.1)
* Tailwind CSS
* AWS (BeanStalk, S3, EC2, RDS)
* MySQL 8.0
* Apache web server
* Docker
* Windows 11 WSL 2
* JetBrains PHPstorm as IDE

## Local Build
After cloning the project, follow these steps to set it up locally (WSL enviroment):

Install PHP and extensions:
```bash
sudo apt install php php-intl php-zip php-simplexml php-dom php-gd php-xml php-curl
```

Download Composer.

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'EXPECTED_SHA384_CHECKSUM') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
```

Install dependencies:

```bash
php composer.phar install
```

Ensure that you have the .env file (if don't, copy .env.example)

Check the config/database.php file to determine whether you are using local MySQL or AWS RDS:


```php
'mysql' => [
'driver' => 'mysql',
'url' => env('DATABASE_URL'),
'host' => env('DB_HOST', '127.0.0.1'),
'port' => env('DB_PORT', '3306'),
'database' => env('DB_DATABASE', 'forge'),
'username' => env('DB_USERNAME', 'forge'),
'password' => env('DB_PASSWORD', ''),
'unix_socket' => env('DB_SOCKET', ''),
'charset' => 'utf8mb4',
'collation' => 'utf8mb4_unicode_ci',
'prefix' => '',
'prefix_indexes' => true,
'strict' => true,
'engine' => null,
'options' => extension_loaded('pdo_mysql') ? array_filter([
PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
]) : [],
],

// Comment either one or other

// 'mysql' => [
//     'driver' => 'mysql',
//     'host' => env('RDS_HOSTNAME', '127.0.0.1'),
//     'port' => env('RDS_PORT', '3306'),
//     'database' => env('RDS_DB_NAME', 'forge'),
//     'username' => env('RDS_USERNAME', 'forge'),
//     'password' => env('RDS_PASSWORD', ''),
//     'unix_socket' => env('DB_SOCKET', ''),
//     'charset' => 'utf8mb4',
//     'collation' => 'utf8mb4_unicode_ci',
//     'prefix' => '',
//     'strict' => true,
//     'engine' => null,
// ],
```

4. Use Sail to run the project (Docker needed):

```bash
./vendor/bin/sail up

./vendor/bin/sail php artisan migrate:fresh --seed

./vendor/bin/sail npm install

./vendor/bin/sail npm run build
```

5. Migrate the tables 

```bash
./vendor/bin/sail php artisan migrate:fresh --seed
```

6. Go to http://localhost/ on navigator, You can use preregister users like a@a.com (school) or e@e.com (IEPC), password for them are 12345678

# AWS Production

To set a production environment, I used AWS BeanStalk, so first, you got to create and BeanStalk's instance and upload the .zip of the whole project.

Change the .env keys, users and databases names to work properly

```bash
zip -r project.zip .
```

In case that you are using other environment, set up an Apache web server and point to the /public/index.php

## Considerations/Troubleshoots

#### Font missing

You must check that the contents of /fpdf/font/* are included in: /vendor/setasign/fpdf/font

#### MySQL container not working

```bash
docker-compose down --volumes
./vendor/bin/sail sail up --build
```

#### Local enviroment too slow

Either completely mount it on native Windows (XAMPP\LAMP) or Linux environment, if not, try this:
https://stackoverflow.com/questions/63036490/docker-is-extremely-slow-when-running-laravel-on-nginx-container-wsl2
