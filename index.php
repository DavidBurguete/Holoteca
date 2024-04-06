<?php
    include "cabecera/cabeceraListas.php";
    if(empty($_POST) || isset($_POST['inicio'])){
        include "./inicio/inicio.php";
    }
    else if(isset($_POST['lista_peliculas'])){
        header("Location: ./peliculas/peliculas.php");
    }
    else if(isset($_POST['lista_libros'])){
        header("Location: ./libros/libros.php");
    }
    else if(isset($_POST['lista_juegos'])){
        header("Location: ./juegos/juegos.php");
    }
    else if(isset($_POST['papelera'])){
        header("Location: ./papelera/papelera.php");
    }
?>
    <div class="d-flex flex-wrap">
        <div class="col-lg-8 col-12">
            <h4 class="text-justify text-white">
                Este proyecto surge para optimizar y mejorar un servidor web local doméstico aprovechando el título de Desarrollo de Aplicaciones Web.
                <br><br>
                Este servidor se componía de un conjunto de páginas que mostraban un listado de películas y libros. El listado de películas redirigía a un conjunto de fichas estáticas, una por película.  Ninguna de estas páginas permitía filtrar búsquedas, añadir, editar o eliminar (eran listas estáticas, no basadas en ninguna base de datos, ni siquiera había un servidor SQL).
                <br><br>
                Para mejorar el servidor se creó una base de datos en SQL, lo que permitió añadir a las páginas las características nombradas que no tenían, y se añadió una página para juegos de mesa y una papelera. 
                <br><br>
                ¿Qué se puede hacer en este sitio web? Listadas por cada página, son las siguientes:
                <br><br>
                <button type="button" class="btn dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #555566; box-shadow: none !important">
                    &emsp;-Películas
                </button>
                <div class="btn_group">
                    <div class="dropdown-menu p-2 text-white" style="background-color: #777788; border: 0;">
                        &emsp;&emsp;+Añadir y editar registros por nombre del archivo, lugar de guardado y código/enlace IMDb (Internet Movie Database: Base de datos de películas de Internet)
                        <br>
                        &emsp;&emsp;+Enviar registros de la tabla a la papelera
                        <br>
                        &emsp;&emsp;+Filtrar contenido de la tabla, así como buscar registros en ella y saltar entre páginas usando la paginación de la tabla o saltar a una página específica haciendo click en los tres puntos
                        <br>
                        &emsp;&emsp;+Mostrar más o menos campos de la tabla
                    </div>
                </div>
                <div class="btn_group">
                    <button type="button" class="btn dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #555566; box-shadow: none !important">
                        &emsp;-Juegos
                    </button>
                    <div class="dropdown-menu p-2 text-white" style="background-color: #777788; border: 0;">
                        &emsp;&emsp;+Añadir y editar registros por nombre del juego, duración de la partida, mínimo y máximo de jugadores y el lugar de guardado
                        <br>
                        &emsp;&emsp;+Enviar registros de la tabla a la papelera
                        <br>
                        &emsp;&emsp;+Filtrar contenido de la tabla, así como buscar registros en ella y saltar entre páginas usando la paginación de la tabla o saltar a una página específica haciendo click en los tres puntos
                    </div>
                </div>
                <div class="btn_group">
                    <button type="button" class="btn dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #555566; box-shadow: none !important">
                        &emsp;-Libros
                    </button>
                    <div class="dropdown-menu p-2 text-white" style="background-color: #777788; border: 0;">
                        &emsp;&emsp;+Añadir y editar registros por nombre del libro, lugar de guardado y código ISBN
                        <br>
                        &emsp;&emsp;+Añadir y editar registros manualmente por nombre del libro, lugar de guardado, ISBN o depósito legal, número de páginas, autor, entre otras opciones
                        <br>
                        &emsp;&emsp;+Enviar registros de la tabla a la papelera
                        <br>
                        &emsp;&emsp;+Filtrar contenido de la tabla, así como buscar registros en ella y saltar entre páginas usando la paginación de la tabla o saltar a una página específica haciendo click en los tres puntos
                    </div>
                </div>
                <div class="btn_group">
                    <button type="button" class="btn dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #555566; box-shadow: none !important">
                        &emsp;-Papelera
                    </button>
                    <div class="dropdown-menu p-2 text-white" style="background-color: #777788; border: 0;">
                        &emsp;&emsp;+Eliminar o restaurar registros individualmente
                        <br>
                        &emsp;&emsp;+Vaciar completamente la papelera, eliminando definitivamente esos registros 
                    </div>
                </div>
                <div class="btn_group">
                    <button type="button" class="btn dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #555566; box-shadow: none !important">
                        &emsp;-Herramientas utilizadas
                    </button>
                    <div class="dropdown-menu p-2 text-white" style="background-color: #777788; border: 0;">
                        &emsp;+API OMDb (Open Movie Database) para recoger la información de las películas
                        <br>
                        &emsp;+API Google Books para recoger la información de los libros
                        <br>
                        &emsp;+Librería de JavaScript Datatables para dar formato a las tablas
                        <br>
                        &emsp;+Librería de JavaScript Select2 para dar formato a la etiqueta &lt;select&gt;
                        <br>
                        &emsp;+Bootstrap para estilizar las páginas
                        <br>
                        &emsp;+Lenguajes de programación PHP y JavaScript
                        <br>
                        &emsp;+Servidor de Bases de Datos SQL
                        <br>
                        &emsp;+Visual Studio Code como entorno de desarrollo
                        <br>
                        &emsp;+Xampp como servidor local y campo de pruebas
                    </div>
                </div>
                <br>
                &emsp;&emsp;&emsp;&emsp;-David Burguete
            </h4>
        </div>
        <br><br>
        <div class="col-lg-4 col-12">
            <div class="h4 p-2 mb-2 mt-2 ml-5 mr-5 pt-3 pb-3 rounded text-center" style="background-color: #666677;">
                <a href="/peliculas/peliculas.php" class="text-white p-2 rounded" style="background-color: #777788;">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="align-middle" style="margin: 0 auto; display: inline-block;" fill="white">
                        <path stroke="white" d="M9 3L8 8M16 3L15 8M22 8H2M6.8 21H17.2C18.8802 21 19.7202 21 20.362 20.673C20.9265 20.3854 21.3854 19.9265 21.673 19.362C22 18.7202 22 17.8802 22 16.2V7.8C22 6.11984 22 5.27976 21.673 4.63803C21.3854 4.07354 20.9265 3.6146 20.362 3.32698C19.7202 3 18.8802 3 17.2 3H6.8C5.11984 3 4.27976 3 3.63803 3.32698C3.07354 3.6146 2.6146 4.07354 2.32698 4.63803C2 5.27976 2 6.11984 2 7.8V16.2C2 17.8802 2 18.7202 2.32698 19.362C2.6146 19.9265 3.07354 20.3854 3.63803 20.673C4.27976 21 5.11984 21 6.8 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Películas
                </a>
            </div>
            <br>
            <div class="h4 p-2 mb-2 mt-2 ml-5 mr-5 pt-3 pb-3 rounded text-center" style="background-color: #666677;">
                <a href="juegos/juegos.php" class="text-white p-2 rounded" style="background-color: #777788;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="25" height="25" class="align-middle" style="margin: 0 auto; display: inline-block;" fill="white">
                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm64 64v64h64V96h64v64h64V96h64v64H320v64h64v64H320v64h64v64H320V352H256v64H192V352H128v64H64V352h64V288H64V224h64V160H64V96h64zm64 128h64V160H192v64zm0 64V224H128v64h64zm64 0H192v64h64V288zm0 0h64V224H256v64z"/>
                    </svg>
                    Juegos
                </a>
            </div>
            <br>
            <div class="h4 p-2 mb-2 mt-2 ml-5 mr-5 pt-3 pb-3 rounded text-center" style="background-color: #666677;">
                <a href="libros/libros.php" class="text-white p-2 rounded" style="background-color: #777788;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="25" height="25" class="align-middle" style="margin: 0 auto; display: inline-block;" fill="white">
                        <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                    </svg>
                    Libros
                </a>
            </div>
            <br>
            <div class="h4 p-2 mb-2 mt-2 ml-5 mr-5 pt-3 pb-3 rounded text-center" style="background-color: #666677;">
                <a href="papelera/papelera.php" class="text-white p-2 rounded" style="background-color: #777788;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 72 72" class="align-middle" style="margin: 0 auto; display: inline-block;" fill="white">
                        <path d="M 32.5 9 C 28.364 9 25 12.364 25 16.5 L 25 18 L 17 18 C 14.791 18 13 19.791 13 22 C 13 24.209 14.791 26 17 26 L 17.232422 26 L 18.671875 51.916016 C 18.923875 56.449016 22.67875 60 27.21875 60 L 44.78125 60 C 49.32125 60 53.076125 56.449016 53.328125 51.916016 L 54.767578 26 L 55 26 C 57.209 26 59 24.209 59 22 C 59 19.791 57.209 18 55 18 L 47 18 L 47 16.5 C 47 12.364 43.636 9 39.5 9 L 32.5 9 z M 32.5 16 L 39.5 16 C 39.775 16 40 16.224 40 16.5 L 40 18 L 32 18 L 32 16.5 C 32 16.224 32.225 16 32.5 16 z M 36 28 C 37.104 28 38 28.896 38 30 L 38 47.923828 C 38 49.028828 37.104 49.923828 36 49.923828 C 34.896 49.923828 34 49.027828 34 47.923828 L 34 30 C 34 28.896 34.896 28 36 28 z M 27.392578 28.001953 C 28.459578 27.979953 29.421937 28.827641 29.460938 29.931641 L 30.085938 47.931641 C 30.123938 49.035641 29.258297 49.959047 28.154297 49.998047 C 28.131297 49.999047 28.108937 50 28.085938 50 C 27.012938 50 26.125891 49.148359 26.087891 48.068359 L 25.462891 30.068359 C 25.424891 28.964359 26.288578 28.040953 27.392578 28.001953 z M 44.607422 28.001953 C 45.711422 28.039953 46.575109 28.964359 46.537109 30.068359 L 45.912109 48.068359 C 45.874109 49.148359 44.986063 50 43.914062 50 C 43.891062 50 43.868703 49.999047 43.845703 49.998047 C 42.741703 49.960047 41.876063 49.035641 41.914062 47.931641 L 42.539062 29.931641 C 42.577062 28.827641 43.518422 27.979953 44.607422 28.001953 z"></path>
                    </svg>
                    Papelera
                </a>
            </div>
        </div>
    </div>
</body>
</html>