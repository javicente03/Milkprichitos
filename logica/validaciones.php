<?php
if (isset($token)) {
    function validar_fecha($fecha)
    {
        $validate_fechas = explode("-", $fecha);
        if (count($validate_fechas) == 3 && checkdate($validate_fechas[1], $validate_fechas[2], $validate_fechas[0])) {
            return true;
        } else {
            return false;
        }
    }
}