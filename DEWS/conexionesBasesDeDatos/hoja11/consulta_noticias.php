<html>
<link rel="stylesheet" href="estilos.css">
<body>
    <h1>Consulta de noticias</h1>
    <?php
    $con = new mysqli("localhost", "web", "1234");
    $con->select_db("inmobiliaria");
    $strsql = "SELECT titulo,texto,categoria,fecha,imagen FROM noticias";
    echo "<table border='1px solid black'>";
    echo "<tr>";
    echo "<th>Titulo</th>";
    echo "<th>Texto</th>";
    echo "<th>Categoría</th>";
    echo "<th>Fecha</th>";
    echo "<th>Imagen</th>";
    echo "</tr>";
    if ($resu = $con->query($strsql)) {
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
    echo "</table>";
    ?>
    <a href="menuNoticias.html">Menu</a>
</body>

</html>