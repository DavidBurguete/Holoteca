        <?php
            include "../depurar.php";
            include "../cabecera/cabeceraListas.php";
            //Comprobar si se está editando un juego, y recogerlo de la base de datos
            $fila = true;
            if(isset($_POST["editar"])){
                $id = intval(depurar($_POST["id_edicion"]));
                try{
                    $fila = $conectar->query("SELECT * FROM `juegos` WHERE `id`=$id")->fetch();
                }
                catch(PDOException $error){
                    $fila = false;
                }
            }
            //Desconectarse de la base
            $conectar=null;
            //Si no se encuentra el juego se lanza un error de conexión
            if(!$fila){
                echo "<div class='container text-center h3 font-weight-bold bg-light p-3 mb-3 rounded'><span class='text-danger'>No</span> se han podido recoger los datos. Intentalo <span class='text-success'>otra vez</span></div>";
            }
            //Cuando se redirecciona por falta de datos, datos no válidos  o hay problemas de conexión, muestra un mensaje de error
            if(isset($_GET["error"]) && $_GET["error"] == "error"){
            ?>
                <div class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
                    <div class="bg-warning p-3 rounded">
                        <b>&#9888; Error &#9888;</b><br>
                        El juego no se ha podido 
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
            <?php }?>
        <form action="/juegos/juegos.php" method="post" class="bg-light mt-3 mb-3 p-3 rounded d-flex align-items-center text-center flex-column">
            <div class="d-flex align-items-center text-center flex-column">
                <div class="d-flex align-items-center text-center flex-row flex-wrap justify-content-center">
                    <label for="nombre" class="mr-md-3 ml-md-3 ml-lg-0">Nombre del juego:<br><input required id="nombre" type="text" name="nombre" style="display: inline-block;"></label>
                    <label for="durac" class="mr-md-3 ml-md-3">Duración de partida:<br><input id="durac" type="number" name="durac" style="display: inline-block;"></label>
                    <label for="minimo" class="ml-md-3 mr-md-3 mr-lg-0">Mínimo de jugadores:<br><input required id="minimo" type="number" name="minimo" style="display: inline-block;"></label>
                    <label for="maximo" class="mr-md-3 ml-md-3 ml-lg-0">Máximo de jugadores:<br><input id="maximo" type="number" name="maximo" style="display: inline-block;"></label>
                    <label for="lugar" class="ml-md-3 mr-md-3 mr-lg-0">Lugar de guardado:<br><input required id="lugar" type="text" name="lugar" style="display: inline-block;"></label>
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
        <?php
            if($fila){
                //Como se está editando un campo, hay que mostrar los valores de esos campos
                if((isset($fila["id"]) && $fila['id'] != '') || isset($_GET["id"])){
                    //Se recoge el dato del campo de la base de datos
                    $id = $fila["id"];
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
                if((isset($fila["duracion"]) && $fila['duracion'] != '') || (isset($_GET["duracion"]))){
                    $duracion = intval($fila['duracion']);
                    if(isset($_GET["duracion"])){
                        $duracion = intval($_GET["duracion"]);
                    }
                    echo "document.getElementById('durac').value='$duracion';";
                }
                if((isset($fila["min_jug"]) && $fila['min_jug'] != '') || (isset($_GET["min_jug"]))){
                    $minimo = intval($fila['min_jug']);
                    if(isset($_GET["min_jug"])){
                        $minimo = intval($_GET["min_jug"]);
                    }
                    echo "document.getElementById('minimo').value='$minimo';";
                }
                if((isset($fila["max_jug"]) && $fila['max_jug'] != '') || (isset($_GET["max_jug"]))){
                    $maximo = intval($fila['max_jug']);
                    if(isset($_GET["max_jug"])){
                        $maximo = intval($_GET["max_jug"]);
                    }
                    echo "document.getElementById('maximo').value='$maximo';";
                }
                if((isset($fila["lugar"]) && $fila['lugar'] != '') || (isset($_GET["lugar"]))){
                    $lugar = $fila['lugar'];
                    if(isset($_GET["lugar"])){
                        $lugar = $_GET["lugar"];
                    }
                    echo "document.getElementById('lugar').value='$lugar';";
                }
            }
        ?>
    </script>
</body>
</html>