        <?php
            include "../depurar.php";
            include "../cabecera/cabeceraListas.php";
            //Comprobar si se está editando un libro, y recogerlo de la base de datos
            $fila = true;
            if(isset($_POST["editar"])){
                $id = intval(depurar($_POST["id_edicion"]));
                try{
                    $fila = $conectar->query("SELECT * FROM `libros` WHERE `id`=$id")->fetch();
                }
                catch(PDOException $error){
                    $fila = false;
                }
            }
            //Desconectarse de la base
            $conectar=null;
            //Si no se encuentra el libro se lanza un error de conexión
            if(!$fila){
                echo "<div class='container text-center h3 font-weight-bold bg-light p-3 mb-3 rounded'><span class='text-danger'>No</span> se han podido recoger los datos. Intentalo <span class='text-success'>otra vez</span></div>";
            }
            //Cuando se redirecciona por falta de datos, datos no válidos o hay problemas de conexión, muestra un mensaje de error
            if(isset($_GET["error"]) && $_GET["error"] == "error"){
            ?>
                <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                    <div class="bg-warning p-3 rounded">
                        <b>&#9888; Error &#9888;</b><br>
                        El libro no se ha podido 
                        <?php
                            if(!isset($_GET["amano"])){
                                if(isset($_GET["id"])){
                                    echo "editar correctamente";
                                }
                                else{
                                    echo "añadir a la base de datos";
                                }
                                if(isset($_GET["requerido"])){
                                    echo "<br>Se requiere el ISBN o el depósito legal";
                                }
                            }
                            else{
                                echo "encontrar online<br>Los datos se deben introducir a mano";
                            }
                        ?> 
                    </div>
                </div>
            <?php }?>
        <form action="/libros/libros.php" method="post" class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
            <div class="d-flex align-items-center text-center flex-column">
                <?php
                    if(!isset($_POST["editar"]) && !isset($_GET["id"])){
                        //Estos campos solo se muestran cuando se añade un libro
                ?>
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center">
                    <label id="campoNombre" for="nombre" class="mr-md-3 ml-md-3">Nombre del libro:<br><input required id="nombre" type="text" name="nombre" style="display: inline-block;"></label>
                    <label id="campoLugar" for="lugar" class="ml-md-3 mr-md-3">Lugar:<br><input required id="lugar" type="text" name="lugar" style="display: inline-block;"></label>
                    <label id="campoISBN" for="isbn" class="ml-md-3 mr-md-3">ISBN:<br><input required id="isbn" type="text" name="isbn" style="display: inline-block;"></label>
                </div>
                <label for="aMano">
                    <input type="checkbox" name="aMano" id="aMano" style="display: inline-block;">
                    Introducir libro con depósito legal o datos a mano
                </label>
                <?php }?>
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center" id="oculto">
                    <label for="nombreAmano" class="mr-md-3 ml-md-3">Nombre del libro:<br><input required id="nombreAmano" type="text" name="nombreAmano" style="display: inline-block;"></label>
                    <label for="lugarAmano" class="ml-md-3 mr-md-3">Lugar:<br><input required id="lugarAmano" type="text" name="lugarAmano" style="display: inline-block;"></label>
                    <label for="isbnAmano" class="ml-md-3 mr-md-3">ISBN:<br><input id="isbnAmano" type="text" name="isbnAmano" style="display: inline-block;"></label>
                    <label for="titulo_original" class="ml-md-3 mr-md-3">Título original:<br><input id="titulo_original" type="text" name="titulo_original" style="display: inline-block;"></label>
                    <label for="pag" class="ml-md-3 mr-md-3">Páginas:<br><input required id="pag" type="number" name="pag" style="display: inline-block;"></label>
                    <label for="author" class="ml-md-3 mr-md-3">Autor/es:<br><input required id="author" type="text" name="author" style="display: inline-block;"></label>
                    <label for="edithorial" class="ml-md-3 mr-md-3">Editorial:<br><input id="edithorial" type="text" name="edithorial" style="display: inline-block;"></label>
                    <label for="agno" class="ml-md-3 mr-md-3">Año de publicación:<br><input id="agno" type="number" name="agno" style="display: inline-block;"></label>
                    <label for="portada" class="ml-md-3 mr-md-3">Portada: <span class="text-info" data-toggle="tooltip" data-placement="top" title="Introduce un enlace a una imagen del libro">&#x1F6C8;</span><br><input id="portada" type="text" name="portada" style="display: inline-block;"></label>
                    <label for="dl" class="ml-md-3 mr-md-3">Depósito legal:<br><input id="dl" type="text" name="dl" style="display: inline-block;"></label>
                    <?php
                        if(isset($_POST["editar"]) || isset($_GET["id"])){
                            //Solo cuando se edita un libro, se puede editar el campo de la base de datos para marcar a quién se le ha prestado un libro
                    ?>
                        <label for="prestado" class="ml-md-3 mr-md-3">Prestado a:<br><input id="prestado" type="text" name="prestado" style="display: inline-block;"></label>
                    <?php } ?>
                </div>
            </div>
            <label id="ocultoDescripcion" for="descripcion" class="ml-md-3 mr-md-3 col-10">Descripcion:<br><textarea id="descripcion" class="form-control border border-dark" name="descripcion" rows="10" style="display: inline-block; color: black;"></textarea></label>
            <?php
                if(isset($_POST["editar"]) || isset($_GET["id"])){
                    //Si se edita un campo, el botón de confirmar es de edición (y oculta el id del campo); en cualquier otro caso es de adición
            ?>
                <input type="hidden" name="id" id="id">
                <label for="editar" class="mt-2"><input id="editar" type="submit" value="Aplicar cambios" name="editar" style="display: inline-block;" class="btn btn-info"></label>
            <?php
                } else{
            ?>
                <label for="add" class="mt-2"><input id="add" type="submit" value="Añadir" name="add" style="display: inline-block;" class="btn btn-primary"></label>
            <?php
                }
            ?>
        </form>
    </div>
    <script>
        <?php
            if(isset($_GET["nombre"]) && $_GET['nombre'] != ''){
                $nombre = $_GET['nombre'];
                echo "document.getElementById('nombre').value='$nombre';";
            }
            if(isset($_GET["lugar"]) && $_GET['lugar'] != ''){
                $lugar = $_GET['lugar'];
                echo "document.getElementById('lugar').value='$lugar';";
            }
            if(isset($_GET["isbn"]) && $_GET['isbn'] != ''){
                $isbn = $_GET['isbn'];
                echo "document.getElementById('isbn').value='$isbn';";
            }
            if($fila){
                //Como se está editando un campo, hay que mostrar los valores de esos campos
                if((isset($fila["id"]) && $fila['id'] != '') || isset($_GET["id"])){
                    //Se recoge el dato del campo de la base de datos
                    $id = intval($fila["id"]);
                    //Si es por redirección, se sobreescribe
                    if(isset($_GET["id"])){
                        $id = intval(depurar($_GET["id"]));
                    }
                    echo "document.getElementById('id').value='$id';";
                }
                if((isset($fila["nombre"]) && $fila['nombre'] != '') || isset($_GET["nombreAmano"])){
                    $nombre = $fila['nombre'];
                    if(isset($_GET["nombreAmano"])){
                        $nombre = depurar($_GET["nombreAmano"]);
                    }
                    echo "document.getElementById('nombreAmano').value='$nombre';";
                }
                if((isset($fila["lugar"]) && $fila['lugar'] != '') || isset($_GET["lugarAmano"])){
                    $lugar = $fila['lugar'];
                    if(isset($_GET["lugarAmano"])){
                        $lugar = depurar($_GET["lugarAmano"]);
                    }
                    echo "document.getElementById('lugarAmano').value='$lugar';";
                }
                if((isset($fila["isbn"]) && $fila['isbn'] != '') || isset($_GET["isbnAmano"])){
                    $isbn = $fila['isbn'];
                    if(isset($_GET["isbnAmano"])){
                        $isbn = depurar($_GET["isbnAmano"]);
                    }
                    echo "document.getElementById('isbnAmano').value='$isbn';";
                }
                if((isset($fila["titulo_original"]) && $fila['titulo_original'] != '') || isset($_GET["titulo_original"])){
                    $titulo_original = $fila['titulo_original'];
                    if(isset($_GET["titulo_original"])){
                        $titulo_original = depurar($_GET["titulo_original"]);
                    }
                    echo "document.getElementById('titulo_original').value='$titulo_original';";
                }
                if((isset($fila["paginas"]) && $fila['paginas'] != '') || isset($_GET["paginas"])){
                    $paginas = intval($fila['paginas']);
                    if(isset($_GET["paginas"])){
                        $paginas = intval(depurar($_GET["paginas"]));
                    }
                    echo "document.getElementById('pag').value='$paginas';";
                }
                if((isset($fila["autor"]) && $fila['autor'] != '') || isset($_GET["autor"])){
                    $author = $fila['autor'];
                    if(isset($_GET["autor"])){
                        $author = depurar($_GET["autor"]);
                    }
                    echo "document.getElementById('author').value='$author';";
                }
                if((isset($fila["editorial"]) && $fila['editorial'] != '') || isset($_GET["editorial"])){
                    $edithorial = $fila['editorial'];
                    if(isset($_GET["editorial"])){
                        $edithorial = depurar($_GET["editorial"]);
                    }
                    echo "document.getElementById('edithorial').value='$edithorial';";
                }
                if((isset($fila["agno"]) && $fila['agno'] != '') || isset($_GET["agno"])){
                    $agno = intval($fila['agno']);
                    if(isset($_GET["agno"])){
                        $agno = intval(depurar($_GET["agno"]));
                    }
                    echo "document.getElementById('agno').value='$agno';";
                }
                if((isset($fila["portada"]) && $fila['portada'] != '') || isset($_GET["portada"])){
                    $portada = $fila['portada'];
                    if(isset($_GET["portada"])){
                        $portada = depurar($_GET["portada"]);
                    }
                    echo "document.getElementById('portada').value='$portada';";
                }
                if((isset($fila["descripcion"]) && $fila['descripcion'] != '') || isset($_GET["descripcion"])){
                    $descripcion = $fila['descripcion'];
                    if(isset($_GET["descripcion"])){
                        $descripcion = depurar($_GET["descripcion"]);
                    }
                    echo "document.getElementById('descripcion').value='$descripcion';";
                }
                if((isset($fila["deposito_legal"]) && $fila['deposito_legal'] != '') || isset($_GET["deposito_legal"])){
                    $deposito_legal = $fila['deposito_legal'];
                    if(isset($_GET["deposito_legal"])){
                        $deposito_legal = depurar($_GET["deposito_legal"]);
                    }
                    echo "document.getElementById('dl').value='$deposito_legal';";
                }
                if((isset($fila["prestado"]) && $fila['prestado'] != '') || isset($_GET["prestado"])){
                    $prestado = $fila['prestado'];
                    if(isset($_GET["prestado"])){
                        $prestado = depurar($_GET["prestado"]);
                    }
                    echo "document.getElementById('prestado').value='$prestado';";
                }
            }
            if(!isset($_POST["editar"]) && !isset($_GET["id"])){
                //Cuando se añade un libro, ocultar y desactivar campos por defecto de edición a mano
        ?>
        document.getElementById("oculto").style = "display: none!important;";
        document.getElementById("ocultoDescripcion").style = "display: none!important;";
        document.getElementById("nombreAmano").disabled = true;
        document.getElementById("lugarAmano").disabled = true;
        document.getElementById("pag").disabled = true;
        document.getElementById("author").disabled = true;
        <?php
            if(isset($_GET["mostrar"])){
                //Cuando se añade un libro a mano y se redirecciona por error, se muestran los campos de edición a mano y se desactivan los de la API
                echo "document.getElementById('aMano').checked = true;";
                echo 'document.getElementById("oculto").style = "";';
                echo 'document.getElementById("ocultoDescripcion").style = "";';
                echo 'document.getElementById("nombre").disabled = true;';
                echo 'document.getElementById("campoNombre").classList.add("text-muted");';
                echo 'document.getElementById("lugar").disabled = true;';
                echo 'document.getElementById("campoLugar").classList.add("text-muted");';
                echo 'document.getElementById("isbn").disabled = true;';
                echo 'document.getElementById("campoISBN").classList.add("text-muted");';
                echo 'document.getElementById("nombreAmano").disabled = false;';
                echo 'document.getElementById("lugarAmano").disabled = false;';
                echo 'document.getElementById("pag").disabled = false;';
                echo 'document.getElementById("author").disabled = false;';
            }
        ?>
        $(document).ready(function() {
            //Añadir la función que muestra u oculta campos al checkbox de edición a mano
            document.getElementById("aMano").addEventListener("click", function(){
                if(document.getElementById("aMano").checked){
                    document.getElementById("oculto").style = "";
                    document.getElementById("ocultoDescripcion").style = "";
                    document.getElementById("nombre").disabled = true;
                    document.getElementById("campoNombre").classList.add("text-muted");
                    document.getElementById("lugar").disabled = true;
                    document.getElementById("campoLugar").classList.add("text-muted");
                    document.getElementById("isbn").disabled = true;
                    document.getElementById("campoISBN").classList.add("text-muted");
                    document.getElementById("nombreAmano").disabled = false;
                    document.getElementById("lugarAmano").disabled = false;
                    document.getElementById("pag").disabled = false;
                    document.getElementById("author").disabled = false;
                }
                else{
                    document.getElementById("oculto").style = "display: none!important;";
                    document.getElementById("ocultoDescripcion").style = "display: none!important;";
                    document.getElementById("nombre").disabled = false;
                    document.getElementById("campoNombre").classList.remove("text-muted");
                    document.getElementById("lugar").disabled = false;
                    document.getElementById("campoLugar").classList.remove("text-muted");
                    document.getElementById("isbn").disabled = false;
                    document.getElementById("campoISBN").classList.remove("text-muted");
                    document.getElementById("nombreAmano").disabled = true;
                    document.getElementById("lugarAmano").disabled = true;
                    document.getElementById("pag").disabled = true;
                    document.getElementById("author").disabled = true;
                }
            });
        });
        <?php } ?>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>
</html>