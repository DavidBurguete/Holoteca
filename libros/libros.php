<?php
            include "../depurar.php";
            include "../cabecera/cabeceraListas.php";
            /** Esta función comprueba que los datos obligatorios no estén vacíos */
            function add(){
                $amano = false;
                // Comprobar que se edita un libro o se añade a mano
                if($_POST["aMano"] || isset($_POST["id"])){
                    $amano = (isset($_POST['nombreAmano']) && $_POST['nombreAmano'] != '' && isset($_POST['lugarAmano']) && $_POST['lugarAmano'] != '' &&
                    (
                        (isset($_POST['isbnAmano']) && $_POST['isbnAmano']) || (isset($_POST['dl']) && $_POST['dl'])
                    )
                    ) && (isset($_POST['pag']) && $_POST['pag'] != '') && (isset($_POST['author']) && $_POST['author'] != '');
                }
                else{
                    $amano = (isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['lugar']) && $_POST['lugar'] != '' && isset($_POST['isbn']) && $_POST['isbn']);
                }
                return $amano;
            }
            /** Función para redireccionar la página si se encuentra algún error en el formulario de adición/edición
             * Toma como parámetro opcional un id, en caso de ser redirección de edición.
             * Además toma un segundo parámetro, usado para detectar si un libro se añade a mano
             */
            function redireccion($id = NULL, $amano = false){
                //Se marca el error, para asegurar que se manda como uno
                $redireccion = "error=error&";
                //Se comprueba que los parámetros de entrada no estén vacíos
                if(!(isset($_POST['isbn']) && $_POST['isbn'] != '') && !(isset($_POST['isbnAmano']) && $_POST['isbnAmano'] != '') && !(isset($_POST['dl']) && $_POST['dl'] != '')){
                    $redireccion .= "requerido=requerido&";
                }
                if($_POST["aMano"]){
                    $redireccion .= "mostrar=mostrar&";
                }
                if($id != NULL){
                    $redireccion .= "id=".$id."&";
                }
                //Se comprueba que el resto de datos no estén vacíos
                //Si no se ha encontrado el libro en la API, se redirigen los datos a la sección manual
                if($amano){
                    $redireccion .= "mostrar=mostrar&amano=amano&";
                    if(isset($_POST['nombre']) && $_POST['nombre'] != ''){
                        $redireccion .= "nombreAmano=".depurar($_POST["nombre"])."&";
                    }
                    if(isset($_POST['lugar']) && $_POST['lugar'] != ''){
                        $redireccion .= "lugarAmano=".depurar($_POST["lugar"])."&";
                    }
                    if(isset($_POST['isbn']) && $_POST['isbn'] != ''){
                        $redireccion .= "isbnAmano=".depurar($_POST["isbn"])."&";
                    }
                }
                else{
                    if(isset($_POST['nombre']) && $_POST['nombre'] != ''){
                        $redireccion .= "nombre=".depurar($_POST["nombre"])."&";
                    }
                    if(isset($_POST['lugar']) && $_POST['lugar'] != ''){
                        $redireccion .= "lugar=".depurar($_POST["lugar"])."&";
                    }
                    if(isset($_POST['isbn']) && $_POST['isbn'] != ''){
                        $redireccion .= "isbn=".depurar($_POST["isbn"])."&";
                    }
                    if(isset($_POST['nombreAmano']) && $_POST['nombreAmano'] != ''){
                        $redireccion .= "nombreAmano=".depurar($_POST["nombreAmano"])."&";
                    }
                    if(isset($_POST['lugarAmano']) && $_POST['lugarAmano'] != ''){
                        $redireccion .= "lugarAmano=".depurar($_POST["lugarAmano"])."&";
                    }
                    if(isset($_POST['isbnAmano']) && $_POST['isbnAmano'] != ''){
                        $redireccion .= "isbnAmano=".depurar($_POST["isbnAmano"])."&";
                    }
                }
                //Si cualquiera de los campos se ha editado, se reescribe
                if(isset($_POST['titulo_original']) && $_POST['titulo_original'] != ''){
                    $redireccion .= "titulo_original=".depurar($_POST["titulo_original"])."&";
                }
                if(isset($_POST['pag']) && $_POST['pag'] != ''){
                    $redireccion .= "paginas=".depurar($_POST["pag"])."&";
                }
                if(isset($_POST['author']) && $_POST['author'] != ''){
                    $redireccion .= "autor=".depurar($_POST["author"])."&";
                }
                if(isset($_POST['edithorial']) && $_POST['edithorial'] != ''){
                    $redireccion .= "editorial=".depurar($_POST["edithorial"])."&";
                }
                if(isset($_POST['agno']) && $_POST['agno'] != ''){
                    $redireccion .= "agno=".depurar($_POST["agno"])."&";
                }
                if(isset($_POST['portada']) && $_POST['portada'] != ''){
                    $redireccion .= "portada=".depurar($_POST["portada"])."&";
                }
                if(isset($_POST['descripcion']) && $_POST['descripcion'] != ''){
                    $redireccion .= "descripcion=".depurar($_POST["descripcion"])."&";
                }
                if(isset($_POST['dl']) && $_POST['dl'] != ''){
                    $redireccion .= "deposito_legal=".depurar($_POST["dl"])."&";
                }
                if(isset($_POST['prestado']) && $_POST['prestado'] != ''){
                    $redireccion .= "prestado=".depurar($_POST["prestado"])."&";
                }
                header("Location: /libros/additar.php?$redireccion");
            }
            //Si se añade un campo:
            if(isset($_POST["add"])){
                //Comprobar que los datos estén bien introducidos
                if(add()){
                    //Si el libro se recoge desde la API (checkbox sin marcar)
                    if(!$_POST["aMano"]){
                        //Estos datos ya están comprobados, por lo que no se necesita hacer ninguna comprobación, pero si depuración
                        $nombre = depurar($_POST["nombre"]);
                        $lugar = depurar($_POST["lugar"]);
                        $isbn = depurar($_POST["isbn"]);
                        //Conectar con la API de Google
                        $url = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn");
                        $json = json_decode($url, true);
                        if($json["totalItems"] != 0){
                            //En caso de haber descripción, se procesa mejor con el primer enlace
                            $descripcion = $json["items"][0]["volumeInfo"]["description"];
                            //Se recoge el segundo enlace, el libro con más información en algunos casos
                            $url = file_get_contents($json["items"][0]["selfLink"]);
                            $json = json_decode($url, true)["volumeInfo"];
                            //Si del primer enlace no encuentra descripción, prueba con el segundo. Si tampoco encuentra, lo deja vacío
                            if($descripcion==NULL){
                                $descripcion = $json["description"];
                                $descripcion = $descripcion==NULL?"NULL":'"'.str_replace('"', '\"',str_replace("'","\'",$descripcion)).'"';
                            }
                            else{
                                //Si existe descripción, se "escapan" las comillas simples y dobles
                                $descripcion = '"'.str_replace('"', '\"',str_replace("'","\'",$descripcion)).'"';
                            }
                            //Igual que con la descripción, se escapan comillas
                            $titulo_original = str_replace('"', '\"',str_replace("'","\'",$json["title"]));
                            $autores = $json["authors"];
                            $paginas = $json["printedPageCount"];
                            $agno = explode("-",$json["publishedDate"])[0];
                            //Se utiliza una API para recoger exclusivamente las portadas de los libros
                            $portada = file_get_contents("https://covers.openlibrary.org/b/isbn/$isbn-L.jpg");
                            $editorial = $json["publisher"];
                            //Si la portada no existe, a pesar de que file_get_contents no procesa bien una imagen (no es texto plano),
                            //se puede utilizar para ver si existe una imagen o no según el número de caracteres que devuelva
                            if(strlen($portada)>=100){
                                $portada = "'https://covers.openlibrary.org/b/isbn/$isbn-L.jpg'";
                            }
                            else{
                                $portada = "NULL";
                            }
                            $listaAutores = "";
                            //El array de autores se convierte en un String
                            foreach ($autores as $autor) {
                                $listaAutores .= str_replace('"', '\"',str_replace("'","\'",$autor)).",";
                            }
                            $listaAutores = substr($listaAutores, 0, -1);
                            $consultaAdd = "INSERT INTO `libros`(`nombre`, `titulo_original`, `agno`, `paginas`, `autor`, `editorial`, `portada`, `descripcion`, `lugar`, `isbn`, `prestado`) VALUES ('$nombre','$titulo_original',$agno,$paginas,'$listaAutores','$editorial',$portada, $descripcion,'$lugar','$isbn',NULL);";
                        }
                        else{
                            //Si no encuentra el libro en la API, se redirigen los datos a la sección manual de la adición
                            redireccion(null, true);
                        }
                    }
                    //Se introduce un libro a mano o por depósito legal
                    else{
                        //Estos datos ya están comprobados, por lo que no se necesita hacer ninguna comprobación, pero si depuración
                        $nombre = depurar($_POST["nombreAmano"]);
                        $lugar = depurar($_POST["lugarAmano"]);
                        $paginas = intval(depurar($_POST["pag"]));
                        if($paginas < 1){
                            $paginas = "NULL";
                        }
                        $author = depurar($_POST["author"]);
                        //Comprobar si el resto de datos se han rellenado. Si no, se marcan como NULL para la BBDD
                        if(isset($_POST["isbnAmano"]) && $_POST["isbnAmano"] != ""){
                            $isbnDL = depurar($_POST["isbnAmano"]);
                            $ISBN_DL = "`isbn`";
                        }
                        else{
                            $isbnDL = depurar($_POST["dl"]);
                            $ISBN_DL = "`deposito_legal`";
                        }
                        if(isset($_POST['titulo_original']) && $_POST['titulo_original'] != ''){
                            $titulo_original = "'" . depurar($_POST["titulo_original"]) . "'";
                        }
                        else{
                            $titulo_original = "NULL";
                        }
                        if(isset($_POST['agno']) && $_POST['agno'] != ''){
                            $agno = intval(depurar($_POST["agno"]));
                        }
                        else{
                            $agno = "NULL";
                        }
                        if(isset($_POST['edithorial']) && $_POST['edithorial'] != ''){
                            $edithorial = "'" . depurar($_POST["edithorial"]) . "'";
                        }
                        else{
                            $edithorial = "NULL";
                        }
                        if(isset($_POST['portada']) && $_POST['portada'] != ''){
                            $portada = "'" . depurar($_POST["portada"]) . "'";
                        }
                        else{
                            $portada = "NULL";
                        }
                        if(isset($_POST['descripcion']) && $_POST['descripcion'] != ''){
                            $descripcion = "'" . depurar($_POST["descripcion"]) . "'";
                        }
                        else{
                            $descripcion = "NULL";
                        }
                        if(isset($_POST['prestado']) && $_POST['prestado'] != ''){
                            $prestado = "'" . depurar($_POST["prestado"]) . "'";
                        }
                        else{
                            $prestado = "NULL";
                        }
                        $consultaAdd = "INSERT INTO `libros`(`nombre`, `titulo_original`, `agno`, `paginas`, `autor`, `editorial`, `portada`, `descripcion`, `lugar`, $ISBN_DL, `prestado`) VALUES ('$nombre',$titulo_original,$agno,$paginas,'$author','$edithorial',$portada, $descripcion,'$lugar','$isbnDL',$prestado);";
                    }
                }
                else{
                    //Si los datos básicos no están bien introducidos, se redirije para completar el mínimo del formulario
                    redireccion();
                }
            }
            //Si se edita un campo (similar a la situación anterior):
            else if(isset($_POST["editar"])){
                //Si los datos están bien introducidos
                if(add()){
                    //No se hace conexión a la base de datos; los datos se pueden editar manualmente
                    $nombre = depurar($_POST["nombreAmano"]);
                    $pag = intval(depurar($_POST["pag"]));
                    if($pag < 1){
                        $pag = "NULL";
                    }
                    $author = depurar($_POST["author"]);
                    $lugar = depurar($_POST["lugarAmano"]);
                    $id = intval(depurar($_POST["id"]));
                    if(isset($_POST['titulo_original']) && $_POST['titulo_original'] != ''){
                        $titulo_original = "'" . depurar($_POST["titulo_original"]) . "'";
                    }
                    else{
                        $titulo_original = "NULL";
                    }
                    if(isset($_POST['isbnAmano']) && $_POST['isbnAmano'] != ''){
                        $isbn = "'" . depurar($_POST["isbnAmano"]) . "'";
                    }
                    else{
                        $isbn = "NULL";
                    }
                    if(isset($_POST['edithorial']) && $_POST['edithorial'] != ''){
                        $edithorial = "'" . depurar($_POST["edithorial"]) . "'";
                    }
                    else{
                        $edithorial = "NULL";
                    }
                    if(isset($_POST['dl']) && $_POST['dl'] != ''){
                        $dl = "'" . depurar($_POST["dl"]) . "'";
                    }
                    else{
                        $dl = "NULL";
                    }
                    if(isset($_POST['agno']) && $_POST['agno'] != ''){
                        $agno = "'" . depurar($_POST["agno"]) . "'";
                    }
                    else{
                        $agno = "NULL";
                    }
                    if(isset($_POST['portada']) && $_POST['portada'] != ''){
                        $portada = "'" . depurar($_POST["portada"]) . "'";
                    }
                    else{
                        $portada = "NULL";
                    }
                    if(isset($_POST['descripcion']) && $_POST['descripcion'] != ''){
                        $descripcion = "'" . depurar($_POST["descripcion"]) . "'";
                    }
                    else{
                        $descripcion = "NULL";
                    }
                    if(isset($_POST['prestado']) && $_POST['prestado'] != ''){
                        $prestado = "'" . depurar($_POST["prestado"]) . "'";
                    }
                    else{
                        $prestado = "NULL";
                    }
                    $consultaEditar = "UPDATE `libros` SET `nombre`='$nombre',`paginas`=$pag,`autor`='$author',`titulo_original`=$titulo_original,`editorial`=$edithorial,
                    `lugar`='$lugar',`isbn`=$isbn,`agno`=$agno,`portada`=$portada,`descripcion`=$descripcion,`deposito_legal`=$dl,`prestado`=$prestado WHERE `id`=$id";
                }
                else{
                    //Se redirecciona con el identificador del libro para recogerlo de la base
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
                $consultaEliminar = "UPDATE libros SET papelera=1 WHERE id=$id_eliminar";
                try{
                    $eliminado = $conectar->query($consultaEliminar);
                }
                catch(PDOException $error){
                    $eliminado = false;
                }
            }

            //Recoger de la BBDD la lista de autores y editoriales, que pueden cambiar con el tiempo
            $conexionAutores = true;
            $conexionEditoriales = true;
            try{
                $autores = $conectar->query("SELECT autor FROM `libros` WHERE autor IS NOT NULL GROUP BY autor")->fetchAll();
            }
            catch(PDOException $error){
                $conexionAutores = false;
            }
            try{
                $editoriales = $conectar->query("SELECT editorial FROM `libros` WHERE editorial IS NOT NULL GROUP BY editorial")->fetchAll();
            }
            catch(PDOException $error){
                $conexionEditoriales = false;
            }

            // El "echo" usado más adelante para imprimir en el filtro impiden usar el Header Location, por ello, en esta página únicamente
            // se utiliza antes, aunque visualmente pueda quedar peor
            // Si no se puede añadir o editar un libro en la BBDD, se redirecciona para intentarlo otra vez
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
        <form action="/libros/libros.php" method="post" class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
            <div class="d-flex align-items-center text-center flex-column">
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center">
                    <label for="paginas" class="mr-md-2 ml-lg-2">Páginas:<br><input id="paginas" type="number" name="paginas" min="1" style="display: inline-block;"></label>
                    <?php
                        // Si la base de datos devuelve los autores...*
                        if($conexionAutores){
                    ?>
                    <label for="autor" class="ml-md-2 mr-md-2">
                        Autor/a:<br>
                        <select id="autor" multiple="multiple" name="autor[]" style="display: inline-block;">
                            <?php
                                // *... se recorren para separarlos y poder seleccionarlos individualmente
                                $arrayAutores = [];
                                // Bucle que separa los autores
                                foreach ($autores as $autorIndividual) {
                                    // Separamos por cada autor en un registro
                                    $autoresSplit = explode(",", $autorIndividual[0]);
                                    foreach ($autoresSplit as $autorSplit) {
                                        $autorSplit = trim($autorSplit);
                                        // Si el autor no está en la lista, se añade
                                        if (!in_array($autorSplit, $arrayAutores)){
                                            array_push($arrayAutores, $autorSplit);
                                        }
                                    }
                                }
                                // Añadir los autores al desplegable
                                foreach ($arrayAutores as $arrayAutor) {
                                    echo "<option value='$arrayAutor'>$arrayAutor</option>";
                                }
                            ?>
                        </select>
                    </label>
                    <?php
                        }
                        // Si la base de datos ha lanzado un error, no se muestra el <select> de autores
                        else{
                            echo "<p class='col-5'><span class='text-danger'>Error</span>: No se han podido listar los autores</p>";
                        }
                        // Si la base de datos devuelve las editoriales...*
                        if($conexionEditoriales){
                    ?>
                    <label for="editorial" class="mr-md-2 ml-md-2">
                        Editorial:<br>
                        <select id="editorial" multiple="multiple" name="editorial[]" style="display: inline-block;">
                            <?php
                                // *... se recorren para añadirlas al <select>
                                foreach ($editoriales as $editorialIndividual) {
                                    echo "<option value='$editorialIndividual[0]'>$editorialIndividual[0]</option>";
                                }
                            ?>
                        </select>
                    </label>
                    <?php
                        }
                        // Si la base de datos lanza un error, no se muestran las editoriales
                        else{
                            echo "<p class='col-5'><span class='text-danger'>Error</span>: No se han podido listar las editoriales</p>";
                        }
                    ?>
                </div>
                <label for="aleatorio" class="mt-2"><input type="checkbox" name="aleatorio" id="aleatorio" style="display: inline-block;" class="m-1">Aleatorio</label>
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center" class="mt-2">
                    <label for="filtrar" class="mr-1"><input id="filtrar" type="submit" value="Filtrar" name="filtrar" style="display: inline-block;" class="btn btn-secondary"></label>
                    <label for="add" class="ml-1"><input id="add" type="submit" value="Añadir" name="add" style="display: inline-block;" class="btn btn-primary" formaction="/libros/additar.php"></label>
                </div>
            </div>
        </form>

        <?php 
            // Si se ha añadido un libro con éxito, se muestra un mensaje que lo confirme al usuario
            if(isset($_POST["add"])){if($added){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Libro añadido &#10003;</b><br>
                    El libro ha sido añadido con éxito a la base de datos
                </div>
            </div>
        <?php } }?>

        <?php 
            // Si se ha editado un libro con éxito, se muestra un mensaje que lo confirme al usuario
            if(isset($_POST["editar"])){if($editado){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Libro editado &#10003;</b><br>
                    El libro ha sido editado con éxito
                </div>
            </div>
        <?php } }?>

        <?php 
            // Si se ha "eliminado" un libro con éxito, se muestra un mensaje que lo confirme al usuario
            if(isset($_POST["eliminar"])){if($eliminado){ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-success p-3 rounded">
                    <b>Libro eliminado &#10003;</b><br>
                    El libro se ha movido a la papelera
                </div>
            </div>
        <?php } 
            // Si ha ocurrido un error, se muestra al usuario
            else{ ?>
            <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                <div class="bg-warning p-3 rounded">
                    <b>&#9888; Error &#9888;</b><br>
                    El libro no se ha podido eliminar
                </div>
            </div>
        <?php } }?>

        <!-- Tabla con los campos -->
        <table id="lista" class="table table-striped text-center" style="background: white; margin-top: 20px;">
            <thead>
                <tr>
                    <th class='align-middle'><b>Nombre</b></th>
                    <th class='align-middle'><b>Páginas</b></th>
                    <th class='align-middle'><b>Autor/a</b></th>
                    <th class='align-middle'><b>Editorial</b></th>
                    <th class='align-middle'><b>Lugar</b></th>
                    <th class='align-middle'><b>Prestado a</b></th>
                    <th class='align-middle'>Edición</th>
                    <th class='align-middle'>Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Se crea la consulta a la base de datos, aplicando los filtros que procedan
                    $consulta = "SELECT * FROM libros WHERE papelera=0";
                    if(isset($_POST['paginas']) && $_POST['paginas'] != ''){
                        $paginas = intval(depurar($_POST['paginas']));
                        $consulta .= " AND paginas<=".$paginas;
                    }
                    if(isset($_POST["autor"])){
                        $autoresFiltrados = $_POST["autor"];
                        $consulta .= " AND (";
                        foreach ($autoresFiltrados as $autorFiltrado) {
                            $autorFiltrado = depurar($autorFiltrado);
                            $consulta .= "autor LIKE '%$autorFiltrado%' OR ";
                        }
                        $consulta = substr($consulta, 0, -4) . ")";
                    }
                    if(isset($_POST["editorial"])){
                        $editorialesFiltrados = $_POST["editorial"];
                        $consulta .= " AND (";
                        foreach ($editorialesFiltrados as $editorialFiltrado) {
                            $editorialFiltrado = depurar($editorialFiltrado);
                            $consulta .= "editorial = '$editorialFiltrado' OR ";
                        }
                        $consulta = substr($consulta, 0, -4) . ")";
                    }
                    if(isset($_POST["aleatorio"])){
                        $consulta .= " ORDER BY RAND() LIMIT 1";
                    }
                    try{
                        //Se ejecuta la consulta
                        $filas = $conectar->query($consulta)->fetchAll();
                        //Se recorren los campos uno a uno
                        foreach ($filas as $datos_libro) {
                            //Se crea la linea de la tabla
                            $id_edicion = $datos_libro[0];
                            $libro = "<tr id='$id_edicion'>";
                            //Se recorre los datos de la fila, saltando el id (comenzando en $i = 1). El conteo se hace hasta el máximo de datos de la fila entre dos
                            //y restando el número total de campos al final de la fila que no se usen ($i<$max/2-x)
                            for ($cont = 1;$cont<count($datos_libro)/2-7;$cont++){
                                //Se crea la celda 
                                $libro .= "<td class='align-middle'><a href='./ficha.php?id=$id_edicion'><div>";
                                if(empty($datos_libro[$cont])){//Si no existe el registro, se marca como vacío con un guión
                                    $libro .= "-";
                                }
                                else{
                                    $libro .= $datos_libro[$cont];
                                }
                                $libro .= "</div></a></td>";
                            }
                            //Se añaden las celdas finales para editar o eliminar el registro correspondiente
                            //Celda de edición
                            $libro .= '<td class="align-middle">
                                <form action="/libros/additar.php" method="post">
                                    <input type="hidden" name="id_edicion" id="id_edicion" value="'.$id_edicion.'">
                                    <input id="editar" type="submit" value="Editar" name="editar" style="display: inline-block;" class="btn btn-info">
                                </form>
                            </td>';
                            //Celda de eliminación
                            $libro .= '<td class="align-middle">
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
                                            Estás a punto de eliminar el libro '.$datos_libro["nombre"].'<br>¿Quieres proceder?'.//Cuerpo del modal
                                        '</div>
                                        <div class="modal-footer">'.//Pie del modal
                                            '<form action="/libros/libros.php" method="post">
                                                <input type="hidden" name="id_eliminar" id="id_eliminar" value="'.$id_edicion.'">
                                                <input id="eliminar" value="Si" name="eliminar" type="submit" class="btn btn-danger">
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            $libro .= "</tr>";
                            print($libro);
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
        let autores = "";
        let editoriales = "";
        <?php
            //Comprobar que filtros se han aplicado para conservarlos
            if(isset($_POST["paginas"]) && $_POST['paginas'] != ''){
                $paginas = intval(depurar($_POST['paginas']));
                settype($paginas, "integer");
                echo "document.getElementById('paginas').value='$paginas';";
            }
            if(isset($_POST["autor"]) && $_POST['autor'] != ''){
                $autores = $_POST['autor'];
                $autoresSelect2 = "[";
                foreach ($autores as $autor) {
                    $autor = depurar($autor);
                    $autoresSelect2 .= "'$autor',";
                }
                $autoresSelect2 = substr($autoresSelect2, 0, -1)."]";
                echo "autores = $autoresSelect2;";
            }
            if(isset($_POST["editorial"]) && $_POST['editorial'] != ''){
                $editoriales = $_POST['editorial'];
                $editorialesSelect2 = "[";
                foreach ($editoriales as $editorial) {
                    $editorial = depurar($editorial);
                    $editorialesSelect2 .= "'$editorial',";
                }
                $editorialesSelect2 = substr($editorialesSelect2, 0, -1)."]";
                echo "editoriales = $editorialesSelect2;";
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
            // Cargar el select múltiple de la librería Select2
            // Tanto para el filtro de autores
            $('#autor').select2();
            if(autores != ""){
                $('#autor').val(autores);
                $('#autor').trigger('change');
            }
            // Como el de editoriales
            $('#editorial').select2();
            if(editoriales != ""){
                $('#editorial').val(editoriales);
                $('#editorial').trigger('change');
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