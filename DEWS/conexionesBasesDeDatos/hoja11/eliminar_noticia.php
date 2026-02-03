<html>
<link rel="stylesheet" href="estilos.css">
    <body>
        <h1>Eliminar noticia</h1>
        <form action="eliminar_noticia.php" method="post">
            Id noticia a eliminar <input type="text" name="notElim"><br><br>
            <input type="submit" value="Eliminar">
        </form>
        <?php
        $con=mysqli_connect("localhost","web","1234","inmobiliaria");
        if (mysqli_connect_errno()) {
            printf("Conexión fallida:%s\n",mysqli_connect_error());
            exit();
        }
        $id=$_POST["notElim"];
        $query = $con->prepare("DELETE FROM noticias where Id=?");
        $query->bind_param("s",$id);
        if($query->execute()){
            echo "Noticia eliminada";
        }
        echo "<br><br><a href='menuNoticias.html'>Menu</a>";
        $query->close();
        $con->close();
        ?>
        <?php
        $con=mysqli_connect("localhost","web","1234","inmobiliaria");
        if (mysqli_connect_errno()) {
            printf("Conexión fallida:%s\n",mysqli_connect_error());
            exit();
        }
        $query = "SELECT * FROM noticias";
        echo "<table border='1px solid black'>";
        echo "<tr>";
        echo "<th>Id</th>";
        echo "<th>Titulo</th>";
        echo "<th>Texto</th>";
        echo "<th>Categoría</th>";
        echo "<th>Fecha</th>";
        echo "<th>Imagen</th>";
        echo "</tr>";
        if ($resu = $con->query($query)) {
            while ($fila = $resu->fetch_row()) {
                echo "<tr>";
                foreach ($fila as $valor) {
                    echo "<td>";
                    echo $valor . " ";
                    echo "</td>";
                }
                echo "</tr>";
                echo "<br>";
            }
            $resu->close();
            $con->close();
        }
        echo "</table>"
        ?>
    </body>
</html>