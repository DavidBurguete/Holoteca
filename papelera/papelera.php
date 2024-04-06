<?php
            include "../depurar.php";
            include "../cabecera/cabeceraListas.php";
            ?>
        <div class="col-lg-4 col-md-6" style="margin: 0 auto">
            <button type="button" class="rounded w-100 h3 bg-dark text-center text-light p-3" data-toggle="modal" data-target="#vaciarPapelera" style="outline: 0px; border: 0px;">Vaciar papelera <b class="h2 font-weight-bold">&#9842;</b></button>
        </div>
            <?php
            // Si se restaura alguno de los campos de la base de datos:
            if(isset($_POST["restaurarJuego"])){
                // Recoger el id del registro
                $idJuego = intval(depurar($_POST["idJuego"]));
                // Crear la consulta de restauración
                $restaurarJuego = "UPDATE `juegos` SET `papelera`=0 WHERE `id`=$idJuego";
                $restaurarJuegoQuery = false;
                // Ejecutar dicha consulta
                try{
                    $restaurarJuegoQuery = $conectar->query($restaurarJuego);
                }
                catch(PDOException $error){
                    $restaurarJuegoQuery = false;
                }
                // Si no se puede ejecutar el registro o el valor del id es inválido, lanza un error
                if(!$restaurarJuegoQuery || $idJuego < 1){
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-warning rounded p-3"><b>&#9888;</b> No se ha podido localizar el juego <b>&#9888;</b></p>
                    </div>
                    <?php
                }
            }
            else if(isset($_POST["restaurarLibro"])){
                $idLibro = intval(depurar($_POST["idLibro"]));
                $restaurarLibro = "UPDATE `libros` SET `papelera`=0 WHERE `id`=$idLibro";
                $restaurarLibroQuery = false;
                try{
                    $restaurarLibroQuery = $conectar->query($restaurarLibro);
                }
                catch(PDOException $error){
                    $restaurarLibroQuery = false;
                }
                if(!$restaurarLibroQuery || $idLibro < 1){
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-warning rounded p-3"><b>&#9888;</b> No se ha podido localizar el libro <b>&#9888;</b></p>
                    </div>
                    <?php
                }
            }
            else if(isset($_POST["restaurarPeli"])){
                $idPeli = intval(depurar($_POST["idPeli"]));
                $restaurarPeli = "UPDATE `peliculas` SET `papelera`=0 WHERE `id`=$idPeli";
                $restaurarPeliQuery = false;
                try{
                    $restaurarPeliQuery = $conectar->query($restaurarPeli);
                }
                catch(PDOException $error){
                    $restaurarPeliQuery = false;
                }
                if(!$restaurarPeliQuery || $idPeli < 1){
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-warning rounded p-3"><b>&#9888;</b> No se ha podido localizar la película o serie <b>&#9888;</b></p>
                    </div>
                    <?php
                }
            }
            // Si se confirma la eliminación de UN ÚNICO registro
            if(isset($_POST["eliminarJuego"])){
                // Recoger el id del registro
                $idEliminarJuego = intval(depurar($_POST["idEliminarJuego"]));
                // Crear la consulta de eliminación definitiva
                $eliminarJuego = "DELETE FROM `juegos` WHERE `id`=$idEliminarJuego";
                $eliminarJuegoQuery = false;
                // Ejecutar dicha consulta
                try{
                    $eliminarJuegoQuery = $conectar->query($eliminarJuego);
                }
                catch(PDOException $error){
                    $eliminarJuegoQuery = false;
                }
                // Si no se puede ejecutar la consulta o el valor del id es inválido, lanza un error
                if(!$eliminarJuegoQuery || $idEliminarJuego < 1){
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-warning rounded p-3"><b>&#9888;</b> No se ha podido eliminar el juego <b>&#9888;</b></p>
                    </div>
                    <?php
                }
                // Si se ha eliminado, se confirma al usuario
                else {
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-danger rounded p-3"><b>&#10003;</b> El juego ha sido eliminado <b>permanentemente &#10003;</b></p>
                    </div>
                    <?php
                }
            }
            else if(isset($_POST["eliminarLibro"])){
                $idEliminarLibro = intval(depurar($_POST["idEliminarLibro"]));
                $eliminarLibro = "DELETE FROM `libros` WHERE `id`=$idEliminarLibro";
                $eliminarLibroQuery = false;
                try{
                    $eliminarLibroQuery = $conectar->query($eliminarLibro);
                }
                catch(PDOException $error){
                    $eliminarLibroQuery = false;
                }
                if(!$eliminarLibroQuery || $idEliminarLibro < 1){
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-warning rounded p-3"><b>&#9888;</b> No se ha podido eliminar el libro <b>&#9888;</b></p>
                    </div>
                    <?php
                }
                else {
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-danger rounded p-3"><b>&#10003;</b> El libro ha sido eliminado <b>permanentemente &#10003;</b></p>
                    </div>
                    <?php
                }
            }
            else if(isset($_POST["eliminarPeli"])){
                $idEliminarPeli = intval(depurar($_POST["idEliminarPeli"]));
                $eliminarPeli = "DELETE FROM `peliculas` WHERE `id`=$idEliminarPeli";
                $eliminarPeliQuery = false;
                try{
                    $eliminarPeliQuery = $conectar->query($eliminarPeli);
                }
                catch(PDOException $error){
                    $eliminarPeliQuery = false;
                }
                if(!$eliminarPeliQuery || $idEliminarPeli < 1){
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-warning rounded p-3"><b>&#9888;</b> No se ha podido eliminar la película/serie <b>&#9888;</b></p>
                    </div>
                    <?php
                }
                else {
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-danger rounded p-3"><b>&#10003;</b> La película/serie ha sido eliminada <b>permanentemente &#10003;</b></p>
                    </div>
                    <?php
                }
            }
            if(isset($_POST["eliminarTodo"])){
                //Cada línea se ejecuta por separado, porque luego no se dibuja la página
                // Cargar las consultas
                $eliminarTodoJuegos = "DELETE FROM `juegos` WHERE `papelera`=1";
                $eliminarTodoLibros = "DELETE FROM `libros` WHERE `papelera`=1";
                $eliminarTodoPeliculas = "DELETE FROM `peliculas` WHERE `papelera`=1";
                $eliminarTodoQuery = false;
                // Ejecutar las consultas
                try{
                    $eliminarTodoQuery = $conectar->query($eliminarTodoJuegos);
                }
                catch(PDOException $error){
                    $eliminarTodoQuery = false;
                }
                try{
                    $eliminarTodoQuery = $conectar->query($eliminarTodoLibros);
                }
                catch(PDOException $error){
                    $eliminarTodoQuery = false;
                }
                try{
                    $eliminarTodoQuery = $conectar->query($eliminarTodoPeliculas);
                }
                catch(PDOException $error){
                    $eliminarTodoQuery = false;
                }
                // Se vacíe o no la papelera del todo, se muestra un mensaje de lo ocurrido al usuario
                if(!$eliminarTodoQuery){
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-warning rounded p-3"><b>&#9888;</b> No se ha podido vaciar la papelera <b>&#9888;</b></p>
                    </div>
                    <?php
                }
                else {
                    ?>
                    <div class="container">
                        <p class="h3 text-center bg-success rounded p-3"><b>&#10003;</b> La papelera ha sido <b class="rounded p-1 bg-dark text-danger">vaciada</b> <b>&#10003;</b></p>
                    </div>
                    <?php
                }
            }
        ?>
        <div class="d-flex align-items-center flex-wrap">
            <div class="flex-fill col-md align-self-baseline">
                <?php
                    // Recoger todos los registros que se enviasen a la papelera
                    $consulta = "SELECT * FROM juegos WHERE papelera=1";
                    try{
                        $filas = $conectar->query($consulta)->fetchAll();
                ?>
                <div class="mb-3 rounded p-2 text-center h3 bg-white" style="margin-top: 20px">
                    <b>
                        Juegos
                    </b>
                </div>
                <table id="listaJuegos" class="table table-striped text-center bg-white" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th class='align-middle'><b>Nombre</b></th>
                            <th class='align-middle'>Restaurar</th>
                            <th class='align-middle'>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Dibujar los registros
                            foreach ($filas as $datos_juego) {
                                $juego = "<tr id='$datos_juego[0]'>
                                <td class='align-middle'>
                                    $datos_juego[1]
                                </td>";
                                $idJuego = $datos_juego[0];
                                // Botón de restaurar
                                $juego .= '<td class="align-middle">
                                    <form action="/papelera/papelera.php" method="post">
                                        <input type="hidden" name="idJuego" id="idJuego" value="'.$idJuego.'">
                                        <input id="restaurarJuego" type="submit" value="Restaurar" name="restaurarJuego" class="btn btn-success" style="display: inline-block;">
                                    </form>
                                </td>';
                                // Botón de eliminar
                                $juego .= '<td class="align-middle">
                                    <form action="/papelera/papelera.php" method="post">
                                        <input type="hidden" name="idEliminarJuego" id="idEliminarJuego" value="'.$idJuego.'">
                                        <input id="eliminarJuego" type="submit" value="Eliminar" name="eliminarJuego" style="display: inline-block;" class="btn btn-danger">
                                    </form>
                                </td>';
                                $juego .= "</tr>";
                                print($juego);
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    }
                    // Si ocurre un error en la Base de Datos, se muestra al usuario
                    catch(PDOException $error){
                        echo '<div class="rounded p-2 text-center h3 bg-white" style="margin-top: 20px">
                            <p class="mb-0 p-3">No se ha podido recoger la tabla de juegos</p>
                        </div>';
                    }
                ?>
            </div>

            <div class="flex-fill col-md align-self-baseline">
                <?php
                    $consulta = "SELECT * FROM libros WHERE papelera=1";
                    try{
                        $filas = $conectar->query($consulta)->fetchAll();
                ?>
                <div class="mb-3 rounded p-2 text-center h3 bg-white" style="margin-top: 20px">
                    <b>
                        Libros
                    </b>
                </div>
                <table id="listaLibros" class="table table-striped text-center bg-white" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th class='align-middle'><b>Nombre</b></th>
                            <th class='align-middle'>Restaurar</th>
                            <th class='align-middle'>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($filas as $datos_libro) {
                                $libro = "<tr id='$datos_libro[0]'>
                                <td class='align-middle'>
                                    $datos_libro[1]
                                </td>";
                                $idLibro = $datos_libro[0];
                                $libro .= '<td class="align-middle">
                                    <form action="/papelera/papelera.php" method="post">
                                        <input type="hidden" name="idLibro" id="idLibro" value="'.$idLibro.'">
                                        <input id="restaurarLibro" type="submit" value="Restaurar" name="restaurarLibro" class="btn btn-success" style="display: inline-block;">
                                    </form>
                                </td>';
                                $libro .= '<td class="align-middle">
                                    <form action="/papelera/papelera.php" method="post">
                                        <input type="hidden" name="idEliminarLibro" id="idEliminarLibro" value="'.$idLibro.'">
                                        <input id="eliminarLibro" type="submit" value="Eliminar" name="eliminarLibro" style="display: inline-block;" class="btn btn-danger">
                                    </form>
                                </td>';
                                $libro .= "</tr>";
                                print($libro);
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    }
                    catch(PDOException $error){
                        echo '<div class="rounded p-2 text-center h3 bg-white" style="margin-top: 20px">
                            <p class="mb-0 p-3">No se ha podido recoger la tabla de libros</p>
                        </div>';
                    }
                ?>
            </div>

            <div class="flex-fill col-lg-6 align-self-baseline" style="margin: 0 auto;">
                <?php
                    $consulta = "SELECT * FROM peliculas WHERE papelera=1";
                    try{
                        $filas = $conectar->query($consulta)->fetchAll();
                ?>
                <div class="mb-3 rounded p-2 text-center h3 bg-white" style="margin-top: 20px">
                    <b>
                        Películas
                    </b>
                </div>
                <table id="listaPelis" class="table table-striped text-center bg-white" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th class='align-middle'><b>Nombre</b></th>
                            <th class='align-middle'>Restaurar</th>
                            <th class='align-middle'>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($filas as $datos_peli) {
                                $peli = "<tr id='$datos_peli[0]'>
                                <td class='align-middle'>
                                    $datos_peli[1]
                                </td>";
                                $idPeli = $datos_peli[0];
                                $peli .= '<td class="align-middle">
                                    <form action="/papelera/papelera.php" method="post">
                                        <input type="hidden" name="idPeli" id="idPeli" value="'.$idPeli.'">
                                        <input id="restaurarPeli" type="submit" value="Restaurar" name="restaurarPeli" class="btn btn-success" style="display: inline-block;">
                                    </form>
                                </td>';
                                $peli .= '<td class="align-middle">
                                    <form action="/papelera/papelera.php" method="post">
                                        <input type="hidden" name="idEliminarPeli" id="idEliminarPeli" value="'.$idPeli.'">
                                        <input id="eliminarPeli" type="submit" value="Eliminar" name="eliminarPeli" style="display: inline-block;" class="btn btn-danger">
                                    </form>
                                </td>';
                                $peli .= "</tr>";
                                print($peli);
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    }
                    catch(PDOException $error){
                        echo '<div class="rounded p-2 text-center h3 bg-white" style="margin-top: 20px">
                            <p class="mb-0 p-3">No se ha podido recoger la tabla de películas/series</p>
                        </div>';
                    }
                ?>
            </div>
        </div>
        <?php
            // Se desconecta de la base de datos
            $conectar=null;
        ?>
    </div>
    <script>
        // Se convierten las tablas en tablas dinámicas con la librería DataTable
        let tableJuegos = new DataTable('#listaJuegos', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json',
            },
            scrollX: true
        });
        let tableLibros = new DataTable('#listaLibros', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json',
            },
            scrollX: true
        });
        let tablePelis = new DataTable('#listaPelis', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json',
            },
            scrollX: true
        });
        tableJuegos.on( 'draw', function () {
            document.getElementById("listaJuegos_wrapper").style.backgroundColor="white";
            document.getElementById("listaJuegos_wrapper").style.marginBottom="10px";
            document.getElementById("listaJuegos_wrapper").style.padding="10px";
            document.getElementById("listaJuegos_wrapper").style.borderRadius="5px";
            document.getElementById("listaJuegos_length").style.position="sticky";
            document.getElementById("listaJuegos_length").style.left="0";
            document.getElementById("listaJuegos_info").style.position="sticky";
            document.getElementById("listaJuegos_info").style.left="0";
            document.getElementById("listaJuegos_paginate").style.position="sticky";
            document.getElementById("listaJuegos_paginate").style.left="0";
            document.getElementById("listaJuegos_filter").children[0].children[0].style.display="inline-block";
            document.getElementById("listaJuegos_filter").style.position="sticky";
            document.getElementById("listaJuegos_filter").style.left="0";
            // En vez de aplicarlo en un bucle, forzarlo de esta manera asegura que al cargar la página esté centrada la cabecera
            // en vez de que la página espere a ser redimensionada para aplicar el cambio (aplica a todas las tablas)
            document.getElementsByClassName("dataTables_scrollHeadInner")[0].style="margin: 0 auto";
            tableJuegos.columns([0]).visible(true);
        });
        tableLibros.on( 'draw', function () {
            document.getElementById("listaLibros_wrapper").style.backgroundColor="white";
            document.getElementById("listaLibros_wrapper").style.marginBottom="10px";
            document.getElementById("listaLibros_wrapper").style.padding="10px";
            document.getElementById("listaLibros_wrapper").style.borderRadius="5px";
            document.getElementById("listaLibros_length").style.position="sticky";
            document.getElementById("listaLibros_length").style.left="0";
            document.getElementById("listaLibros_info").style.position="sticky";
            document.getElementById("listaLibros_info").style.left="0";
            document.getElementById("listaLibros_paginate").style.position="sticky";
            document.getElementById("listaLibros_paginate").style.left="0";
            document.getElementById("listaLibros_filter").children[0].children[0].style.display="inline-block";
            document.getElementById("listaLibros_filter").style.position="sticky";
            document.getElementById("listaLibros_filter").style.left="0";
            document.getElementsByClassName("dataTables_scrollHeadInner")[1].style="margin: 0 auto";
            tableLibros.columns([0]).visible(true);
        });
        tablePelis.on( 'draw', function () {
            document.getElementById("listaPelis_wrapper").style.backgroundColor="white";
            document.getElementById("listaPelis_wrapper").style.marginBottom="10px";
            document.getElementById("listaPelis_wrapper").style.padding="10px";
            document.getElementById("listaPelis_wrapper").style.borderRadius="5px";
            document.getElementById("listaPelis_length").style.position="sticky";
            document.getElementById("listaPelis_length").style.left="0";
            document.getElementById("listaPelis_info").style.position="sticky";
            document.getElementById("listaPelis_info").style.left="0";
            document.getElementById("listaPelis_paginate").style.position="sticky";
            document.getElementById("listaPelis_paginate").style.left="0";
            document.getElementById("listaPelis_filter").children[0].children[0].style.display="inline-block";
            document.getElementById("listaPelis_filter").style.position="sticky";
            document.getElementById("listaPelis_filter").style.left="0";
            document.getElementsByClassName("dataTables_scrollHeadInner")[2].style="margin: 0 auto";
            tablePelis.columns([0]).visible(true);
        });
    </script>
    <!-- Modal de vaciado de la papelera -->
    <div class="modal fade" id="vaciarPapelera" tabindex="-1" role="dialog" aria-labelledby="vaciarPapelera" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h4">Vaciar papelera</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="justify-content: center; display: flex;">
                    <p>Estás a punto de vaciar la papelera. ¿Estás <b class="text-danger">seguro</b>?</p>
                    <br>
                </div>
                <div class="modal-footer">
                    <form action="/papelera/papelera.php" method="post">
                        <input id="eliminarTodo" value="Si" name="eliminarTodo" type="submit" class="btn btn-danger">
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>