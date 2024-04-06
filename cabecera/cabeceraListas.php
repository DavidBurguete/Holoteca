<!DOCTYPE html>
<html lang="es" style="background: #555566;">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/archivosListas/js/jquery-3.4.1.min.js"></script>
    <script src="/archivosListas/js/index.js"></script>
    <script src="/archivosListas/js/jquery.dataTables.min.js"></script>
    <script src="/archivosListas/js/bootstrap.bundle.min.js"></script>
    <script src="/archivosListas/js/select2.min.js"></script>
    <link href="/archivosListas/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/archivosListas/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/archivosListas/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/archivosListas/css/estilos.css">
    <link rel="shortcut icon" href="/imagenes/jarvis.png">
    <?php
        // PHP 7 no tiene una función que determine si un String termina en X caracteres
        function endsWith( $haystack, $needle ) {
            //Se recoge la longitud del string
            $length = strlen( $needle );
            //Si la longitud es cero (cadena vacía), devuelve true
            if( !$length ) {
                return true;
            }
            //En cualquier otro caso, comprueba que el substring de misma longitud que el Srting de final sean iguales
            return substr( $haystack, -$length ) === $needle;
        }
        $nombrePagina = "";
        //Comprobamos cuál el script en ejecución para darle nombre a la página
        if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "peliculas/additar")){
            //En el caso de editar o añadir algo en la base de datos se comprueba que caso es, ya que ambos usan la misma página
            if(isset($_POST["editar"]) || isset($_GET["id"])){
                $nombrePagina = "Editar";
            }
            else{
                $nombrePagina = "Añadir";
            }
            $nombrePagina .= " pel&iacute;culas";
        }
        else if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "libros/additar")){
            if(isset($_POST["editar"]) || isset($_GET["id"])){
                $nombrePagina = "Editar";
            }
            else{
                $nombrePagina = "Añadir";
            }
            $nombrePagina .= " libros";
        }
        else if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "juegos/additar")){
            if(isset($_POST["editar"]) || isset($_GET["id"])){
                $nombrePagina = "Editar";
            }
            else{
                $nombrePagina = "Añadir";
            }
            $nombrePagina .= " juegos de mesa";
        }
        else if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "peliculas")){
            $nombrePagina = "Lista de pel&iacute;culas";
        }
        else if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "libros")){
            $nombrePagina = "Lista de libros";
        }
        else if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "juegos")){
            $nombrePagina = "Lista de juegos de mesa";
        }
        else if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "peliculas/ficha")){
            $nombrePagina = "Ficha de película/serie";
        }
        else if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "libros/ficha")){
            $nombrePagina = "Ficha de libro";
        }
        else if(endsWith(substr($_SERVER["SCRIPT_NAME"], 0, -4), "papelera")){
            $nombrePagina = "Papelera";
        }
        else{
            $nombrePagina = "INICIO";
        }
    ?>
    <title>Jarvis</title>
</head>

<body style="background: #555566;">
    <form method="post" action="/index.php" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" id="cerrar">&times;</a>
        <label for="inicio"><input id="inicio" type="submit" name="inicio" value="inicio">Inicio</input></label>
        <hr>
        <label for="lista_peliculas"><input id="lista_peliculas" type="submit" name="lista_peliculas" value="lista_peliculas">Lista de pel&iacute;culas</input></label>
        <label for="lista_libros"><input id="lista_libros" type="submit" name="lista_libros" value="lista_libros">Lista de libros</input></label>
        <label for="lista_juegos"><input id="lista_juegos" type="submit" name="lista_juegos" value="lista_juegos">Lista de juegos de mesa</input></label>
        <label for="papelera"><input id="papelera" type="submit" name="papelera" value="papelera">Papelera de las listas</input></label>
    </form>
    <div class="<?php 
        //Las fichas deben ocupar toda la página
        if($nombrePagina != "Ficha de película/serie" && $nombrePagina != "Ficha de libro"){echo 'container';} else {echo 'mr-5 ml-5';}?>">
        <h1 class="cabecera centrar" id="abrir">
            <span class="bocadillo" style="color: white">
            &#9776; <?php echo $nombrePagina; ?>
        </h1>

        <?php
            $conectar=null;

            /** Función que sirve para crear una conexión con la base de datos */
            function conectarBD(){
                try{
                    //Creamor el objeto integrado en php para conectar, con nombre de la BBDD, usuario y contraseña
                    $conexion = new PDO('mysql:host=127.0.0.1;dbname=servidor_jarvis','root','');
                    $conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
                    $conexion->exec('SET names utf8');
                    return $conexion;
                } catch(Exception $ex){
                    //En caso de no poder establecer conexión, lanza un mensaje de error
                    echo "<div class='container bg-light rounded text-center h2 p-3 font-weight-bold'>Error: no se ha podido conectar a la BBDD</div>";
                }
            }
            $conectar=conectarBD();
            ?>
