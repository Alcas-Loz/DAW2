<html>
    <body>
        <?php
            $tit=$_POST["titulo"];
            $aut=$_POST["autor"];
            $con = new mysqli("localhost","jardinero","1234");
            $con->select_db("jardineria");
            $strsql="INSERT into libros values ('$tit','$aut')";
            if($con->query($strsql)){
                echo "Insercion completada";
            }else{
                echo "No se ha podido realizar la insercion";
            }
            $con->close();
        ?>
    </body>
</html>