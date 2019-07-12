# Instalacion

Aqui voy a documentar pasos que segui para instalar todo lo necesario y ejecutar el proyecto.
Mas adelante podemos cambiar este archivo de ubicacion. El objetivo es llevar cuenta de lo que hice hasta ahora.

## Requerimientos

*Nota:* el SO utilizado en este caso es Windows 10 (64 bits).

1. [XAMPP](https://www.apachefriends.org/es/index.html) (Apache, MySQL y PHP). O alternativamente:
   - [Apache HTTP Server](http://httpd.apache.org/)
   - [MySQL](https://www.mysql.com/)
   - [PHP](https://www.php.net/).
1. [Composer](https://getcomposer.org/).
1. [Laravel](https://laravel.com/). (version utilizada 5.8. No se recomienda utilizar versiones anteriores).
   - Recomiendo instalarlo desde composer: `composer global require laravel/installer`.
   - Ejecutar `laravel artisan --version` en la consola del SO para ver la version instalada.

### Guia de instalacion

1. Clonar el repositorio.
2. Pararse en el directorio 'mvj-reviews'.
3. Abrir una terminal y ejecutar `composer install` para descargar las dependencias.
4. Crear un archivo **.env**, a partir de **.env.example**, y configurar las propiedades de la base de datos (Ej: DB_propiedad) con su usuario y contraseña correspondiente. (Ya debe estar creada. Codificacion: utf8mb4)
5. En la terminal ejecutar:
  - `php artisan migrate --seed` para crear la estructura de la BD junto con un set de datos inicial.
  - `php artisan serve` para levantar un servidor php de prueba.
