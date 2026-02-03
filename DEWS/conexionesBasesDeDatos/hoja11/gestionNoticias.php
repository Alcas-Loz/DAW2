<html>
    <body>
    <?php
    $errorTitulo="";
    $errorTexto="";
    if(isset($_POST["datos"])){
        $titulo=$_POST["tit"];
        $texto=$_POST["texto"];
        if(empty($titulo)||empty($texto)){
            if(empty($titulo)) $errorTitulo="No hay titulo";
            if(empty($texto)) $errorTexto="No hay texto";
        }
        if(!empty($titulo)&&!empty($texto)){
            $con=mysqli_connect("localhost","web","1234","inmobiliaria");
            if (mysqli_connect_errno()) {
                printf("Conexión fallida:%s\n",mysqli_connect_error());
                exit();
            }
            $cat=$_POST["cat"] ?? "";
            $nombre_imagen = "";
            if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
                $nombre_imagen = $_FILES["imagen"]["name"];
                $carpeta_destino = "imagenes/"; 
                $ruta_final = $carpeta_destino . basename($nombre_imagen);
                if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_final)) {
                    echo "Error al subir la imagen al servidor.";
                    exit();
                }
            }
            $query=$con->prepare("INSERT into noticias(Titulo,Texto,Categoria,Fecha,Imagen) values(?,?,?,CURDATE(),?)");
            $query->bind_param("ssss",$titulo,$texto,$cat,$nombre_imagen);
            if($query->execute()) {
                echo "<h1>Gestión de noticias</h1>";
                echo "<i>Resultado de la inserción de la nueva noticia</i><br><br>";
                echo "La noticia ha sido recibida correctamente: ";
                echo "<ul>";
                echo "<li>Titulo: $titulo</li>";
                echo "<li>Texto: $texto</li>";
                echo "<li>Categoria: $cat</li>";
                echo "<li>Fecha: </li>";
                echo "<li>Imagen: $nombre_imagen</li>";
                echo "</ul>";
                echo "<a href='inserta_noticia.php'>[Insertar otra noticia]</a><br><br>";
                echo "<a href='menuNoticias.html'>Menu</a>";
            }else {
                echo "Error en la inserción: " . $query->error;
            }
            $query->close();
            $con->close();
        }
    }
    ?>
    </body>
</html>