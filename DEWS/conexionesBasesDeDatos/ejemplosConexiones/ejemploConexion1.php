<?php
    mysqli_report(MYSQLI_REPORT_ERROR);
    $con=mysqli_connect("localhost","jardinero","1234","jardineria");
    if (mysqli_connect_errno()) {
    printf("Conexión fallida:%s\n",mysqli_connect_error());
    exit();
    }
    $query="SELECT distinct NombreCliente from Clientes natural Join Pedidos
    WHERE FechaEntrega > FechaEsperada";
    if($result=mysqli_query($con,$query)) {
    while($row=mysqli_fetch_row($result)) {// recorre las filas del conjunto resul
    printf("%s\n",$row[0]);
    }
    mysqli_free_result($result);
    }
    mysqli_close($con);
?>