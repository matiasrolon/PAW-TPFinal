# TAREAS

## TO-DO (Semana - al 6/08/2019)

### Matias

- [ ] Funcionalidad EDITAR datos de perfil de usuario.
- [ ] CSS de Premios (awards.blade) y Premio en particular (award_profile.blade)

### Juan

- [x] CSS de Admin novedades.
  - Para el formulario de crear noticia se puede agregar un campo "importancia" y a partir de esa categoria decidir los tamaños de las noticias cuando aparescan en la pagina de Noticias (News.blade)
  - No esta hecha la parte de EDITAR una novedad ya existente. Podria ser en esa misma pagina solo que con los parametros de input de esa noticia/premio pasados desde el php.
  - Si se considera necesario por una razon de funcionalidad, se puede eliminar la primer pantalla en donde aparece en grande las opciones de Crear Noticia o Crear Premio, directamente aparecer como menu achicado (su segunda version)

### Victorio

- [ ] CSS de Noticias (news.blade) y noticia en particular (news_profile.blade)
  - Acordar botones de edicion y tamaño de las noticias a partir de items mencionados para Juan.
  
### Acordar

- [ ] CSS de Estrenos (premieres.blade) y estreno en particular (premire_profile.blade)
  - Al ser peliculas con la particularidad que su fecha de estreno es mayor a hoy, podria hacerse un apartado por mes, mencionando cuales se estrenan en ese mes. Deberian aparecer arriba de todo los de esta semana/mes actual.
- [ ] Mejorar CSS de login y registrer para que este acorde en estetica con las otras paginas.

## TO-DO (General)

