<?php
function abrirCerrarCurso($con) {
    if (isset($_POST['cerrar'])) {
        $query = $con->prepare("UPDATE cursos SET abierto=0 WHERE nombre=?");
        $query->execute([$_POST['cerrar']]);
        header("Location: panelAdmin.php?token=" . $_SESSION['token']);
        exit();
    } elseif (isset($_POST['abrir'])) {
        $query = $con->prepare("UPDATE cursos SET abierto=1 WHERE nombre=?");
        $query->execute([$_POST['abrir']]);
        header("Location: panelAdmin.php?token=" . $_SESSION['token']);
        exit();
    }
}
function eliminarCurso($con) {
    if (isset($_POST['eliminar'])) {
        $query = $con->prepare("DELETE FROM cursos WHERE nombre=?");
        $query->execute([$_POST['eliminar']]);
        header("Location: panelAdmin.php?token=" . $_SESSION['token']);
        exit();
    }
}
function crearCurso($con) {
    if (isset($_POST['crear'])) {
        $codigo = trim($_POST['codigo']);
        $nombrecurso = trim($_POST['nombrecurso']);
        $abierto = isset($_POST['abierto']) ? 1 : 0;
        $numeroplazas = trim($_POST['numeroplazas']);
        $plazoinscripcion = trim($_POST['plazoinscripcion']);
        if (empty($codigo) || empty($nombrecurso) || empty($numeroplazas) || empty($plazoinscripcion)) {
            $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios para crear un curso.";
            $_SESSION['tipo_mensaje'] = "danger";
        } else {
            try {
                $query = $con->prepare("INSERT INTO cursos (codigo, nombre, abierto, numeroplazas, plazoinscripcion) VALUES (?, ?, ?, ?, ?)");
                $query->execute([$codigo, $nombrecurso, $abierto, $numeroplazas, $plazoinscripcion]);
                
                $_SESSION['mensaje'] = "¡Curso creado exitosamente!";
                $_SESSION['tipo_mensaje'] = "success"; // Verde
            } catch (PDOException $e) {
                $_SESSION['mensaje'] = "Error al guardar: " . $e->getMessage();
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
        header("Location: panelAdmin.php?token=" . $_SESSION['token']);
        exit();
    }
}
function admitirSolicitante($con) {
    if (isset($_POST['admitir'])) {
        $dni = $_POST['dni'];
        $codigocurso = $_POST['codigocurso'];
        $query = $con->prepare("UPDATE solicitudes SET admitido=1 WHERE dni=? AND codigocurso=?");
        $query->execute([$dni, $codigocurso]);
        header("Location: listadoSolicitudes.php?token=" . $_SESSION['token'] . "&curso=" . $codigocurso);
        exit();
    }
}
function ejecutarBaremacion($con, $codigoCurso) {
    $stmt = $con->prepare("SELECT numeroplazas, plazoinscripcion FROM courses WHERE codigo = ?");
    $stmt = $con->prepare("SELECT numeroplazas, plazoinscripcion FROM cursos WHERE codigo = ?");
    $stmt->execute([$codigoCurso]);
    $curso = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$curso) return;
    if (date('Y-m-d') <= $curso['plazoinscripcion']) {
        $_SESSION['mensaje'] = "Error: Aún no ha finalizado el plazo de inscripción.";
        $_SESSION['tipo_mensaje'] = "danger";
        return;
    }
    $todosLosSolicitantes = funcionPuntos($codigoCurso, 999999);
    $plazasDisponibles = $curso['numeroplazas'];
    $contador = 0;
    foreach ($todosLosSolicitantes as $solicitante) {
        $dni = $solicitante['dni'];
        $estadoAdmitido = ($contador < $plazasDisponibles) ? 1 : 0;
        $update = $con->prepare("UPDATE solicitudes SET admitido = ? WHERE dni = ? AND codigocurso = ?");
        $update->execute([$estadoAdmitido, $dni, $codigoCurso]);
        $contador++;
    }
    $_SESSION['mensaje'] = "Baremación realizada correctamente. Se han asignado " . min($contador, $plazasDisponibles) . " plazas.";
    $_SESSION['tipo_mensaje'] = "success";
}
?>