## TO-DO (General):
- [ ] Termina estructura de las views (.blades) ---> Matias
- [ ] Averiguar como se interactua con una API externa (IMDB o Similar) ---> Juan

## TO-DO (funcional):

### Controllers:
  - [ ] Review Controller
    - [ ] ABM (Metodos)
  - [ ] Obra Controller
    - [ ] ABM (Metodos)
    - [ ] Buscar Obras mientras Scrolling (busca de a ~50)
    - [ ] Buscar Obra (por ID, Nombre, etc)
    - [ ] Ver Raking Obras
    - [ ] Integración con API de peliculas. (Utiliza metodos de Obras).
  - [ ] User Controller
    - [ ] ABM (Metodos)
    - [ ] Buscar User (por ID, Nombre, etc)
    - [ ] Ver Raking Users
  - [ ] Novedad Controller
    - [ ] ABM (Metodos)
    - [ ] Buscar Novedad (Por Titulo, Copete, Descripción LIKE "...")
    - [ ] Buscar Novedad mientras Scrolling (busca de a ~50)
    - [ ] Buscar Novedad ultimas novedades.


### Views - por orden de importancia:
    - [ ] HOME
    - [ ] INFO PELICULA -------> (en esa misma pagina tendra todas sus reviews, paginadas)
     	 - [ ] HACER REVIEW -----> (Si presiona "Hacer Review" -> form, cuando se envian los datos redirecciona de nuevo a Info pelicula)
     	 - [ ] VOTAR PELICULA ----> (Te devuelve la misma pagina con un mensaje abajo de las estrellitas que diga 'voto registrado').
     	 - [ ] VOTAR REVIEW ------> Un icono se pondra rojo o verde, el voto se enviara mediante ajax.
    - [ ] BUSQUEDA PELICULAS -------> (resultados paginados ---> redirecciona a la INFO PELICULA que se abra)
    - [ ] PERFIL PUBLICO DE USUARIO -----> (Si el perfil visto coincide con el usuario logeado -> mostrar boton para EDITAR la info)
     	  - [ ] EDITAR DATOS PERFIL ----> (Cuando se presione EDITAR, a traves de javascript los divs de datos se reemplazan por inputs -> redirecciona al mismo perfil)  
    - [ ] RANKING PELICULAS ----> (Solo mostrar resultado de la query, para agregar funcionalidad cada tupla puede direccionar a la Info pelicula)
    - [ ] RANKING USUARIOS ----> (Solo mostrar resultado de la query, para agregar funcionalidad cada tupla puede direccionar al perfil publico de usuario).
    - [ ] ABM PELICULA (para admins) ---> Forms.

    - [ ] ALTAS NOVEDAD (para admins) --->  Una sola, que deje seleccionar el tipo: estreno, nodedad del dia, premios.
        - [ ] ESTRENOS ---------->  muestro todos, ordenados por fecha a modo de blog, paginados.
        - [ ] NOVEDAD DEL DIA --->  muestro todos, ordenados por fecha a modo de blog, paginados.
        - [ ] PREMIOS
     	        - [ ] PREMIO ESPECIFICO ------>  toda la info en una pantalla individual para ese premio en el que se entro.     
