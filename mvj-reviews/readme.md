# Instalacion

Aqui voy a documentar pasos que segui para instalar tood lo necesario y ejecutar el proyecto.
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
1. Pararse en el directorio 'mvj-reviews'.
1. Abrir una terminal y ejecutar `composer install` para descargar las dependencias.
1. Crear un archivo **.env** y configurar la base de datos. (Ya debe estar creada. Codificacion: utf8mb4)
1. En la terminal ejecutar `php artisan migrate` para crear la estructura de la BD.
1. Levantar el servidor php de prueba ejecutando `php artisan serve`.

---

## TO-DO List

- [x] Ajustar la migracion de crear tabla de usuarios segun el modelo.
- [ ] Agregar los triggers para calcular el campo puntos de la tabla usuarios.
- [ ] Crear todas las migraciones faltantes segun del modelo.
