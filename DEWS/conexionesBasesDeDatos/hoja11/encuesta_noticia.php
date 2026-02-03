<html>
<body>
    <h1>Encuesta</h1>
    <?php
    if (isset($_POST["datos"])) {
        if (isset($_POST["voto"])) {
            $con = new mysqli("localhost", "web", "1234", "inmobiliaria");
            if ($con->connect_error) {
                die("Conexión fallida: " . $con->connect_error);
            }
            $voto = $_POST["voto"];
            $sql = "";
            if ($voto=="si") {
                $sql = "UPDATE votos SET votos1=votos1+1";
            } else {
                $sql = "UPDATE votos SET votos2=votos2+1";
            }
            if ($con->query($sql)) {
                echo "<p >¡Gracias por su participación! Su voto ha sido registrado.</p>";
            } else {
                echo "<p>Error al registrar el voto: " . $con->error . "</p>";
            }
            $con->close();
        } else {
            echo "<p>Por favor, seleccione una opción antes de votar.</p>";
        }
    }
    ?>
    <p>¿Cree ud. que el precio de la vivienda seguirá subiendo al ritmo actual?</p>
    <form action="" method="POST">
        <input type="radio" name="voto" value="si" id="si">
        <label for="si">Sí</label> <br>
        <input type="radio" name="voto" value="no" id="no">
        <label for="no">No</label> <br><br>
        <input type="submit" name="datos" value="Votar">
    </form>
    <br>
    <a href="encuesta_resultados.php">Ver resultados</a><br><br>
    <a href="menuNoticias.html">Menu</a>
</body>
</html>