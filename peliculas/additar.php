        <?php
            include "../depurar.php";
            include "../cabecera/cabeceraListas.php";
            //Comprobar si se está editando un libro, y recogerlo de la base de datos
            $fila = true;
            if(isset($_POST["editar"])){
                $id = intval(depurar($_POST["id_edicion"]));
                try{
                    $fila = $conectar->query("SELECT * FROM `peliculas` WHERE `id`=$id")->fetch();
                }
                catch(PDOException $error){
                    $fila = false;
                }
            }
            //Desconectarse de la base
            $conectar = null;
            //Si no se encuentra la película se lanza un error de conexión
            if(!$fila){
                echo "<div class='container text-center h3 font-weight-bold bg-light p-3 mb-3 rounded'><span class='text-danger'>No</span> se han podido recoger los datos. Intentalo <span class='text-success'>otra vez</span></div>";
            }
            //Cuando se redirecciona por falta de datos, datos no válidos o hay problemas de conexión, muestra un mensaje de error
            if(isset($_GET["error"]) && $_GET["error"] == "error"){
            ?>
                <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                    <div class="bg-warning p-3 rounded">
                        <b>&#9888; Error &#9888;</b><br>
                        La película/serie no se ha podido 
                        <?php
                            if(isset($_GET["id"])){
                                echo "editar correctamente";
                            }
                            else{
                                echo "añadir a la base de datos";
                            }
                        ?> 
                    </div>
                </div>
            <?php } ?>
        <form action="/peliculas/peliculas.php" method="post" class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
            <div class="d-flex align-items-center text-center flex-column">
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center">
                    <label for="nombre" class="ml-2 mr-2">Nombre de la película/serie:<br><input required id="nombre" type="text" name="nombre" style="display: inline-block;"></label>
                    <label for="lugar" class="ml-2 mr-2">Lugar:<br><input required id="lugar" type="text" name="lugar" style="display: inline-block;"></label>
                    <label for="imdb" class="ml-2 mr-2">Código/enlace IMDB de la película/serie:<br><input required id="imdb" type="text" name="imdb" style="display: inline-block;"></label>
                </div>
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
            </div>
        </form>
    </div>
    <script>
        let generos = "";
        <?php
            if($fila){
                //Como se está editando un campo, hay que mostrar los valores de esos campos
                if((isset($fila["id"]) && $fila['id'] != '') || isset($_GET["id"])){
                    //Se recoge el dato del campo de la base de datos
                    $id = intval($fila["id"]);
                    //Si es por redirección, se sobreescribe
                    if(isset($_GET["id"])){
                        $id = $_GET["id"];
                    }
                    echo "document.getElementById('id').value='$id';";
                }
                if((isset($fila["nombre"]) && $fila['nombre'] != '') || (isset($_GET["nombre"]))){
                    $nombre = $fila['nombre'];
                    if(isset($_GET["nombre"])){
                        $nombre = $_GET["nombre"];
                    }
                    echo "document.getElementById('nombre').value='$nombre';";
                }
                if((isset($fila["lugar"]) && $fila['lugar'] != '') || (isset($_GET["lugar"]))){
                    $lugar = $fila['lugar'];
                    if(isset($_GET["lugar"])){
                        $lugar = $_GET["lugar"];
                    }
                    echo "document.getElementById('lugar').value='$lugar';";
                }
                if((isset($fila["imdb"]) && $fila['imdb'] != '') || (isset($_GET["imdb"]))){
                    $imdb = $fila['imdb'];
                    if(isset($_GET["imdb"])){
                        $imdb = $_GET["imdb"];
                    }
                    echo "document.getElementById('imdb').value='$imdb';";
                }
            }
        ?>
    </script>
</body>
</html>