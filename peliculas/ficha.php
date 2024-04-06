<?php
                include "../depurar.php";
                include "../cabecera/cabeceraListas.php";
                //Recoger la ficha de una película de la base de datos
                $fichaQuery = "SELECT `nombre`,`duracion`,`lugar`,`director`,`actor_principal`,`genero`,`agno`,`poster`,`argumento`, `imdb` FROM peliculas WHERE id=".intval(depurar($_GET['id']));
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
                    <img src="<?php echo $ficha["poster"];?>" alt="Poster de <?php echo $ficha["nombre"];?>">
                    <div class="h4 p-2 mb-2 mt-2 ml-5 mr-5 rounded text-center" style="background-color: #777788;">
                        <a href="/peliculas/peliculas.php" class="text-white">Volver a la Lista</a>
                    </div>
                </div>
                <div class="col-md-7 mr-2 ml-2 flex-shrink-2">
                    <p class="text-white h2 font-weight-bold"><?php echo $ficha["nombre"];?></p>
                    <p><?php
                        // Recoger el título original de la película de la API de OMDb
                        $url = file_get_contents("http://www.omdbapi.com/?i=tt".$ficha["imdb"]."&apikey=INTRODUCIR_API_KEY");
                        $json = json_decode($url, true);
                        if($json["Response"] != "False"){?>
                            <i class="h3">( <b class="text-white"><?php echo $json["Title"];?></b> )</i>
                        <?php } else{?>
                            <p class="h3 text-white">( Título original no disponible )</p>
                        <?php }?>
                    </p>
                    <p class="h4 text-white"> Año: <?php echo $ficha["agno"];?> - Duración: 
                        <?php 
                            echo intdiv(intval($ficha["duracion"]),60)."h ".(intval($ficha["duracion"]) % 60)."min";
                        ?>
                    </p>
                    <p class="text-white">Directorio: <?php echo $ficha["lugar"];?></p>
                    <br>
                    <p class="text-white">Genero: <?php echo $ficha["genero"];?></p>
                    <br>
                    <p class="text-white">Director: <?php echo $ficha["director"];?></p>
                    <p class="text-white">Reparto: <?php echo $ficha["actor_principal"];?></p>
                    <p class="text-white"><?php echo $ficha["argumento"];?></p>
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