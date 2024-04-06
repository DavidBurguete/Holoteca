<?php
            include "../depurar.php";
            include "../cabecera/cabeceraListas.php";
            /** Esta función comprueba que los datos obligatorios no estén vacíos */
            function add(){
                return (isset($_POST['nombre']) && $_POST['nombre'] != '' &&  
                isset($_POST['imdb']) && $_POST['imdb'] != '' && 
                isset($_POST['lugar']) && $_POST['lugar'] != '');
            }
            /** Función que sirve para recoger el código de IMDb, y comprobar que se introduce solo el código o el enlace entero */
            function procesar_imdb(){
                $imdb = depurar($_POST["imdb"]);
                if(substr($imdb, 0, 4) === "http"){
                    $imdb = explode("/?",explode("/tt", $imdb)[1])[0];
                }
                return $imdb;
            }
            /** Función para redireccionar la página si se encuentra algún error en el formulario de adición/edición
             * Toma como parámetro opcional un id, en caso de ser redirección de edición.
             */
            function redireccion($id = NULL){
                //Se marca el error, para asegurar que se manda como uno
                $redireccion = "error=error&";
                //Se comprueba que los datos no estén vacíos
                if($id != NULL){
                    $redireccion .= "id=".$id."&";
                }
                if(isset($_POST['nombre']) && $_POST['nombre'] != ''){
                    $redireccion .= "nombre=".depurar($_POST["nombre"])."&";
                }
                if(isset($_POST['lugar']) && $_POST['lugar'] != ''){
                    $redireccion .= "lugar=".depurar($_POST["lugar"])."&";
                }
                if(isset($_POST['imdb']) && $_POST['imdb'] != ''){
                    $redireccion .= "imdb=".procesar_imdb()."&";
                }
                header("Location: /peliculas/additar.php?$redireccion");
            }
            //Si se añade un campo:
            if(isset($_POST["add"])){
                // Se recoge el código imdb
                $imdb = procesar_imdb();
                // Se recogen los datos de la peli de la API de OMDb (Open Movie Database)
                $url = file_get_contents("http://www.omdbapi.com/?i=tt$imdb&apikey=INTRODUCIR_API_KEY");
                // Se convierte los datos de JSON a un array
                $json = json_decode($url, true);
                // Si los datos son correctos y la API devuelve un resultado
                if(add() && $json["Response"] != "False"){
                    // Recoger los datos del array y los campos
                    $nombre = depurar($_POST["nombre"]);
                    $lugar = depurar($_POST["lugar"]);
                    $agno = intval($json['Year']);
                    $duracion = explode(" ",$json['Runtime'])[0];
                    $director = str_replace("'","\'",$json['Director']);
                    $genero = $json['Genre'];
                    $actor_principal = str_replace("'","\'",$json['Actors']);
                    $argumento = str_replace("'","\'",$json['Plot']);
                    $poster = $json['Poster'];
                    $consultaAdd = "INSERT INTO `peliculas`(`nombre`, `duracion`, `lugar`, `director`, `actor_principal`, `genero`, `agno`, `poster`, `argumento`, `imdb`) VALUES ('$nombre','$duracion','$lugar','$director','$actor_principal','$genero','$agno','$poster','$argumento','$imdb')";
                }
                else{
                    // Si ha ocurrido algún error, se redirecciona
                    redireccion();
                }
            }
            // Si edita un campo
            else if(isset($_POST["editar"])){
                // Similar a añadir un registro, añadiendo el id de la película a editar
                $imdb = procesar_imdb();
                $url = file_get_contents("http://www.omdbapi.com/?i=tt$imdb&apikey=INTRODUCIR_API_KEY");
                $json = json_decode($url, true);
                if(add() && $json["Response"] != "False"){
                    $id = intval(depurar($_POST["id"]));
                    $nombre = depurar($_POST["nombre"]);
                    $lugar = depurar($_POST["lugar"]);
                    $agno = intval($json['Year']);
                    $duracion = explode(" ",$json['Runtime'])[0];
                    $director = str_replace("'","\'",$json['Director']);
                    $genero = $json['Genre'];
                    $actor_principal = str_replace("'","\'",$json['Actors']);
                    $argumento = str_replace("'","\'",$json['Plot']);
                    $poster = $json['Poster'];
                    $consultaEditar = "UPDATE `peliculas` SET `nombre`='$nombre',`lugar`='$lugar',`imdb`='$imdb',`agno`=$agno,`duracion`='$duracion',`director`='$director',`genero`='$genero',`actor_principal`='$actor_principal',`argumento`='$argumento',`poster`='$poster' WHERE `id`=$id";
                }
                else{
                    // Si ha ocurrido algún error, se redirecciona con el id
                    $id = intval(depurar($_POST["id"]));
                    redireccion($id);
                }
            }

            //Si se añade o edita un libro, se conecta a la base de datos para ejecutar una consulta
            if(isset($_POST["add"])){
                if(add()){
                    try{
                        $added = $conectar->query($consultaAdd);
                    }
                    catch(PDOException $error){
                        $added = false;
                    }
                }
            }
            else if(isset($_POST["editar"])){
                if(add()){
                    try{
                        $editado = $conectar->query($consultaEditar);
                    }
                    catch(PDOException $error){
                        $editado = false;
                    }
                }
            }
            //Si se elimina un libro, ejecutar una consulta que marca el libro como "eliminado"
            if(isset($_POST["eliminar"])){
                $id_eliminar = intval(depurar($_POST["id_eliminar"]));
                $consultaEliminar = "UPDATE peliculas SET papelera=1 WHERE id=$id_eliminar";
                try{
                    $eliminado = $conectar->query($consultaEliminar);
                }
                catch(PDOException $error){
                    $eliminado = false;
                }
            }
            // El "echo" usado más adelante para imprimir en el filtro impiden usar el Header Location, por ello, en esta página únicamente
            // se utiliza antes, aunque visualmente pueda quedar peor
            if(isset($_POST["add"])){
                if(!$added){
                    redireccion();
                }
            }
            if(isset($_POST["editar"])){
                if(!$editado){
                    $id = intval(depurar($_POST["id"]));
                    redireccion($id);
                }
            }
        ?>

        <!-- Filtros -->
        <form action="/peliculas/peliculas.php" method="post" class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
            <div class="d-flex align-items-center text-center flex-column">
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center">
                    <label for="duracion" class="mr-2 ml-2">Duración de la película:<br><input id="duracion" type="number" name="duracion" min="1" style="display: inline-block;"></label>
                    <?php 
                        // Se recogen los directores de la base de datos
                        $consulta = "SELECT director FROM peliculas WHERE papelera=0 AND director IS NOT null GROUP BY director";
                        try{
                            // Si la base de datos devuelve los directores...*
                            $directores = $conectar->query($consulta)->fetchAll();
                    ?>
                    <label for="director" class="mr-2 ml-2">
                        Director:<br>
                        <select name="director[]" multiple id="director" style="display: inline-block;">
                            <?php
                                // *... se recorren para separarlos y poder seleccionarlos individualmente
                                $arrayDirectores = [];
                                // Bucle que separa los directores
                                foreach ($directores as $director) {
                                    // Separamos por cada director en un registro
                                    $directoresSplit = explode(",", $director[0]);
                                    foreach ($directoresSplit as $directorSplit) {
                                        $directorSplit = trim($directorSplit);
                                        // Si el director no está en la lista, se añade
                                        if (!in_array($directorSplit, $arrayDirectores)){
                                            array_push($arrayDirectores, $directorSplit);
                                        }
                                    }
                                }
                                // Añadir los directores al desplegable
                                foreach ($arrayDirectores as $arrayDirector) {
                                    echo "<option value='$arrayDirector'>$arrayDirector</option>";
                                }
                            ?>
                        </select>
                    </label>
                    <?php
                        }
                        // Si la base de datos ha lanzado un error, no se muestra el <select> de directores
                        catch(PDOException $error){
                            echo "<p class='col-5'><span class='text-danger'>Error</span>: No se han podido listar los directores</p>";
                        }
                        // Se recogen los actores de la base de datos
                        $consulta = "SELECT actor_principal FROM peliculas WHERE papelera=0 AND actor_principal IS NOT null GROUP BY actor_principal";
                        try{
                            // Si la base de datos devuelve los actores...*
                            $actores = $conectar->query($consulta)->fetchAll();
                    ?>
                    <label for="actor" class="mr-2 ml-2">
                        Actor/Actriz:<br>
                        <select name="actor[]" multiple id="actor" style="display: inline-block;">
                            <?php
                                // *... se recorren para separarlos y poder seleccionarlos individualmente
                                $arrayActores = [];
                                // Bucle que separa los actores
                                foreach ($actores as $actor) {
                                    // Separamos por cada actor en un registro
                                    $actoresSplit = explode(",", $actor[0]);
                                    foreach ($actoresSplit as $actorSplit) {
                                        $actorSplit = trim($actorSplit);
                                        // Si el actor no está en la lista, se añade
                                        if (!in_array($actorSplit, $arrayActores)){
                                            array_push($arrayActores, $actorSplit);
                                        }
                                    }
                                }
                                // Añadir los actores al desplegable
                                foreach ($arrayActores as $arrayActor) {
                                    echo "<option value='$arrayActor'>$arrayActor</option>";
                                }
                            ?>
                        </select>
                    </label>
                    <?php
                        }
                        // Si la base de datos ha lanzado un error, no se muestra el <select> de actores
                        catch(PDOException $error){
                            echo "<p class='col-5'><span class='text-danger'>Error</span>: No se han podido listar los actores/actrices</p>";
                        }
                        
                        $consulta = "SELECT genero FROM peliculas WHERE papelera=0 AND genero IS NOT null GROUP BY genero";
                        try{
                            // Si la base de datos devuelve los generos...*
                            $generos = $conectar->query($consulta)->fetchAll();
                    ?>
                    <label for="genero" class="ml-2 mr-2">
                        Género:<br>
                        <select id="genero" multiple name="genero[]" style="display: inline-block;">
                            <?php
                                // *... se recorren para añadirlos al <select>
                                $arrayGeneros = [];
                                foreach ($generos as $genero) {
                                    // Separamos por cada género en un registro
                                    $generosSplit = explode(",", $genero[0]);
                                    foreach ($generosSplit as $generoSplit) {
                                        $generoSplit = trim($generoSplit);
                                        // Si el género no está en la lista, se añade
                                        if (!in_array($generoSplit, $arrayGeneros)){
                                            array_push($arrayGeneros, $generoSplit);
                                        }
                                    }
                                }
                                // Añadir los generos al desplegable
                                foreach ($arrayGeneros as $arrayGenero) {
                                    echo "<option value='$arrayGenero'>$arrayGenero</option>";
                                }
                            ?>
                        </select>
                    </label>
                    <?php
                        }
                        // Si la base de datos lanza un error, no se muestran los géneros
                        catch(PDOException $error){
                            echo "<p class='col-5'><span class='text-danger'>Error</span>: No se han podido listar los generos</p>";
                        }
                    ?>
                </div>
                <label for="aleatorio" class="mt-2"><input type="checkbox" name="aleatorio" id="aleatorio" style="display: inline-block;" class="m-1">Aleatorio</label>
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center" class="mt-2">
                    <label for="filtrar" class="mr-1"><input id="filtrar" type="submit" value="Filtrar" name="filtrar" style="display: inline-block;" class="btn btn-secondary"></label>
                    <label for="add" class="ml-1"><input id="add" type="submit" value="Añadir" name="add" style="display: inline-block;" class="btn btn-primary" formaction="/peliculas/additar.php"></label>
                </div>
            </div>
        </form>

        <?php 
            // Si se ha añadido una película con éxito, se muestra un mensaje que lo confirme al usuario
            if(isset($_POST["add"])){if($added){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Película/serie añadida &#10003;</b><br>
                    La película/serie ha sido añadida con éxito a la base de datos
                </div>
            </div>
        <?php }}?>

        <?php 
            // Si se ha editado una película con éxito, se muestra un mensaje que lo confirme al usuario
            if(isset($_POST["editar"])){if($editado){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Película/serie editada &#10003;</b><br>
                    La película/serie ha sido editado con éxito
                </div>
            </div>
        <?php }}?>

        <?php 
            // Si se ha "eliminado" una película con éxito, se muestra un mensaje que lo confirme al usuario
            if(isset($_POST["eliminar"])){if($eliminado){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Película/serie eliminada &#10003;</b><br>
                    La película/serie se ha movido a la papelera
                </div>
            </div>
        <?php } 
            // Si ha ocurrido un error, se muestra al usuario
            else{ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-warning p-3 rounded">
                    <b>&#9888; Error &#9888;</b><br>
                    La película/serie no se ha podido eliminar
                </div>
            </div>
        <?php } }?>

        <!-- Tabla con los campos -->
        <table id="lista" class="table table-striped text-center" style="background: white;">
            <thead>
                <tr>
                    <th class='align-middle'><b>Nombre</b></th>
                    <th class='align-middle'><b>Duración</b></th>
                    <th class='align-middle'><b>Lugar</b></th>
                    <th class='align-middle'><b>Director</b></th>
                    <th class='align-middle'><b>Actor Principal</b></th>
                    <th class='align-middle'><b>Género</b></th>
                    <th class='align-middle'>Edición</th>
                    <th class='align-middle'>Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Se crea la consulta a la base de datos, aplicando los filtros que procedan
                    $consulta = "SELECT * FROM peliculas WHERE papelera=0";
                    if(isset($_POST['duracion']) && $_POST['duracion'] != ''){
                        $duracion = intval(depurar($_POST['duracion']));
                        $consulta .= " AND duracion<=".$duracion;
                    }
                    if(isset($_POST["director"])){
                        $directoresFiltrados =depurar( $_POST["director"]);
                        $consulta .= " AND (";
                        foreach ($directoresFiltrados as $directorFiltrado) {
                            $consulta .= "director LIKE '%$directorFiltrado%' OR ";
                        }
                        $consulta = substr($consulta, 0, -4) . ")";
                    }
                    if(isset($_POST["actor"])){
                        $actoresFiltrados =depurar( $_POST["actor"]);
                        $consulta .= " AND (";
                        foreach ($actoresFiltrados as $actorFiltrado) {
                            $consulta .= "actor_principal LIKE '%$actorFiltrado%' OR ";
                        }
                        $consulta = substr($consulta, 0, -4) . ")";
                    }
                    if(isset($_POST["genero"])){
                        $generosFiltrados = depurar($_POST["genero"]);
                        $consulta .= " AND (";
                        foreach ($generosFiltrados as $generoFiltrado) {
                            $consulta .= "genero LIKE '%$generoFiltrado%' AND ";
                        }
                        $consulta = substr($consulta, 0, -5) . ")";
                    }
                    if(isset($_POST["aleatorio"])){
                        $consulta .= " ORDER BY RAND() LIMIT 1";
                    }
                    try{
                        //Se ejecuta la consulta
                        $filas = $conectar->query($consulta)->fetchAll();
                        //Se recorren los campos uno a uno
                        foreach ($filas as $datos_peli) {
                            //Se crea la linea de la tabla
                            $id_edicion = $datos_peli[0];
                            $imdb = $datos_peli['imdb'];
                            $pelicula = "<tr id='$id_edicion'>";
                            //Se recorre los datos de la fila, saltando el id ($i = 1). El conteo se hace hasta el máximo de datos de la fila entre dos
                            //y restando el número total de campos al final de la fila que no se usen ($i<$max/2-x)
                            for ($cont = 1;$cont<count($datos_peli)/2-5;$cont++){
                                //Se crea la celda 
                                $pelicula .= "<td class='align-middle'><a href='./ficha.php?id=$id_edicion'><div>";
                                if(empty($datos_peli[$cont])){//Si no existe el registro, se marca como vacío con un guión
                                    $pelicula .= "-";
                                }
                                else{
                                    $pelicula .= $datos_peli[$cont];
                                }
                                $pelicula .= "</div></a></td>";
                            }
                            //Se añaden las celdas finales para editar o eliminar el registro correspondiente
                            //Celda de edición
                            $pelicula .= '<td class="align-middle">
                                <form action="/peliculas/additar.php" method="post">
                                    <input type="hidden" name="id_edicion" id="id_edicion" value="'.$id_edicion.'">
                                    <input id="editar" type="submit" value="Editar" name="editar" style="display: inline-block;" class="btn btn-info">
                                </form>
                            </td>';
                            //Celda de eliminación
                            $pelicula .= '<td class="align-middle">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar'.$id_edicion.'">
                                    Eliminar
                                </button>
                            </td>'.
                            //Se crea un modal que confirme la eliminación del campo
                            '<div class="modal fade" id="eliminar'.$id_edicion.'" tabindex="-1" role="dialog" aria-labelledby="eliminar'.$id_edicion.'Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Cuidado</h5>'.//Nombre del modal
                                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Estás a punto de eliminar la película '.$datos_peli["nombre"].'<br>¿Quieres proceder?'.//Cuerpo del modal
                                        '</div>
                                        <div class="modal-footer">'.//Pie del modal
                                            '<form action="/peliculas/peliculas.php" method="post">
                                                <input type="hidden" name="id_eliminar" id="id_eliminar" value="'.$id_edicion.'">
                                                <input id="eliminar" value="Si" name="eliminar" type="submit" class="btn btn-danger">
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            $pelicula .= "</tr>";
                            print($pelicula);
                        }
                    }
                    catch(PDOException $error){
                        //Si no se pueden recoger los campos, se muestra un error en su lugar
                        echo "<div class='container bg-light rounded text-center h2 mb-3 p-3 font-weight-bold'><span class='text-danger'>Error</span>: Algo ha sucedido durante la recogida de datos</div>";
                    }
                ?>
            </tbody>
        </table>
        <?php
            //Se desconecta de la base de datos
            $conectar=null;
        ?>
    </div>
    <script>
        let mostrar = false;
        let generos = "";
        let director = "";
        <?php
            //Comprobar que filtros se han aplicado para conservarlos
            if(isset($_POST["duracion"]) && $_POST['duracion'] != ''){
                $duracion = intval(depurar($_POST['duracion']));
                settype($duracion, "integer");
                echo "document.getElementById('duracion').value='$duracion';";
            }
            if(isset($_POST["genero"]) && $_POST['genero'] != ''){
                $generosFiltro = depurar($_POST['genero']);
                $generosSelect2 = "[";
                foreach ($generosFiltro as $generoFiltro) {
                    $generosSelect2 .= "'$generoFiltro',";
                }
                $generosSelect2 = substr($generosSelect2, 0, -1)."]";
                echo "generos = $generosSelect2;";
            }
            if(isset($_POST["director"]) && $_POST['director'] != ''){
                $directores = depurar($_POST['director']);
                $directoresSelect2 = "[";
                foreach ($directores as $director) {
                    $directoresSelect2 .= "'$director',";
                }
                $directoresSelect2 = substr($directoresSelect2, 0, -1)."]";
                echo "director = $directoresSelect2;";
            }
        ?>
        //Creación de una tabla dinámica con la librería datatables
        let table = new DataTable('#lista', {
            dom: "fl<'toolbar'>rtip",
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json',
            },
            scrollX: true
        });
        table.on( 'draw', function () {
            document.getElementById("lista_wrapper").style.backgroundColor="white";
            document.getElementById("lista_wrapper").style.marginBottom="10px";
            document.getElementById("lista_wrapper").style.padding="10px";
            document.getElementById("lista_wrapper").style.borderRadius="5px";
            document.getElementById("lista_length").style.position="sticky";
            document.getElementById("lista_length").style.left="0";
            document.getElementById("lista_info").style.position="sticky";
            document.getElementById("lista_info").style.left="0";
            document.getElementById("lista_paginate").style.position="sticky";
            document.getElementById("lista_paginate").style.left="0";
            document.getElementById("lista_filter").children[0].children[0].style.display="inline-block";
            document.getElementById("lista_filter").style.position="relative";
            document.getElementById("lista_filter").style.left="0";
            // Creación de un checkbox en la tabla para mostrar más o menos información
            // Requiere redibujarse al modificar la tabla
            document.querySelector('div.toolbar').innerHTML = '<label for="mostrar" class="pt-1" style="display: inline-block;"><span>Mostrando menos</span><input type="checkbox" name="mostrar" class="m-1" id="mostrar" style="display: inline-block;"></label>';
            document.querySelector('div.toolbar').style = 'text-align: center;';
            document.getElementsByClassName("dataTables_scrollHeadInner")[0].style="margin: 0 auto";
            table.columns([3,4,5,6,7]).visible(false);
            document.getElementById("mostrar").addEventListener("click", function(){
                if(document.getElementById("mostrar").checked){
                    mostrar = true;
                    document.getElementById("mostrar").parentNode.children[0].innerText = "Mostrando más";
                    table.columns([3,4,5,6,7]).visible(true);
                }
                else{
                    mostrar = false;
                    document.getElementById("mostrar").parentNode.children[0].innerText = "Mostrando menos";
                    table.columns([3,4,5,6,7]).visible(false);
                }
            });
            // Aplicar a los puntos suspensivos de la paginación un botón que permita saltar de página
            let suspensivos = document.getElementsByClassName("ellipsis");
            for (let i = 0; i < suspensivos.length; i++) {
                let suspensivo = suspensivos[i];
                suspensivo.innerHTML = '<button type="button" class="btn" data-toggle="modal" data-target="#saltarA" style="background-color: white;">...</button>';
            }
            // Si el checkbox que muestra más información está activo, se activa al redibujar
            if (mostrar){
                document.getElementById("mostrar").checked = "checked";
                document.getElementById("mostrar").parentNode.children[0].innerText = "Mostrando más";
                table.columns([3,4,5,6,7]).visible(true);
            }
            
        });
        $(document).ready(function() {
            // Cargar el select múltiple de la librería Select2
            // Tanto para el filtro de géneros
            $('#genero').select2();
            if(generos != ""){
                $('#genero').val(generos);
                $('#genero').trigger('change');
            }
            // Como el de directores
            $('#director').select2();
            if(director != ""){
                $('#director').val(director);
                $('#director').trigger('change');
            }
            // Como el de actores
            $('#actor').select2();
            if(actor != ""){
                $('#actor').val(actor);
                $('#actor').trigger('change');
            }
            // Función que se utiliza en el modal de búsqueda (más abajo) para saltar a la página indicada
            document.getElementById("buscar").addEventListener("click", function(){
                // Se recoge el valor introducido
                let pagina = parseInt(document.getElementById("saltarAX").value);
                // Si no es nulo:
                if (!isNaN(pagina)){
                    // Se recogen la primera y última página
                    let primera_pagina = parseInt(document.getElementsByClassName("paginate_button")[1].innerText);
                    let ultima_pagina = parseInt(document.getElementsByClassName("paginate_button")[document.getElementsByClassName("paginate_button").length-2].innerText);
                    // Si el valor introducido se encuentra entre ambas páginas, se "salta" (dibuja) a dicha página
                    if(pagina >= primera_pagina && pagina <= ultima_pagina){
                        table.page(pagina-1).draw("page");
                    }
                }
                // Se vacía el campo
                document.getElementById("saltarAX").value = "";
            });
        });
    </script>
    <!-- Modal de salto de página -->
    <div class="modal fade" id="saltarA" tabindex="-1" role="dialog" aria-labelledby="saltarA" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Saltar a...<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="justify-content: center; display: flex;">
                    <label for="saltarAX">
                        Introduce la página a la que quieres saltar:
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1" style="font-size: 1.4rem;">&#x1f59b;</span>
                            </div>
                            <input class="form-control" placeholder="Página" id="saltarAX" name="saltarAX" type="text" style="display: inline-block;">
                        </div>
                    </label>
                </div>
                <div class="modal-footer">
                    <button id="buscar" type="button" class="btn btn-success" data-dismiss="modal">Si</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>