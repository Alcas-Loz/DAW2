<html>
<head>
    <title>Consulta de Noticias por Categoría</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Consulta de noticias por Categoría</h1>
    
    <?php
    $con = new mysqli("localhost", "web", "1234", "inmobiliaria");
    if ($con->connect_error) {
        die("Error de conexión: " . $con->connect_error);
    }
    $categoriaSeleccionada = isset($_POST['categoria']) ? $_POST['categoria'] : 'Todas';
    ?>

    <form action="consulta_noticias3.php" method="POST">
        <label for="categoria">Filtrar por categoría:</label>
        <select name="categoria" id="categoria">
            <option value="Todas" <?php if($categoriaSeleccionada == 'Todas') echo 'selected'; ?>>Todas</option>
            <?php
            $sqlCategorias = "SELECT DISTINCT categoria FROM noticias";
            $resCat = $con->query($sqlCategorias);
            
            while ($filaCat = $resCat->fetch_assoc()) {
                $nombreCat = $filaCat['categoria'];
                $selected = ($nombreCat == $categoriaSeleccionada) ? "selected" : "";
                echo "<option value='$nombreCat' $selected>$nombreCat</option>";
            }
            ?>
        </select>
        <input type="submit" value="Buscar">
    </form>
    <hr>
    <?php
    $strsql = "SELECT titulo, texto, categoria, fecha, imagen FROM noticias";
    if ($categoriaSeleccionada != 'Todas') {
        $catSegura = $con->real_escape_string($categoriaSeleccionada);
        $strsql .= " WHERE categoria = '$catSegura'";
    }
    echo "<table border='1px solid black'>";
    echo "<tr>";
    echo "<th>Titulo</th>";
    echo "<th>Texto</th>";
    echo "<th>Categoría</th>";
    echo "<th>Fecha</th>";
    echo "<th>Imagen</th>";
    echo "</tr>";
    if ($resu = $con->query($strsql)) {
        if ($resu->num_rows > 0) {
            while ($fila = $resu->fetch_row()) {
                echo "<tr>";
                foreach ($fila as $valor) {
                    echo "<td>" . $valor . "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay noticias en esta categoría.</td></tr>";
        }
        $resu->close();
    }
    echo "</table>";
    $con->close();
    ?>
    <br>
    <a href="menuNoticias.html">Menu</a>
</body>
</html>