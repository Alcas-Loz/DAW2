<?php
function calcularPuntos($datos) {
    $puntos = 0;
    if (isset($datos['coordeinadortic'])) {
        $puntos += 4;
    }
    if (isset($datos['grupotic'])) {
        $puntos += 3;
    }
    if (isset($datos['pbilin'])) {
        $puntos += 3;
    }
    $cargo = $datos['nombrecargo'] ?? '';
    
    if ($cargo == 'Director' || $cargo == 'Jefe de Estudios' || $cargo == 'Secretario') {
        $puntos += 2;
    } elseif ($cargo == 'Jefe de Departamento') {
        $puntos += 1;
    }
    if (!empty($datos['fechaalta'])) {
        try {
            $fechaAlta = new DateTime($datos['fechaalta']);
            $hoy = new DateTime();
            $diferencia = $hoy->diff($fechaAlta);
            
            if ($diferencia->y > 15) {
                $puntos += 1;
            }
        } catch (Exception $e) {
        }
    }
    if (isset($datos['situacion']) && $datos['situacion'] == 'activo') {
        $puntos += 1;
    }
    return $puntos;
}
?>