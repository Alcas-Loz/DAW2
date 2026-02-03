<html>
<link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <body>
        <h1 class="text-center">ENVIO DE POSTALES</h1>
        <br><br>
            <?php
            if(!isset($_POST['tema']))
            {
                echo "<form class='text-center' action='enviarPostal.php' method='post'>";
                    echo "<label for='tema'>Tema:</label>";
                    echo "<select name='tema' id='tema'>";
                    if(is_dir('temas')){
                        $dir = opendir('temas');
                        while (($archivo = readdir($dir)) !== false){
                            if ($archivo != '.' && $archivo != '..'){
                                echo "<option value='$archivo'>$archivo</option>";
                            }
                        }
                        closedir($dir);
                    }
                    echo "</select><br><br><br>";
                    echo "<input type='submit' value='Elegir tema'>";
                echo "</form>";
            }
            else
            {
                $tema=$_POST['tema'];
                echo "<form class='text-center' action='funciones.php' method='post'>";
                    echo "<input type='hidden' name='tema' value='$tema'>";
                    echo "<label for='correo'>Destinatario:</label>";

                    echo "<select name='correo' id='correo' multiple required>";
                    
                    echo "</select><br><br>";
                    echo "<label for='asunto'>Asunto:</label>";
                    echo "<input type='text' id='asunto' name='asunto' required><br><br>";
                    echo "<label for='mensaje'>Mensaje:</label>";
                    echo "<input type='text' id='mensaje' name='mensaje'><br><br>";
                    echo "<input type='submit' value='Enviar postal'>";
                    echo "<br><br>Vista previa de la postal seleccionada:";
                if($tema=="Verano")
                {
                    echo "<br>
                    <input type='radio' name='tema' value='verano'>
                    <img src='imgs/verano.png' alt='Postal de Verano' width='300' height='200'>
                    <input type='radio' name='tema' value='verano'>
                    <img src='imgs/verano2.png' alt='Postal de Verano' width='300' height='200'>
                    <input type='radio' name='tema' value='verano'>
                    <img src='imgs/verano3.png' alt='Postal de Verano' width='300' height='200'>";
                }
                if($tema=="Invierno")
                {
                    echo "<br>
                    <input type='radio' name='tema' value='invierno'>
                    <img src='imgs/invierno.png' alt='Postal de Invierno' width='300' height='200'>
                    <input type='radio' name='tema' value='invierno'>
                    <img src='imgs/invierno2.png' alt='Postal de Invierno' width='300' height='200'>
                    <input type='radio' name='tema' value='invierno'>
                    <img src='imgs/invierno3.png' alt='Postal de Invierno' width='300' height='200'>";
                }
                if($tema=="Otoño")
                {
                    echo "<br>
                    <input type='radio' name='tema' value='otono'>
                    <img src='imgs/otono.png' alt='Postal de Otoño' width='300' height='200'>
                    <input type='radio' name='tema' value='otono'>
                    <img src='imgs/otono2.png' alt='Postal de Otoño' width='300' height='200'>
                    <input type='radio' name='tema' value='otono'>
                    <img src='imgs/otono3.png' alt='Postal de Otoño' width='300' height='200'>";
                }
                if($tema=="Primavera")
                {
                    echo "<br>
                    <input type='radio' name='tema' value='primavera'>
                    <img src='imgs/primavera.png' alt='Postal de Primavera' width='300' height='200'>
                    <input type='radio' name='tema' value='primavera'>
                    <img src='imgs/primavera2.png' alt='Postal de Primavera' width='300' height='200'>
                    <input type='radio' name='tema' value='primavera'>
                    <img src='imgs/primavera3.png' alt='Postal de Primavera' width='300' height='200'>";
                }
                echo "</form>";
            }
            ?>
    </body>
</html>
