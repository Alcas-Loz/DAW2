<html>
<link rel="stylesheet" href="estilos.css">

<body>
    <div id="formU">
        <form action="insertarContactoRepint.php" method="post">
            <?php
            $nombreContact = $_POST["nomCont"];
            $telCont = $_POST["telCont"];
            $profCont=$_POST["prof"];
            $fechaNac=$_POST["fechaNac"];
            $foto=$_POST["imagen"];
            echo "Nombre contacto: <input type='text' name='nombreCont'>";
            if (empty($nombreContact)) {
                echo "El nombre es obligatorio";
            }
            echo "<br><br>";
            echo "Teléfono: <input type='tel' name='telCont'>";
            if (strlen($telCont) <= 8 || strlen($telCont) >= 10) {
                echo "El numero de telefono debe tener una longitud de 9 numeros";
            } else {
                echo "Telefono bien puesta";
            }
            echo "<br><br>";
            echo "Fecha de nacimiento: <input type='date' name='fechaNac'>";
            echo "<br><br>";
            echo "Fotografía: <input type='file' name='imagen'>";
            echo "<br><br>";
            echo "Profesion: <select name='prof'>";
            $ficheroProfs = fopen("fprofesiones.txt", "r");
            if (!$ficheroProfs) {
                die("Error: no se ha podido abrir el fichero de datos");
            }
            while (!feof($ficheroProfs)) {
                echo "<option>";
                echo fgets($ficheroProfs) . "</option>";
                echo "<br><br>";
            }
            fclose($ficheroProfs);
            echo "</select>";
            echo "<br><br>";
            $fichero = fopen("fagenda.txt", "a+");
            if (!$fichero) {
                die("Error: No se puede leer el fichero");
            }
            fwrite($fichero, "\n".$nombreContact . "," . $telCont . "," . $foto . "," . $profCont . "," . $fechaNac);
            fclose($fichero);
            echo "<input type='submit' name='enviar' value='Registrar Contacto'>";
            echo "<input type='reset' value='Reiniciar'>";
            echo "<a href='menu.php'>Volver al menu</a>";
            ?>
        </form>
    </div>
</body>

</html>