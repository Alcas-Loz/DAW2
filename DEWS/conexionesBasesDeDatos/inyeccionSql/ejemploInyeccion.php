<html>

<body>
    <form action="ejemploInyeccion.php" method="post">
        Usuario <input type="text" id="user">
        Contraseña <input type="text" id="contra">
        <input type="submit" value="Enviar">
    </form>
    <?php
    $user = $_POST["user"];
    $contra = $_POST["contra"];
    $con = new mysqli("localhost", "web", "1234");
    $con->select_db("inmobiliaria");
    $strsql = "SELECT * FROM usuarios";
    if ($resu = $con->query($strsql)) {
        while ($fila = $resu->fetch_row()) {
            foreach ($fila as $valor) {
                echo $valor . " ";
            }
            echo "<br>";
        }
        $resu->close();
        $con->close();
    } else {
        echo "No";
    }
    ?>

</body>

</html>