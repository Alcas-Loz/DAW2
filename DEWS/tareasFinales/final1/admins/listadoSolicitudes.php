<?php
    require_once 'funcionesPanelAdmin.php';
    require_once '../funciones/funcionPuntos.php';
    session_start();
    if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_GET['token']) {
        header("Location: login.php");
        exit();
    }
    try {
        $con = new PDO('mysql:host=localhost;dbname=cursoscp;charset=utf8', 'admin', '1234');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (isset($_POST['baremar'])) {
            ejecutarBaremacion($con, $_POST['codigocurso']);
            header("Location: listadoSolicitudes.php?token=" . $_SESSION['token'] . "&curso=" . $_POST['codigocurso']);
            exit();
        }
        admitirSolicitante($con);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Solicitados</title>
</head>
<body>
    <h1 class="text-center">Gestión de Solicitudes</h1>
    <?php if (isset($_SESSION['mensaje'])){
        echo '<div class="alert alert-' . $_SESSION['tipo_mensaje'] . ' text-center">';
            echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); unset($_SESSION['tipo_mensaje']);
        echo '</div>';
    }
    echo "<div class='container'>";
    $codigoCurso = isset($_GET['curso']) ? $_GET['curso'] : '';
    if($codigoCurso != '') {
        $stmtDatos = $con->prepare("SELECT nombre, numeroplazas, plazoinscripcion FROM cursos WHERE codigo = ?");
        $stmtDatos->execute([$codigoCurso]);
        $datosCurso = $stmtDatos->fetch(PDO::FETCH_ASSOC);
        $fechaHoy = date('Y-m-d');
        $plazoFinalizado = ($fechaHoy > $datosCurso['plazoinscripcion']);
        echo "<h3>Curso: " . $datosCurso['nombre'] . "</h3>";
        echo "<p>Plazas: <b>" . $datosCurso['numeroplazas'] . "</b> | Plazo: <b>" . $datosCurso['plazoinscripcion'] . "</b></p>";
        if ($plazoFinalizado) {
            echo "<div class='alert alert-info text-center'>";
            echo "El plazo ha finalizado. Puedes realizar la asignación automática de plazas segun los puntos.";
            echo "<form method='post' class='mt-2'>
                    <input type='hidden' name='codigocurso' value='".$codigoCurso."'>
                    <button type='submit' name='baremar' class='btn btn-warning font-weight-bold'>REALIZAR BAREMACIÓN AUTOMÁTICA</button>
                  </form>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-secondary text-center'>La baremación automática estará disponible cuando finalice el plazo (" . $datosCurso['plazoinscripcion'] . ").</div>";
        }
        $solicitudes = funcionPuntos($codigoCurso, 1000); 
        echo "<table class='table table-bordered table-hover'>";
        echo "<thead class='thead-dark'><tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Puntos</th>
                <th>Estado Actual</th>
              </tr></thead><tbody>";
        foreach ($solicitudes as $fila) {
            // Consultamos estado real en la tabla solicitudes
            $stmtEstado = $con->prepare("SELECT admitido FROM solicitudes WHERE dni = ? AND codigocurso = ?");
            $stmtEstado->execute([$fila['dni'], $codigoCurso]);
            $esAdmitido = $stmtEstado->fetchColumn();
            $clase = ($esAdmitido == 1) ? 'table-success' : '';
            $textoEstado = ($esAdmitido == 1) ? '<b>ADMITIDO</b>' : 'No admitido';
            echo "<tr class='$clase'>";
            echo "<td>" . $fila['dni'] . "</td>";
            echo "<td>" . $fila['nombre'] . " " . $fila['apellidos'] . "</td>";
            echo "<td>" . $fila['puntos'] . "</td>";
            echo "<td>" . $textoEstado . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-danger'>No se ha seleccionado curso.</div>";
    }
    echo "<div class='text-center'><a href='panelAdmin.php?token=" . $_SESSION['token'] . "' class='btn btn-primary'>Volver</a></div>";
    ?>
    </div>
</body>
</html>