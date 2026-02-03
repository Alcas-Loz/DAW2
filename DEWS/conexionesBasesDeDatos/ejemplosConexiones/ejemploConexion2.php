<?php
mysqli_report(MYSQLI_REPORT_STRICT);
try{
$con=mysqli_connect("localhost","jardinero","1234","jardineria");
$query="SELECT distinct NombreCliente from Clientes natural Join Pedidos
WHERE FechaEntrega > FechaEsperada";
if($result=mysqli_query($con,$query)) {
while($row=mysqli_fetch_row($result)) {// recorre las filas del conjunto resul
printf("%s\n",$row[0]);
}
mysqli_free_result($result);
}
mysqli_close($con);
}catch(mysqli_sql_exception $e){
printf("Conexión fallida:%s\n",$e->getMessage());
}
?>