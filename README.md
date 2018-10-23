## CPagos

Herramienta desarrollada para la gestion de pagos.

---

# Requerimientos

PHP = ^7.1
Base de Datos = MongoDB
Pusher Account


# Instalacion
Clonar el repositorio
```php
git clone 
```
Ejecutar en la carpeta raiz

```php
composer install
```

Generar archivo .env y generar una llave para el proyecto

```php
php artisan key:generate
```

Configurar archivo .env

Base de Datos
```php
DB_CONNECTION=mongodb

MONGO_DB_DATABASE="nombre de BD"
MONGO_DB_USERNAME="usuario"
MONGO_DB_PASSWORD="contraseña"
```

Controlador de Eventos

```php
BROADCAST_DRIVER=pusher

PUSHER_APP_ID="tu id pusher"
PUSHER_APP_KEY="tu key pusher"
PUSHER_APP_SECRET="tu contraseña pusher"
PUSHER_APP_CLUSTER="cluster pusher"
```

Correo Electronico

```php
MAIL_HOST=smtp.mailtrap.io //servidor de correo electronico sea smtp, sendmail, mailgun
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
```

Primer Usuario

Ejecutar el siguiente comando en la consola (puede configurar el usuario en el archivo database/seeds/DatabaseSeeder.php)

```php
php artisan db:seed
```

# Documentation

Proximamente

# License

This package is licensed under MIT. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!