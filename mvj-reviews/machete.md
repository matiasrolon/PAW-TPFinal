# Machete

Lista de comandos utiles de Laravel.

## Configuraciones - Generales

- Archivo similar al **config.php**: .env
- **Correr servidor de pruebas:** php artisan serve
- **Ayuda:** php artisan help <comando>
- **Lista de comandos:** php artisan list
- **Orden correcto de parametros en BelongToMany:**
```
Class ClaseA extends Model
    public function ClasesB(){ //retorna todas las clasesB que tiene Clase A (Relacion N a N)
      return $this->belongsToMany('App\Models\ClaseB', 'claseA_claseB' (tabla), 'claseA_id', 'claseB_id');
```
(fijarse que el ultimo parametro sea el nombre que figura en la tabla intermedia para el id de la clase que se quiere obtener).

## Controlador (MVC)

- **Agregar nuevo controlador:** php artisan make:controller ControllerName

## Base de Datos - Migrations

### Curiosidades

1. La **codificacion** de las tablas creadas por las migraciones es **utf8mb4_unicode_ci** (segun phpMyAdmin), que segun lei:

   - Es el standard recomendado.
   - Independiente mayusculas y minusculas.
   - Soporta emojis y caracters chinos. (Caracteres de 4 bytes)

1. Los tipos de datos **DATETIME** y **TIMESTAMP** ambos almacenan en formato **YYYY-MM-DD hh:mm:ss[.123456]**. La diferencia es que **TIMESTAMP** es almacenado como **UTC** y es convertido a la hora local cuando se hace la consulta. En cambio, **DATETIME** almacena los valores tal cual fueron introducidos.

### Comandos

**Documentacion oficial:** [https://laravel.com/docs/5.8/migrations](https://laravel.com/docs/5.8/migrations). Incluye los tipos de datos disponibles.

- **Crear una nuevo archivo de migraciones (Nueva tabla a levantar):** php artisan make:migration crear_tabla_personas
- **Ejecutar todas las migraciones:** php artisan migrate
- **Deshacer el ultimo migrate:**  php artisan migrate:rollback
- **Drop de toda la BD y ejecuta nuevamente los migrates:** php artisan migrate:fresh  *(No recomendado)*
- **Borrar migracion:** Basta con eliminar el archivo. Pero NUNCA eliminar el archivo de migraciones si se hizo un migrate y no se hizo un migrate:rollback.

## Modelo - Eloquent

- **Crear Modelo:** php artisan make:model Persona
- **Crear Modelo (Dentro de una carpeta especifica):** php artisan make:model Http/Models/Review

## Pruebas - Seeders
- **Crear seeder:** php artisan make:seeder NAMETableSeeder
- **Ejecutar seeder:** puede hacerse de las siguientes maneras
    -php artisan migrate --seed
    -php artisan migrate:refresh --seeds
    -php artisan db:seed (Para ejecutarlos sin los migrates)
    
## Solucion de Problemas
- Problema1: **No Application Encryption Key Has Been Specified.**
Solucion:
```
php artisan key:generate
php artisan config:cache
```
