<?php
function inscribirse($con) {
    $nombreCurso = $_POST['inscribirse'];
    $query = $con->prepare("SELECT codigo, abierto FROM cursos WHERE nombre = ?");
    $query->execute([$nombreCurso]);
    $curso = $query->fetch(PDO::FETCH_ASSOC);
    if ($curso) {
        if ($curso['abierto'] == 1) {
            $codigoCurso = $curso['codigo'];
            $dni = $_SESSION['dni'];
            $check = $con->prepare("SELECT * FROM solicitudes WHERE dni = ? AND codigocurso = ?");
            $check->execute([$dni, $codigoCurso]);
            if ($check->rowCount() == 0) {
                $insertSql = $con->prepare("INSERT INTO solicitudes (dni, codigocurso, fechasolicitud, admitido) VALUES (?, ?, CURDATE(), 0)");
                $insertSql->execute([$dni, $codigoCurso]);
                $_SESSION['mensaje'] = "Solicitud registrada. Tu admisión dependerá de los puntos al finalizar el plazo.";
                $_SESSION['tipo_mensaje'] = "success"; 
            } else {
                $_SESSION['mensaje'] = "Error: Ya habías solicitado plaza en este curso.";
                $_SESSION['tipo_mensaje'] = "warning";
            }
        } else {
            $_SESSION['mensaje'] = "Aviso: El plazo de este curso está cerrado.";
            $_SESSION['tipo_mensaje'] = "danger"; 
        }
    } else {
        $_SESSION['mensaje'] = "Error: El curso no existe.";
        $_SESSION['tipo_mensaje'] = "danger";
    }
    $query->closeCursor();
    header("Location: panelUsuario.php?token=" . $_SESSION['token']);
    exit();
}
function buscarCursos($con, $fechaBusqueda) {
    if (empty($fechaBusqueda)) {
        return;
    }
    $strsql = $con->prepare("SELECT codigo, nombre, abierto, numeroplazas, plazoinscripcion FROM cursos WHERE plazoinscripcion = ?");
    $strsql->execute([$fechaBusqueda]);
    if ($strsql->rowCount() > 0) {
        echo "<table class='table table-bordered' border='1px solid black' style='margin-top: 20px;'>";
        echo "<thead>";
            echo "<tr><th colspan='5' style='text-align: center;'><h2>Cursos Disponibles</h2></th></tr>";
            echo "<tr>
                    <th>Nombre</th>
                    <th>Abierto</th>
                    <th>Número de Plazas</th>
                    <th>Plazo de Inscripción</th>
                    <th>Acción</th>
                  </tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($fila = $strsql->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>" . $fila['abierto'] . "</td>";
            echo "<td>" . $fila['numeroplazas'] . "</td>";
            echo "<td>" . $fila['plazoinscripcion'] . "</td>";
            echo "<td>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='inscribirse' value='" . $fila['nombre'] . "'>
                        <button type='submit' class='btn btn-success'>Inscribirse</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<div class='alert alert-warning text-center' style='margin-top:20px;'>No se encontraron cursos para la fecha seleccionada.</div>";
    }
    $strsql->closeCursor();
}
?>