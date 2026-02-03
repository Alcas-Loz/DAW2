<html>
    <link rel="stylesheet" href="estilos.css">
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
            $query->execute();
            $query->close();
            $con->close();
        }
    }
    ?>
    <body>
        <h1>Insercion de una noticia</h1>
        <form action="gestionNoticias.php" method="post" enctype="multipart/form-data">
            Titulo:* <input type='text' value="<?php echo $titulo?>"name='tit'/>
            <span><?php echo $errorTitulo?></span><br><br>
            Texto:* <input type='text' value="<?php echo $texto?>"name='texto'>
            <span><?php echo $errorTexto?></span><br><br>
            Categoria: <select name='cat'>
            <option value='ofertas'>Ofertas</option>
            <option value='promociones'>Promociones</option>
            <option value='costas'>Costas</option>
            </select><br><br>
            Imagen <input type='file' name='imagen'><br><br>
            <input type='submit' name="datos" value='Insertar Noticia'>
            <input type="reset" value="Reiniciar Datos">
        </form>
        <a href="menuNoticias.html">Menu</a>
    </body>
</html>