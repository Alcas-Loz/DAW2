<html>
<link rel="stylesheet" href="estilos.css">
<body>
    <h1>Consulta de noticias</h1>
    <?php
    $con = new mysqli("localhost", "web", "1234");
    $con->select_db("inmobiliaria");
    $registrosPorPagina = 3;
    if (isset($_GET['pagina'])) {
        $paginaActual = (int)$_GET['pagina'];
    } else {
        $paginaActual = 1;
    }
    $inicio = ($paginaActual - 1) * $registrosPorPagina;
    $sqlTotal = "SELECT count(*) FROM noticias";
    $resultTotal = $con->query($sqlTotal);
    $filaTotal = $resultTotal->fetch_row();
    $totalRegistros = $filaTotal[0];
    $totalPaginas = ceil($totalRegistros/$registrosPorPagina);
    $strsql = "SELECT titulo,texto,categoria,fecha,imagen FROM noticias LIMIT $inicio, $registrosPorPagina";
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
        }
        $resu->close();
    }
    echo "</table>";
    echo "<div style='margin-top: 20px;'>";
    echo "Páginas: ";
    if ($paginaActual > 1) {
        echo "<a href='?pagina=".($paginaActual-1)."'>&laquo; Anterior</a> ";
    }
    for ($i = 1; $i <= $totalPaginas; $i++) {
        if ($i == $paginaActual) {
            echo "<strong>$i</strong> ";
        } else {
            echo "<a href='?pagina=$i'>$i</a> ";
        }
    }
    if ($paginaActual < $totalPaginas) {
        echo "<a href='?pagina=".($paginaActual+1)."'>Siguiente &raquo;</a> ";
    }
    echo "</div>";
    $con->close();
    ?>
    <br>
    <a href="menuNoticias.html">Menu</a>
</body>
</html>