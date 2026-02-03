<html>
    <link rel="stylesheet" href="sanciona.css">
    <body>
        <div id="formU">
            <form action="insertarSancion.php" method="post">
                Alumno apercibido: <select name="alumno">
                    <?php
                        $ficheroDeAlumnos=fopen("Alumnos.txt","r");
                        if(!$ficheroDeAlumnos){
                        die("Error: no se ha podido abrir el fichero de datos");
                        }
                        while (!feof($ficheroDeAlumnos)) {
                            echo "<option>";
                            echo fgets($ficheroDeAlumnos)."</option>";
                        }
                        fclose($ficheroDeAlumnos);
                    ?>
                </select><br><br>
                Tipo de falta: <input type="radio" name="falta" value="leve">Leve
                <input type="radio" name="falta" value="grave">Grave
                <input type="radio" name="falta" value="muy grave">Muy Grave<br><br>
                Sancion: <input type="text"><br><br>
                <input type="submit" value="Registrar sancion">
                <input type="reset" value="Reiniciar">
            </form>
        </div>
    </body>
</html>