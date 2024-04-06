<?php
            include "../depurar.php";
            include "../cabecera/cabeceraListas.php";
            /** Esta función comprueba que los datos obligatorios no estén vacíos */
            function add(){
                return (isset($_POST['nombre']) && $_POST['nombre'] != '' &&  
                isset($_POST['minimo']) && $_POST['minimo'] != '' && 
                isset($_POST['lugar']) && $_POST['lugar'] != '');
            }
            /** Función para redireccionar la página si se encuentra algún error en el formulario de adición/edición
             * Toma como parámetro opcional un id, en caso de ser redirección de edición
             */
            function redireccion($id = NULL){
                //Se marca el error, para asegurar que se manda como uno
                $redireccion = "error=error&";
                //Se comprueba que el parámetro de entrada no esté vacío
                if($id != NULL){
                    $redireccion .= "id=".$id."&";
                }
                //Se comprueba que el resto de datos no estén vacíos
                if(isset($_POST['nombre']) && $_POST['nombre'] != ''){
                    $redireccion .= "nombre=".depurar($_POST["nombre"])."&";
                }
                if(isset($_POST['minimo']) && $_POST['minimo'] != ''){
                    $redireccion .= "min_jug=".intval(depurar($_POST["minimo"]))."&";
                }
                if(isset($_POST['lugar']) && $_POST['lugar'] != ''){
                    $redireccion .= "lugar=".depurar($_POST["lugar"])."&";
                }
                if(isset($_POST['maximo']) && $_POST['maximo'] != ''){
                    $redireccion .= "max_jug=".intval(depurar($_POST["maximo"]))."&";
                }
                if(isset($_POST['durac']) && $_POST['durac'] != ''){
                    $redireccion .= "duracion=".intval(depurar($_POST["durac"]))."&";
                }
                header("Location: /juegos/additar.php?$redireccion");
            }
            //Si se añade un campo:
            if(isset($_POST["add"])){
                //Comprobar que los datos estén bien introducidos
                if(add()){
                    //Estos datos ya están comprobados, por lo que no se necesita hacer ninguna comprobación, pero si depuración
                    $nombre = depurar($_POST["nombre"]);
                    $min_jug = intval(depurar($_POST["minimo"]));
                    $lugar = depurar($_POST["lugar"]);
                    //Comprobar si el resto de datos se han rellenado. Si no, se marcan como NULL para la BBDD
                    if(isset($_POST['durac']) && $_POST['durac'] != ''){
                        $duracion = intval(depurar($_POST["durac"]));
                    }
                    else{
                        $duracion = "NULL";
                    }
                    if(isset($_POST['maximo']) && $_POST['maximo'] != ''){
                        $max_jug = intval(depurar($_POST["maximo"]));
                    }
                    else{
                        $max_jug = "NULL";
                    }
                    $consultaAdd = "INSERT INTO `juegos`(`nombre`, `duracion`, `min_jug`, `max_jug`, `lugar`) VALUES ('$nombre',$duracion,$min_jug,$max_jug,'$lugar')";
                }
                else{
                    redireccion();
                }
            }
            //Si se edita un campo (similar a la situación anterior):
            else if(isset($_POST["editar"])){
                if(add()){
                    $nombre = depurar($_POST["nombre"]);
                    $minimo = intval(depurar($_POST["minimo"]));
                    $lugar = depurar($_POST["lugar"]);
                    $id = intval(depurar($_POST["id"]));
                    if(isset($_POST['durac']) && $_POST['durac'] != ''){
                        $duracion = intval(depurar($_POST["durac"]));
                    }
                    else{
                        $duracion = "NULL";
                    }
                    if(isset($_POST['maximo']) && $_POST['maximo'] != ''){
                        $maximo = intval(depurar($_POST["maximo"]));
                    }
                    else{
                        $maximo = "NULL";
                    }
                    $consultaEditar = "UPDATE `juegos` SET `nombre`='$nombre',`duracion`=$duracion,`min_jug`='$minimo',`max_jug`=$maximo,`lugar`='$lugar' WHERE `id`=$id";
                }
                else{
                    $id = intval(depurar($_POST["id"]));
                    redireccion($id);
                }
            }

            //Si se añade un campo (o se edita), comprobar que se ejecuta correctamente el campo
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
            //Si se quiere eliminar un registro, se realiza una consulta de eliminación
            if(isset($_POST["eliminar"])){
                $id_eliminar = intval(depurar($_POST["id_eliminar"]));
                $consultaEliminar = "UPDATE juegos SET papelera=1 WHERE id=$id_eliminar";
                try{
                    $eliminado = $conectar->query($consultaEliminar);
                }
                catch(PDOException $error){
                    $eliminado = false;
                }
            }
        ?>
        <!-- Filtros -->
        <form action="/juegos/juegos.php" method="post" class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
            <div class="bg-danger mb-3 p-3 rounded">
                <b>&#9888; ¡Advertencia! &#9888;</b><br>
                Al filtrar, los tiempos o mínimos/máximos vacíos (con guión) no se toman en cuenta debido a su variabilidad
            </div>
            <div class="d-flex align-items-center text-center flex-column">
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center">
                    <label for="duracion" class="mr-md-3">Duración de partida (en minutos):<br><input id="duracion" type="number" name="duracion" min="1" style="display: inline-block;"></label>
                    <label for="jugadores" class="ml-md-3">Número de jugadores:<br><input id="jugadores" type="number" name="jugadores" min="1" style="display: inline-block;"></label>
                </div>
                <label for="aleatorio" class="mt-2"><input type="checkbox" name="aleatorio" id="aleatorio" style="display: inline-block;" class="m-1">Aleatorio</label>
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center" class="mt-2">
                    <label for="filtrar" class="mr-1"><input id="filtrar" type="submit" value="Filtrar" name="filtrar" style="display: inline-block;" class="btn btn-secondary"></label>
                    <label for="add" class="ml-1"><input id="add" type="submit" value="Añadir" name="add" style="display: inline-block;" class="btn btn-primary" formaction="/juegos/additar.php"></label>
                </div>
            </div>
        </form>

        <?php 
            //Si se añade, muestra un mensaje que confirme; si no, redirecciona
            if(isset($_POST["add"])){if($added){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Juego añadido &#10003;</b><br>
                    El juego ha sido añadido con éxito a la base de datos
                </div>
            </div>
        <?php } else{
            redireccion();
        } }?>

        <?php 
            //Si se edita, muestra un mensaje que confirme; si no, redirecciona
            if(isset($_POST["editar"])){if($editado){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Juego editado &#10003;</b><br>
                    El juego ha sido editado con éxito
                </div>
            </div>
        <?php } else{
            $id = intval(depurar($_POST["id"]));
            redireccion($id);
        } }?>

        <?php 
            //Si se elimina, muestra un mensaje que confirma; en otro caso, muestra un mensaje de error
            if(isset($_POST["eliminar"])){if($eliminado){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Juego eliminado &#10003;</b><br>
                    El juego se ha movido a la papelera
                </div>
            </div>
        <?php } else{ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-warning p-3 rounded">
                    <b>&#9888; Error &#9888;</b><br>
                    El juego no se ha podido eliminar
                </div>
            </div>
        <?php } }?>

        <!-- Tabla con los campos -->
        <table id="lista" class="table table-striped text-center" style="background: white; margin-top: 20px;">
            <thead>
                <tr>
                    <th class='align-middle'><b>Nombre</b></th>
                    <th class='align-middle'><b>Duración</b></th>
                    <th class='align-middle'><b>Mín. de jugadores</b></th>
                    <th class='align-middle'><b>Máx. de jugadores</b></th>
                    <th class='align-middle'><b>Lugar</b></th>
                    <th class='align-middle'>Edición</th>
                    <th class='align-middle'>Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Se crea la consulta a la base de datos, aplicando los filtros que procedan
                    $consulta = "SELECT * FROM juegos WHERE papelera=0";
                    if(isset($_POST['duracion']) && $_POST['duracion'] != ''){
                        $duracion = intval(depurar($_POST['duracion']));
                        $consulta .= " AND duracion<=".$duracion;
                    }
                    if(isset($_POST['jugadores']) && $_POST['jugadores'] != ''){
                        $jugadores = intval(depurar($_POST['jugadores']));
                        $consulta .= " AND min_jug<=$jugadores AND $jugadores<=max_jug";
                    }
                    if(isset($_POST["aleatorio"])){
                        $consulta .= " ORDER BY RAND() LIMIT 1";
                    }
                    try{
                        //Se ejecuta la consulta
                        $filas = $conectar->query($consulta)->fetchAll();
                        //Se recorren los campos uno a uno
                        foreach ($filas as $datos_juego) {
                            //Se crea la linea de la tabla
                            $id_edicion = $datos_juego[0];
                            $juego = "<tr id='$id_edicion'>";
                            //Se recorre los datos de la fila, saltando el id (comenzando en $i = 1). El conteo se hace hasta el máximo de datos de la fila entre dos
                            //y restando el número total de campos al final de la fila que no se usen ($i<$max/2-x)
                            for ($cont = 1;$cont<count($datos_juego)/2-2;$cont++){
                                //Se crea la celda 
                                $juego .= "<td class='align-middle'>";
                                if(empty($datos_juego[$cont])){//Si no existe el registro, se marca como vacío con un guión
                                    $juego .= "-";
                                }
                                else{
                                    $juego .= $datos_juego[$cont];
                                }
                                $juego .= "</td>";
                            }
                            //Se añaden las celdas finales para editar o eliminar el registro correspondiente
                            //Celda de edición
                            $juego .= '<td class="align-middle">
                                <form action="/juegos/additar.php" method="post">
                                    <input type="hidden" name="id_edicion" id="id_edicion" value="'.$id_edicion.'">
                                    <input id="editar" type="submit" value="Editar" name="editar" style="display: inline-block;" class="btn btn-info">
                                </form>
                            </td>';
                            //Celda de eliminación
                            $juego .= '<td class="align-middle">
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
                                            Estás a punto de eliminar el juego '.$datos_juego["nombre"].'<br>¿Quieres proceder?'.//Cuerpo del modal
                                        '</div>
                                        <div class="modal-footer">'.//Pie del modal
                                            '<form action="/juegos/juegos.php" method="post">
                                                <input type="hidden" name="id_eliminar" id="id_eliminar" value="'.$id_edicion.'">
                                                <input id="eliminar" value="Si" name="eliminar" type="submit" class="btn btn-danger">
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            $juego .= "</tr>";
                            print($juego);
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
        <?php
            //Comprobar que filtros se han aplicado para conservarlos
            if(isset($_POST["duracion"]) && $_POST['duracion'] != ''){
                $duracion = intval(depurar($_POST['duracion']));
                settype($duracion, "integer");
                echo "document.getElementById('duracion').value='$duracion';";
            }
            if(isset($_POST["jugadores"]) && $_POST['jugadores'] != ''){
                $jugadores = intval(depurar($_POST['jugadores']));
                settype($jugadores, "integer");
                echo "document.getElementById('jugadores').value='$jugadores';";
            }
            if(isset($_POST["aleatorio"])){
                echo "$('#aleatorio').prop('checked', true);";
            }
        ?>
        //Creación de una tabla dinámica con la librería datatables
        let table = new DataTable('#lista', {
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
            // Aplicar a los puntos suspensivos de la paginación un botón que permita saltar de página
            let suspensivos = document.getElementsByClassName("ellipsis");
            for (let i = 0; i < suspensivos.length; i++) {
                let suspensivo = suspensivos[i];
                suspensivo.innerHTML = '<button type="button" class="btn" data-toggle="modal" data-target="#saltarA" style="background-color: white;">...</button>';
            }
        });
        $(document).ready(function() {
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