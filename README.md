## Instalaciones necesarias

-   Node - npm - **https://nodejs.org/en/**
-   Composer - **https://getcomposer.org/**
-   XAMPP - **https://www.apachefriends.org/es/index.html**
-   Git - **https://git-scm.com/**

## Pasos para correr el backend

-   Clonar el repositorio con **git clone**
-   Copiar el archivo **.env.example** a **.env** y editar ahí las credenciales de la base de datos
-   Correr el comando **composer install**
-   Correr el comando **php artisan key:generate**
-   Correr el comando **php artisan migrate --seed** (Tiene datos de prueba)
-   Correr el comando **php artisan jwt:secret** que generará una llave secreta para la libreria de Token jwt-auth
-   Correr el comando **php artisan serve** para correr el servidor

## Credenciales de acceso:

-   Credenciales de administrador: __francisco@gmail.com__ - **1005478122**
-   Credenciales de vendedor: __kaled@gmail.com__ - **1005478123**

## Algunos comandos de laravel

-   Correr el comando **php artisan route:list** para ver las rutas.
-   Correr el comando **php artisan optimize** para guardar cambios en el archivo de las rutas.
-   Correr el comando **php artisan migrate:fresh --seed** para borrar todas las tablas de BD y luego ejectutar las migraciones, el flag **--seed** es para que se ejecuten los seeders que son datos que que coloqué para que testear.
-   Correr el comando **php artisan serve --port=8001** para cambiar el puerto de ejecucion del servidor y **--host=[ip]** para cambiar la ip del servidor.

## Si se encuentra con el siguiente error, siga los siguientes pasos.

Updating dependencies
Your requirements could not be resolved to an installable set of packages.

Problem 1 - maatwebsite/excel[3.1.28, ..., 3.1.30] require phpoffice/phpspreadsheet 1.16._ -> satisfiable by phpoffice/phpspreadsheet[1.16.0]. - maatwebsite/excel[3.1.31, ..., 3.1.x-dev] require phpoffice/phpspreadsheet ^1.18 -> satisfiable by phpoffice/phpspreadsheet[1.18.0, ..., 1.26.0]. - maatwebsite/excel 3.1.27 requires phpoffice/phpspreadsheet ^1.16 -> satisfiable by phpoffice/phpspreadsheet[1.16.0, ..., 1.26.0]. - maatwebsite/excel 3.1.26 requires phpoffice/phpspreadsheet ^1.15 -> satisfiable by phpoffice/phpspreadsheet[1.15.0, ..., 1.26.0]. - maatwebsite/excel[3.1.0, ..., 3.1.25] require php ^7.0 -> your php version (8.1.6) does not satisfy that requirement. - phpoffice/phpspreadsheet[1.15.0, ..., 1.26.0] require ext-gd _ -> it is missing from your system. Install or enable PHP's gd extension. - Root composer.json requires maatwebsite/excel ^3.1 -> satisfiable by maatwebsite/excel[3.1.0, ..., 3.1.x-dev].

To enable extensions, verify that they are enabled in your .ini files: - C:\xampp\php\php.ini
You can also run `php --ini` in a terminal to see which files are used by PHP in CLI mode.
Alternatively, you can run Composer with `--ignore-platform-req=ext-gd` to temporarily ignore these required extensions.

Use the option --with-all-dependencies (-W) to allow upgrades, downgrades and removals for packages currently locked to specific versions.

### Solución.

Debemos habilitar las extensiones en el archivo php.ini, primero debemos apagar el servicio de apache para luego ir al archivo php.ini y remover el punto y coma ";" de la linea "extension=gd".