- [x] Revisar funcion FilmController\store()
- Como devolver JSONs (interesante): [https://laravel.com/docs/5.8/responses#json-responses](https://laravel.com/docs/5.8/responses#json-responses)

## TO-DO (Presentacion)

- [ ] Verificar que las vistas cumplen con los [Estandares de la W3C](https://validator.w3.org/).
- [x] Documento que indique como hacer el deployment del proyecto. [readme.md](readme.md).
- [ ] Presentacion del software: puede ser una muestra de como anda, no necesariamente una ppt.

## Errores - PROBLEMAS

- [x] **Uno:**
  1. agregue dos peliculas de el padrino mediante la API.
  2. Voy a admin films y busco en TheMovieDB "el padrino"
  3. Me carga solo las dos que tengo guardadas en la BD. y se ve el siguiente error en la consola de JS
  ```
    Uncaught TypeError: resp.forEach is not a function
    at Object.AdminFilms.recibirResponseSearchFilmsAdmin (admin_films.js:157)
    at XMLHttpRequest.request.onreadystatechange (admin_films.js:121)
  ```

- [ ] **Dos:**
  Cuando hago una busqueda en el admin films que puede tener muchos resultados, por ejemplo "EL", se cuelga el server hasta que pasan 60 segundos y no responde a ninguna otra conexion. Esto es asi solo con el server de prueba de artisan o con XAMPP tambien?

- [x] **Tres:**
  En la home, lo de girar las tarjetas de las peliculas no funciona en FIREFOX.

- [x] **Cuatro:**
  En admin films, sucede que una vez que modifique una descripcion de un film, todos los films que seleccione a continuacion tendran ESA descripcion. Incluso luego de recargar la pagina sigue pasando. No pude encontrar la causa.

- [ ] **Cinco:**
  En admin films la fecha se muestra en ingles (asi la trae la API y asi se almacena), pero deberia estar en castellano.

- [x] **Seis:**
  En admin films, a veces no encuentra algunos resultados. Ej "Tron". Ademas deberia mostrar un cartel diciendo que no se encontro nada.

- [x] **Siete:**
  En admin films, cuando recupera el film de la BD nuestra no trae los generos. Falta hacer un join ahi.

- [x] **Ocho:**
  En admin films, al querer modificar una pelicula en nuestra BD da error. Creo que tiene que ver con el chequeo de los generos que agregue.

- [x] **Nueve:**
  El usuario se puede dar "autolike" y/o "autodislike" en su review. (**En cualquier red social te podes dar autolike. No lo veo como un problema** @vic)

- [x] **Diez:**
   En admin films, los carteles "se actualizo el film con exito" y "error del servidor" se acumulan uno debajo de otro. Deberia aparecer uno solo.

- [x] **Once:**
  En admin films, en algunas peliculas cuando las obtengo de nuestra BD, la respuesta contiene generos repetidos. Sin embargo en la BD no estan repetidos estos generos en esa pelicula, por lo que sospecho que es a funcion FilmController@searchLocalFilm

- [ ] **Doce:**
  En el perfil de pelicula, cuando le das like a una review, no actualiza en ese momento el contador de likes. Tambien falta mostrar el trailer (un iframe con el enlace de youtube).

## TO-DO (funcional)

### DB

- [x] Conservar en base el id_themoviedb para que cada vez que se recupera una peli de la api
 no pasarla al front si ya esta cargada en base. Por mas que se distinga visualmente
 cuales son de la api y cuales de nuestra bd, queda mejor si directamente las filtramos.4
  - **Hecho a medias: logre que se guarde le id_themoviedb pero no consigo lograr que NO se muestre como resultado. Tambien se guardan la duracion (que no se por que estaba comentada).**

### MashUp - API

- [x] Datos recuperados de la API que esten vacios, que queden asi. Actualmente cuando no hay nada, pone como valor "undefined" o "false";
  - **Hecho pero en el campo genero sigue apareciendo undefined porque la API no trae ese campo.**
- [x] Parsear peliculas. --> Funcion ApiController/search()
- [x] Analizar requisitos de la BD para almacenar pelicuas de la API.
  - Campo de ID de la pelicula en la API.
  - Campo Hash de la info de la API para ver si fue actualizada.
- [x] Funcion que adapta el formato de las peliculas de la API para insertarlas en la BD.
  - [ ] Parsear los trailers.
  - [x] Generos de obras.
  - [ ] Por mejorar: obtener mas detalles de las obras.
- [ ] Como se almacena la configuracion de la API y como se actualiza.
- [x] Testear si funciona el metodo ApiController/guardarObra()
  - [ ] Preguntar si ya existe una pelicula con el mismo valor en 'id_themoviedb'
- [ ] Como aseguramos que las funciones de la API sean solo accesibles por el admin?
- [x] Problema: paises de origen en la API estan en ingles. **Pasados a castellano**
- [x] Dropdown list de paises en Admin films. **Se admite solo un pais actualmente**
- [x] Dropdown list de generos en Admin films.
  - [ ] Revisar que hay generos compuestos. EJ: "Accion y Aventura" seguna la API.
- [x] Que agregue la relacion genero-pelicula en la BD.
- [ ] Definir la manera en que el server devuelve al cliente la lista de generos de films.

### Controllers

#### Film Controller

- [x] Validacion en metodo store()
- [ ] Cambiar el campo 'trailer' por 'trailer_url'.
  - [ ] Cambiarlo tambien en admin_films.js
  - [ ] Cambiarlo tambien en el Models\Film.php
  - [ ] Cambiarlo tambien en Database\Migrations\Create_table_film
- [ ] Actualizacion en metodo update()

### Views

#### Admin Films

- [x] El formulario no esta puesto como un formulario. Hay que reconstruirlo
  - [x] Por eso falla la validacion en FilmController@store
- [x] Decidir campos obligatorios e indicarlos mediante CSS: titulo, fecha_estreno, sinopsis, categoria, trailer.
- [ ] El boton GUARDAR debe chequear que los campos requeridos esten completos.
  - [x] Debe corregirse la validacion del lado del servidor al agregar un film.
  - [x] Mostrar los errores usando la forma de Laravel.
- [ ] Permitir agregar un film sin necesidad de buscarlo en la API.
  - [ ] Requiere poder subir una foto manualmente.
- [ x] Funcionalidad del boton de Eliminar.
  - [x] Activarlo al seleccionar un film que provenga de nuestra BD.

#### Estrenos

- [x] Usar plantila de la home
  - [x] En el perfil de pelicula no se podra escribir reviews hasta que se estrene. Solo se podra ver el trailer.
- [x] Lista de estrenos (films que se estrenan desde hoy en adelante)
- [x] Ordenadas por mes a venir
- [ ] Mostrar unas 4 pelis de cada mes y un boton que permita expandir para ver todas.
- [ ] Acomodar colores CSS
- [x] En inicio no deben aparecer los estrenos.
- [x] Poner las fechas en castellano.
