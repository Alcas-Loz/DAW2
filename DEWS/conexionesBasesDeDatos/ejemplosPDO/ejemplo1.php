<?php
try{
    $user="jardinero";
    $contra="1234";
    $con=new PDO("mysql:host=127.0.0.1;dbname=jardineria",$user,$contra);
    echo "Te has conectado a la base de datos jardinero";
    $stmt=$con->prepare("select * from empleados where codigooficina=:TAL-ES and codigojefe=:2");
    $stmt->bindValue(":codigooficina", $cod);
    $stmt->bindValue(":codigojefe", $codJef);
    $stmt->execute();
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $fila["codigooficina"]. " ".$fila["codigojefe"];
    }
}catch(error $e){
    echo $con->errorInfo();
}
?>