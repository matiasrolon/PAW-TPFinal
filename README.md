# Programacion en Ambiente Web -TP Final

## Propuesta

**Nombre del proyecto:**   MVJ Review

**Propósito:**    Sitio de críticas de cine.

### Descripción

El sitio propone generar una comunidad de críticos amateurs de cine/series/cortos en donde se dejan opiniones personales sobre dicho contenido. Estas opiniones pueden ser votadas. Tanto los autores como las opiniones tienen un ranking.

Se propone como idea original, hacer un tipo de página orientada al progreso del usuario (denominado “crític”) y su motivación por obtener más puntos (es decir, aumentar su rango en la plataforma).
Cuando se habla de sitios web de críticas de cine/series suelen ser éstas últimas el foco principal, siendo la mayor entrada al sitio personas que solo les interesa saber de qué trata el film y si está bien punteada, en muchos casos, solo en base a críticos profesionales.

Con nuestra propuesta queremos dar un sentido de pertenencia a una comunidad que comparte el hobby del análisis por el contenido audiovisual, a fanáticos que quieran aportar datos interesantes sobre su serie favorita, o bien a usuarios neutrales que aporten comentarios constructivos. Con esto, nos referimos a que los usuarios que más disfruten del sitio serán aquellos que no solo lo consultan si no quienes generen contenido para él.

---

## Tecnologias

- Front-end: **COMPLETAR**
- Back-end: **COMPLETAR**
- Otro: **COMPLETAR**

---

## Presupuesto funcional

Algunas definiciones:
**Obra**: Pelicula, serie de televisión.

El sitio cuenta con las siguientes **secciones**:

- Home o página principal.
- Ranking de obras.
- Perfil de obra (**OPCIONAL: Sugerir obras similares. (Fuera del alcance)**)
- Ranking de críticos.
- Perfil de criticos.
- Noticias. (**Creo que esta abarca las dos secciones siguientes**)
- Estrenos. (**QUE VA EXACTAMENTE ACA?**)
- Premios.

### Tareas

#### Modelo de objetos

En base a las funciones que brinda el sitio.

#### Modelo de datos

Toda informacion que deba ser persistida por el sitio **COMPLETAR**:

- Obras: Películas y series. Titulo, año, puntuacion
- Usuarios: Nombre, mail, puntaje en base a criticas.
- Criticas: Pelicula, usuario, valoración, descripcion.
- Noticias: Titulo, copete, cuerpo, fecha, tags, autor
- Estrenos
- Premios

#### Home page

- TOP Obras.
- TOP de críticos.

#### Ranking de obras

- Muestra una tabla con TODAS las obras ordenadas por puntuación.
- Las obras pueden filtrarse por **Película** o **Serie**.
- Permite acceder al perfil de la obra mediante un enlace.

#### Perfil de obra

- Posee la portada y la descripcion de la obra. Ademas incluye su puntuación y cantidad de reviews.
- Muestra el trailer oficial de la obra.
- Las obras pueden ser votadas con una puntuación de 1 a 10 estrellas, teniendo como resultado el promedio de todos sus votos hechos por los usuarios logueados en la página (No es necesario escribir una critica para votar).
- Las obras que obtengan mayor cantidad de votos recientemente aparecerán en el Home del sitio, distinguiéndose películas de series.
- Los usuarios pueden realizar sus análisis seleccionando la película que quieran, aportando obligatoriamente un puntaje a ellas (de 1 a 10).
- A su vez, las críticas del usuario son votadas por otros pares también de 1 al 10 estrellas. A partir de estos votos, el usuario consigue aumentar su rango y por lo tanto, su lugar en el ranking general del sitio.
- A medida que sube el promedio del puntaje de una crítica, se posiciona mejor cuando se visualicen las críticas totales de esa película.

#### Ranking de criticos

- Muestra una tabla de los criticos ordenados por puntuacion.
- La puntuacion de los criticos se calcula como la suma de los "likes" menos los "dislikes" de cada una de sus criticas.
- Permite acceder al perfil de los críticos mediante un enlace.

#### Perfil de criticos

- Muestra el nombre y un mail de contacto (opcional).
- Actividad (Fuera del alcance?)
- TOP criticas.
- Peliculas favoritas.
- Series favoritas.

#### Noticias

- Muestra tarjetas con el titulo y el copete de la noticia, permitiendo acceder al articulo completo haciendo click sobre la alguna de ellas.
- Estan ordenadas cronologicamente.

#### Estrenos

- Completar!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

#### Premios

- Completar!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

#### Registro, Login y Usuarios

- Permite registrarse y loguearse en el sitio.
- Todos los usuarios pueden hacer criticas.
- Todos los usuarios pueden puntuar criticas de otros usuarios y peliculas.

---

## Presupuesto Temporal

A continuación se muestra como se llevaran a cabo las actividades para el desarrollo en base a los deadlines.

### Segunda entrega - 7/6/19 (7 Dias)

1. Diseño de objetos MVC
2. Diseño del modelos de datos (BD)
3. Implementación del modelo de datos

### Tercera entrega - 21/6/19 (14 Dias)

1. Implementación
2. Testing

> Desarollo incremental???

### Cuarta entrega -28/6/19 (7 Dias)

1. Puesta a punto
2. Preparación de la exposición del sistema.
3. Publicación

---

## Wireframes

![Home]("/res/doc/Home Page.png")

![Ranking de peliculas]()

![Perfil de pelicula]("/res/doc/Perfil pelicula.png")

![Review de pelicula (Misma pagina)]("/res/doc/Review pelicula.png")

![Confeccion de una review]("/res/doc/Apartado Review.png")

![Ranking de criticos]("/res/doc/Ranking criticos.png")

![Perfil de Critico]("/res/doc/Datos - Personales - Critico.png")

![Novedades]("/res/doc/Novedades.png")

![Novedad particular]("/res/doc/Novedad particular.png")

![Registro]("/res/doc/Registro.png")

![Login]("/res/doc/Login.png")

## SITE MAP (Grafo de como se navega el sitio)

**COMPLETAR**