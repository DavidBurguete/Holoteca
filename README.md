Este proyecto surge para optimizar y mejorar un servidor web local doméstico aprovechando el título de Desarrollo de Aplicaciones Web.

Este servidor se componía de un conjunto de páginas que mostraban un listado de películas y libros. El listado de películas redirigía a un conjunto de fichas estáticas, una por película. Ninguna de estas páginas permitía filtrar búsquedas, añadir, editar o eliminar (eran listas estáticas, no basadas en ninguna base de datos, ni siquiera había un servidor SQL).

Para mejorar el servidor se creó una base de datos en SQL, lo que permitió añadir a las páginas las características nombradas que no tenían, y se añadió una página para juegos de mesa y una papelera.

Para instalarlo, se requiere un servidor con una base de datos SQL (en caso de no disponer de un servidor online, se puede usar uno local con Xampp). Se necesita usar PHP >= 7.0 y subir el archivo servidor_jarvis.sql en la base de datos del mismo nombre (con la barra baja y sin la extensión del archivo). También ha sido eliminada la clave de la API OMDb en los archivos Ficha.php y peliculas.php en la carpeta /peliculas y se ha sustituido, para facilitar la búsqueda y sustitución, por INTRODUCIR_API_KEY.
Si se ha añadido un usuario y contraseña en la base de datos, se debe modificar el archivo cabeceraListas.php en la carpeta /cabecera, al final del archivo, en la creación del objeto PDO y sustituir respectivamente 'root' y el espacio en blanco (' ').

Enlace a la página web: https://davidburguete.000webhostapp.com/

Dirección de correo electrónico: dburgueteg@gmail.com

  -David Burguete
