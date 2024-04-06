<?php
                include "../depurar.php";
                include "../cabecera/cabeceraListas.php";
                //Recoger la ficha de un libro de la base de datos
                $fichaQuery = "SELECT `nombre`,`paginas`,`autor`,`editorial`,`lugar`,`descripcion`,`titulo_original`,`portada`,`agno` FROM libros WHERE id=".intval(depurar($_GET['id']));
                try{
                    $ficha = $conectar->query($fichaQuery)->fetch();
                }
                catch(PDOException $error){
                    $ficha = false;
                }
            ?>
        <?php if(!$ficha){//Si no existe la ficha, se muestra un error. Si existe, se muestra la ficha?>
            <div class="text-center mt-3">
                <p class="h1 font-weight-bold text-white">FICHA <span class="text-danger">NO</span> ENCONTRADA</p>
                <p class="h3 text-white">Se ha producido un <span class="text-danger">error</span> buscando la ficha</p>
            </div>
        <?php }else{?>
            <div class="row">
                <div class="col-md-4 mr-2 ml-2">
                    <?php if($ficha["portada"] != NULL){ //Ver si existe una portada para el libro, y mostrar en caso de existir?>
                        <img src="<?php echo $ficha["portada"];?>" alt="Portada de <?php echo $ficha["nombre"];?>">
                    <?php }else{
                        echo "<p class='h1 font-weight-bold text-center text-white mt-5 mb-5 pt-5 pb-5'>Sin<br>portada</p>";
                    }?>
                    <div class="h4 p-2 mb-2 mt-2 ml-5 mr-5 rounded text-center" style="background-color: #777788;">
                        <a href="/libros/libros.php" class="text-white">Volver a la Lista</a>
                    </div>
                </div>
                <div class="col-md-7 mr-2 ml-2 flex-shrink-2">
                    <p class="text-white h2 font-weight-bold"><?php echo $ficha["nombre"];?></p>
                    <p><?php
                        if($ficha["titulo_original"] != NULL){?>
                            <i class="h3">( <b class="text-white"><?php echo $ficha["titulo_original"];?></b> )</i>
                        <?php } else{?>
                            <p class="h3 text-white">( Título original no disponible )</p>
                        <?php }?>
                    </p>
                    <p class="h4 text-white"> Año: 
                        <?php if($ficha["agno"] != NULL){
                            echo $ficha["agno"];
                        } else {
                            echo "---";
                        }?>
                        / Nº de páginas: 
                        <?php if($ficha["paginas"] != NULL){
                            echo $ficha["paginas"];
                        } else {
                            echo "---";
                        }?>
                    </p>
                    <br>
                    <p class="text-white">Editorial: 
                        <?php if($ficha["editorial"] != NULL){
                            echo $ficha["editorial"];
                        } else {
                            echo "---";
                        }?>
                    </p>
                    <p class="text-white">Autor/es: 
                        <?php if($ficha["autor"] != NULL){
                            echo $ficha["autor"];
                        } else {
                            echo "---";
                        }?>
                    </p>
                    <p class="text-white"><?php echo $ficha["descripcion"];?></p>
                </div>
            </div>
            <?php
                $conectar=null;
            ?>
            <script>
                $(document).ready(function() {
                    //Sobreescribir el estilo de la etiqueta en cursiva de Bootstrap para mostrar el texto en blanco
                    let cursivas = document.getElementsByTagName("i");
                    for (let i = 0; i < cursivas.length; i++) {
                        let etiquetaI = cursivas[i];
                        etiquetaI.classList.add("text-white");
                        if(i != 0){//La primera cursiva que encuentra siempre es el título original del libro, por lo que se le pone en negrita
                            etiquetaI.classList.add("font-weight-bold");
                            etiquetaI.innerHTML = " " + etiquetaI.innerHTML + "<br>";
                        }
                    }
                });
            </script>
        </div>
    </body>
</html>
            <?php }?>