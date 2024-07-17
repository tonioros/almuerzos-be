# Almuerzos API

Proyecto hecho con Laravel v10 como prueba tecnica para Alegra, este API servira **end-points para Ordenes, Recetas, y
Ingredientes para las recetas** ademas de generar un contendor que servira como **Queue Worker para la cocina**

Para probar los servicios de este API puedes descargar
esta [Coleccion de Postman](https://api.postman.com/collections/3367375-8966348e-3304-4e3f-bf67-10411019d3d4?access_key=PMAT-01J2W61M5JM4SWXRCF3XD344CK)

Si quieres puedes seguir este tutorial para importarlo en
Postman [How to Import/Export Collection Data in Postman](https://apidog.com/blog/how-to-import-export-postman-collection-data/)

## Instalacion

### Docker Container

Este proyecto esta contenido en dos contenedores de Docker


#### API Container
Para hacer build image para el API ejecuta el siguiente comando, esto puede tardar unos minutos

`docker build -t tonioros/almuerzos:latest -f Dockerfile .`

Para iniciar container del API:

`docker run --name=almuerzos -v /php/local.ini:/usr/local/etc/php/conf.d/local.ini -v "$(PWD)/almuerzos:/var/www" -e SERVICE_NAME=app -e SERVICE_TAGS=dev --restart unless-stopped -p 8081:80 -p 442:443 tonioros/almuerzos:latest`

#### Queue worker Container

Para generar el build image para el Queue Worker para la cocina ejecuta este comando:
`docker build -t tonioros/almuerzos-queue:latest -f DockerfileQueue .`

para iniciar container del Queue Worker

`docker run --name=almuerzos-queue tonioros/almuerzos-queue:latest`


Con esto tendras iniciado el proyecto y corriendo dentro de la imagen generada por ti

Con el comando `docker ps` podras ver los container que estan corriendo

Para ejecutar comandos de Laravel (php artisan... y otros) puedes usar el commando `docker exec -it almuerzos /bin/bash` para iniciar una Bash

### Instalar MySQL

Si sabes usar Docker puedes descargar un Container de MySQL
aca: [crear un contenedor con Docker-Mysql](https://platzi.com/tutoriales/1432-docker-2018/3268-como-crear-un-contenedor-con-docker-mysql-y-persistir-la-informacion/)

Nota: Verifica el Port de salida

En caso de querer instalar el servidor de MySQL descarga e installa el
server [Download MySQL Server](https://dev.mysql.com/downloads/mysql/)

### Configurar Composer

Composer es un manejador de paquetes para PHP, asi como NPM, Maven o NuGet, deberas configurar Composer dentro de tu
entorno: [Download Composer](https://getcomposer.org/download/)

### Configurar Laravel

Luego de haber clonado el repositorio, ingresa a la carpeta por medio de Consola, deberas instalar las dependecias de
Laravel con el siguiente comando

`composer install --ignore-platform-reqs`

Esto tomara unos minutos, ve por un ☕/🍺/🥤 lo que prefieras

Luego configura el archivo `.env`, aca deberas agregar credenciales de BD, URL para el API de Plaza de Mercado (
MARKETPLACE_URL), Correo y
mas

Al completar el archivo `.env` debes de ejecutar estes comando, este generara un HASH unico el cual servidor usara para
generar claves HASH internas:

`php artisan key:generate`

## Iniciar Proyecto

Para iniciar el proyecto ejecuta

`php artisan serve`

Si obtienes algo como esto:

`INFO  Server running on [http://127.0.0.1:8000].
Press Ctrl+C to stop the server`

Felicidades!! has logrado iniciar el proyecto con exito, enjoy! 🙌🏽🎉🍾🥂

### Migracion de tablas de BD

Este proyecto usa la metodologia Model First, es decir la BD se basa en los objetos de modelo de datos, para crear
las tablas debes de considerar lo siguiente:

1. Haber instalado MySQL y configurado un usuario para accesos del proyecto
2. Agregar credenciales al archivo .env
3. La Base de datos vacia debe existir antes de ejecutar las migraciones, y debe estar configurada tambien en el .env

Para ejecutar las migraciones debes de ejecutar el comando

`php artisan migrate`

Veras que se ejecutaran las migraciones, al terminar deberas tener todas las tablas necesarias para el proyecto

#### Quiero tener datos en las tablas pero no tengo tiempo para llenarlas, ¿Que hago?

Laravel tiene un componente llamado Seeders, este proyecto cuenta con Factories y Seeders configurados por lo que podras
tener datos iniciales (RANDOM) para que puedas ir probando desde el inicio

Debes ejecutar el comando

`php artisan db:seed`

Al finalizar la ejecucion, tendras datos en las tablas, no se pretende que sean datos del todo correcto, pero algo a
nada...

En caso quieras configurar la cantidad, y tipo de datos insertados, modifica los Factory y DatabaseSeeder

## Firebase

Este proyecto utiliza Firebase Cloud Messaging para notificar al usuario si su pedido ya esta listo y refrescar la vista
por lo que se necesita configurar las Admin SDK credentials, puedes seguir las instrucciones del siguiente link:

[ Firebase Admin SDK for PHP - Setup Google Service Account](https://firebase-php.readthedocs.io/en/latest/setup.html#setup)

Las credenciales las debes guardar en `firebase/firebase-adminsdk.json` y configurar direccion del archivo dentro de `.env` en `FIREBASE_CREDENTIALS`


## About Laravel

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all
modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a
modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video
tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging
into our comprehensive video library.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


