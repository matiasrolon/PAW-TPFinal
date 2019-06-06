# Machete

Lista de comandos utiles.

## Configuraciones - Generales

- Archivo similar al **config.php**: .env
- **Correr servidor de pruebas:** php artisan serve
- **Ayuda:** php artisan help <comando>
- **Lista de comandos:** php artisan list

## Controlador (MVC)

- **Agregar nuevo controlador:** php artisan make:controller ControllerName

## Base de Datos - Migrations

*Curiosidad:* La **codificacion** de las tablas creadas por las migraciones es **utf8mb4_unicode_ci** (segun phpMyAdmin), que segun lei:

**Documentacion oficial:** [https://laravel.com/docs/5.8/migrations](https://laravel.com/docs/5.8/migrations). Incluye los tipos de datos disponibles.

- Es el standard recomendado.
- Independiente mayusculas y minusculas.
- Soporta emojis y caracters chinos. (Caracteres de 4 bytes)

- **Crear una nuevo archivo de migraciones (Nueva tabla a levantar):** php artisan make:migration crear_tabla_personas
- **Ejecutar todas las migraciones:** php artisan migrate
- **Deshacer el ultimo migrate:**  php artisan migrate:rollback
- **Drop de toda la BD y ejecuta nuevamente los migrates:** php artisan migrate:fresh  *(No recomendado)*

## Modelo - Eloquent

- **Crear Modelo:** php artisan make:model Persona
