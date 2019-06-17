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
-**Agregar nueva ruta a routes/web.php:** para que no salte error al cargar la pagina, por cada ruta nueva que definamos en routes/web.php tendremos que hacer:
```
php artisan clear-compile
php artisan optimize
```

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
- **importante:** En los triggers de creacion siempre hacerlos con CREATED/CREATING. No importa que a la hora de crear las instancias se haya persistido con SAVE(). (Esto debido a que en ocaciones posteriores tambien se usara el SAVE() para hacer Updates, y por lo tanto estaran presentes las acciones del trigger dicho al principio, lo cual ocasionaria problemas;

## Solucion de Problemas

### Problema 1: **No Application Encryption Key Has Been Specified.**

#### Solucion

```
php artisan key:generate
php artisan config:cache
```

### Problema 2: **failed loading cafile stream: 'C:\xampp\apache\bin\curl-ca-bundle.crt'**

#### Descripcion

Sucede cuando la aplicacion intenta acceder a un sitio web que utiliza HTTPS, en este caso, cuando intentamos acceder a la API. El **problema** es que la aplicacion *curl* no posee una lista de CAs valida contra la que comparar el certificado del sitio al que esta intentando acceder.

Mas info en [https://curl.haxx.se/docs/sslcerts.html](https://curl.haxx.se/docs/sslcerts.html).

#### Solucion

[https://stackoverflow.com/questions/55526568/failed-loading-cafile-stream-in-file-get-contents](https://stackoverflow.com/questions/55526568/failed-loading-cafile-stream-in-file-get-contents)

### Problema 3: **Unable to prepare route … for serialization. Uses Closure**

#### Descripcion

Sucede cuando ejecutas este comando para volver a compilar el proyecto por algun motivo en especial
```
php artisan clear-compile
php artisan optimize
```

#### Solucion
Me funciono con la TERCER respuesta y explicacion del link adjunto. (https://stackoverflow.com/questions/45266254/laravel-unable-to-prepare-route-for-serialization-uses-closure)

### Problema 4: **Error 419 (unknown status) - con Ajax**

#### Descripcion:
Salta al momento de hacer una solicitud AJAX con el metodo POST al servidor.

#### Solucion:
1. Se puede solucionar yendo a la clase App\Http\Kernel.php y en el apartado siguiente descomentar la linea marcada (NO SE RECOMIENDA, SOLO SI NO QUEDA OTRA MANERA).
```
protected $middlewareGroups = [
    'web' => [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                // \Illuminate\Session\Middleware\AuthenticateSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                **\App\Http\Middleware\VerifyCsrfToken::class**, ---> DESCOMENTAR ESTA.
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]
```    

2. O BIEN, para solucionarlo y no dejar de perder un aspecto de seguridad en el proyecto, al momento de hacer la request AJAX, seteamos lo siguiente. (RECOMENDADA).
```
AJAXRequest.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
```
