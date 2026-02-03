<html>
<link rel="stylesheet" href="estilos.css">

<body>
    <div id="formU">
        <form action="insertarContactoRepint.php" method="post">
            Nombre contacto: <input type='text' name='nomCont'>
            <br><br>
            Teléfono: <input type='tel' name='telCont'>
            <br><br>
            Fecha de nacimiento: <input type='date' name='fechaNac'>
            <br><br>
            Fotografía: <input type='file' name='imagen'>
            <br><br>
            Profesion: <select name='prof'>
                <?php
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
                ?>
            </select>
            <br><br>
            <input type='submit' name='enviar' value='Registrar Contacto'>
            <input type='reset' value='Reiniciar'>
            <a href='menu.php'>Volver al menu</a>
        </form>
    </div>
</body>

</html>