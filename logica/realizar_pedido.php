<?php
if (isset($_POST["token"])) {
    $token = true;
    $fecha = addslashes(trim($_POST["fecha"]));
    $array = json_decode($_POST['array']);

    if (isset($_POST["cliente"])) {
        $cliente = addslashes(trim($_POST["cliente"]));
        if ($cliente != "" && $fecha != "" && is_numeric($cliente) && count($array) > 0) {
            include("validaciones.php");
            $validada = validar_fecha($fecha);
            if ($validada) {
                if ($fecha >  date("Y-m-d")) {
                    $pass = false;
                    foreach ($array as list($articulo, $cantidad)) {
                        if (!is_numeric($cantidad) || $cantidad=="" || $cantidad <= 0)
                            $pass = true;
                        if (!is_numeric($articulo) || $articulo<1 || $articulo >6)
                            $pass = true;
                    }
                    if (!$pass) {
                        include("conectar.php");
                        if ($cliente == 0) {
                            $nombre = addslashes(trim($_POST["nombre"]));
                            $direccion = addslashes(trim($_POST["direccion"]));
                            if ($nombre != "" && $direccion != "") {
                                $con->query("INSERT INTO cliente (nombre, direccion) 
                                VALUES ('$nombre', '$direccion')");
                                $nuevo_cliente = ($con->query("SELECT id_cliente FROM cliente ORDER BY id_cliente DESC LIMIT 1"))->fetch_assoc();
                                generarPedido($token, $nuevo_cliente["id_cliente"], $array, $fecha);
                            } else
                                echo "Debe completar los datos del nuevo cliente";
                        } else
                            generarPedido($token, $cliente, $array, $fecha);
                    } else
                        echo "Error en los datos";
                } else
                    echo "Fecha inválida, debe ser mayor a hoy";
            } else
                echo "Fecha Inválida";
        } else
            echo "Debe completar los datos correctamente";
    } else
        echo "Debe seleccionar o ingresar un cliente";
} else
    header("Location: ../iniciar_sesion.php");

function generarPedido($token, $cliente, $array, $fecha)
{
    $hoy = date("Y-m-d");
    include("conectar.php");
    $con->query("INSERT INTO pedido (id_cliente, fecha_entrega, fecha_realizado) 
                    VALUES ('$cliente', '$fecha', '$hoy')");

    $pedido = ($con->query("SELECT id_pedido FROM pedido ORDER BY id_pedido DESC LIMIT 1"))->fetch_assoc();
    $pedido_id = $pedido["id_pedido"];
    $costo_total = 0;
    foreach ($array as list($articulo, $cantidad)) {
        $informacion_articulo = ($con->query("SELECT * FROM articulo WHERE id_articulo = $articulo"))->fetch_assoc();
        $costo_por_articulo = $informacion_articulo["precio"] * $cantidad;
        $con->query("INSERT INTO contenido_pedido (id_pedido, id_articulo, cantidad,precio_momento) 
                    VALUES ('$pedido_id', '$articulo', '$cantidad', '".$informacion_articulo["precio"]."')");
        $costo_total += $costo_por_articulo;
    }
    $con->query("UPDATE pedido SET costo_total = '$costo_total' WHERE id_pedido = $pedido_id");
    echo "ok";
}
