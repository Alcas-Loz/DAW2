<?php
    $con = new mysqli("localhost","jardinero","1234");
    $con->select_db("jardineria");
    $strsql="SELECT Nombre, Apellido1 FROM Empleados";
    if ($resu=$con->query($strsql)){
    while($fila=$resu->fetch_row()){
        foreach($fila as $valor){
            echo $valor." ";
        }
        echo "<br>";
    }
    $resu->close();
    $con->close();
    }
?>