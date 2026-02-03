<html>
<link rel="stylesheet" href="estilos.css">
<body>
    <h1>Lista Contactos</h1>
    <?php
    $fichero = fopen("fagenda.txt", "r+");
    if (!$fichero) {
        die("Error: No se puede leer el fichero");
    }
    echo "<table id='tabla' border='1px solid black'>";
    echo "<tr>";
    echo "<td>Nombre Contacto</td>";
    echo "<td>Teléfono</td>";
    echo "<td>Nombre Fotografía</td>";
    echo "<td>Profesión</td>";
    echo "<td>Fecha de Nacimiento</td>";
    echo "</tr>";
    while (!feof($fichero)) {
        echo "<tr>";
        $line = fgets($fichero);
        $partes = explode(",", $line);
        foreach ($partes as $actual) {
            echo "<td>$actual</td>";
        }
        echo "</tr>";
    }
    fclose($fichero);
    echo "</table>";
    ?>
    <a href='menu.php'>Volver al menu</a>
</body>

</html>