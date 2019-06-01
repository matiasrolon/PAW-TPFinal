# Programacion en Ambiente Web -TP Final

## Propuesta

**Nombre del proyecto:**   MVJ Review

**Propósito:**    Sitio de críticas de cine y televisión.

**Descripción:**

El sitio propone generar una comunidad de críticos amateurs de cine/series/cortos en donde se dejan opiniones personales sobre dicho contenido. Estas opiniones pueden ser votadas. Tanto los autores como las opiniones tienen un ranking.

Se propone como idea original, hacer un tipo de página orientada al progreso del usuario (denominado “crític”) y su motivación por obtener más puntos (es decir, aumentar su rango en la plataforma).
Cuando se habla de sitios web de críticas de cine/series suelen ser éstas últimas el foco principal, siendo la mayor entrada al sitio personas que solo les interesa saber de qué trata el film y si está bien punteada, en muchos casos, solo en base a críticos profesionales.

Con nuestra propuesta queremos dar un sentido de pertenencia a una comunidad que comparte el hobby del análisis por el contenido audiovisual, a fanáticos que quieran aportar datos interesantes sobre su serie favorita, o bien a usuarios neutrales que aporten comentarios constructivos. Con esto, nos referimos a que los usuarios que más disfruten del sitio serán aquellos que no solo lo consultan si no quienes generen contenido para él.

---

## Tecnologias

- Front-end: HTML, CSS y Javascript. 
- Back-end: PHP, utilizando Laravel como framework.

---

## Presupuesto funcional

Algunas definiciones:

-**Obra**: Pelicula, serie de televisión.
-**Review**: Critica sobre la obra.
-**Critic**: Usuario logueado en la pagina.

El sitio cuenta con las siguientes **secciones**:

- Home o página principal.
- Ranking de críticos.
- Perfil de critico.
- Ranking de obras.
- Perfil de obra.
    - Reviews de obra.
    - Agregar Review. 
- Noticias del dia. 
- Estrenos. 
- Premios.

### Tareas

#### Modelo de datos

Informacion que debe persistir el sitio:

- Obras: Películas y series. Titulo, año, director,productor, genero, actores,argumento, puntuacion, fecha de estreno, fecha de finalizacion, categoria.
- Usuarios: Nombre, mail, edad, informacion de presentacion, puntaje en base a criticas.
- Criticas: Pelicula, usuario, titulo, descripcion, tags, puntuacion de pelicula, votos negativos, votos positivos.
- Noticias del dia: Titulo, copete, cuerpo, fecha, tags, autor, imagen, epigrafe.
- Estrenos: Nombre, fecha de estreno, descripcion.
- Premios:  fecha de realizacion, festival/evento, categoria del premio, nombre, nominados, ganador. 

#### Home page

![Home](/res/doc/Home Page.png)
- TOP Obras.
- TOP de críticos.

#### Ranking de criticos

![Ranking de criticos]("/res/doc/Ranking criticos.png")
- Muestra una tabla de los criticos ordenados por puntuacion.
- La puntuacion de los criticos se calcula como la suma de los "likes" menos los "dislikes" de cada una de sus criticas.
- Permite acceder al perfil de los críticos mediante un enlace.

#### Perfil de criticos

![Perfil de Critico]("/res/doc/Datos - Personales - Critico.png")
- Muestra el nombre y un mail de contacto (opcional).
- Actividad (Fuera del alcance?)
- TOP criticas.
- Peliculas favoritas.
- Series favoritas.

#### Ranking de obras

![Ranking de peliculas]()
- Muestra una tabla con TODAS las obras ordenadas por puntuación.
- Las obras pueden filtrarse por **Película** o **Serie**.
- Permite acceder al perfil de la obra mediante un enlace.

#### Perfil de obra

![Perfil de pelicula]("/res/doc/Perfil pelicula.png")
- Posee la portada y la descripcion de la obra. Ademas incluye su puntuación y cantidad de reviews.
- Muestra el trailer oficial de la obra.
- Las obras pueden ser votadas con una puntuación de 1 a 10 estrellas, teniendo como resultado el promedio de todos sus votos hechos por los usuarios logueados en la página (No es necesario escribir una critica para votar).
- Las obras que obtengan mayor cantidad de votos recientemente aparecerán en el Home del sitio, distinguiéndose películas de series.
- Los usuarios pueden realizar sus análisis seleccionando la película que quieran, aportando obligatoriamente un puntaje a ellas (de 1 a 10).
- A su vez, las críticas del usuario son votadas por otros pares también de 1 al 10 estrellas. A partir de estos votos, el usuario consigue aumentar su rango y por lo tanto, su lugar en el ranking general del sitio.
- A medida que sube el promedio del puntaje de una crítica, se posiciona mejor cuando se visualicen las críticas totales de esa película.

#### Reviews de pelicula

![Review de pelicula (Misma pagina)]("/res/doc/Review pelicula.png")
-Apareceran con una paginacion cada determinada cantidad de reviews.
-Tendra los datos del usuario que la haya realizado, su puntaje actual, la votacion de la pelicula y la informacion de la review en si.

#### Agregar Review.

![Confeccion de una review]("/res/doc/Apartado Review.png")
-El usuario dejará una reseña con un puntaje para la pelicula, teniendo un titulo introductorio y un cuerpo de la critica.
-Tendra que agregar un minimo de Tags acerca de los temas que tratan en la review.

#### Registro, Login y Usuarios

![Registro]("/res/doc/Registro.png")
![Login]("/res/doc/Login.png")
- Permite registrarse y loguearse en el sitio.
- Todos los usuarios pueden hacer criticas.
- Todos los usuarios pueden puntuar criticas de otros usuarios y peliculas.

#### Noticias del dia

![Novedades]("/res/doc/Novedades.png")
![Novedad particular]("/res/doc/Novedad particular.png")
- Muestra tarjetas con el titulo y el copete de la noticia, permitiendo acceder al articulo completo haciendo click sobre la alguna de ellas.
- Estan ordenadas cronologicamente.

#### Estrenos

- Completar!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

#### Premios

- Completar!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

---

## Presupuesto Temporal

A continuación se muestra como se llevaran a cabo las actividades para el desarrollo en base a los deadlines.

### Segunda entrega - 7/6/19 (7 Dias)

1. Diseño de objetos MVC - 1 dia.
2. Diseño del modelos de datos (BD) - 2 dias.
3. Implementación del modelo de datos - 2 dias.

### Tercera entrega - 21/6/19 (14 Dias)

1. Implementación 
    - Modulo de usuarios - 4 dias.
    - Modulo de obras - 2 dias.
    - Modulo de Criticas - 5 dias.
    - Modulo de Rankings - 1 dia.
2. Testing - 2 dias.

### Cuarta entrega -28/6/19 (7 Dias)

1. Puesta a punto - 5 dias
2. Preparación de la exposición del sistema. - 1 dia
3. Publicación - 1 dia

---

## SITE MAP 

