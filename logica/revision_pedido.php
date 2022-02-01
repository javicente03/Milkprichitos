<?php
if(isset($_POST["token"])){
    $token = true;
    if($_POST["accion"] =="entregar"){
        include("conectar.php");
        $pedido = ($con->query("SELECT * FROM pedido WHERE id_pedido = ".$_POST["id"]))->fetch_assoc();
        if($pedido["estatus"] == "Procesado"){
            $edicion = $con->query("UPDATE pedido SET estatus='Entregado' WHERE id_pedido = ".$_POST["id"]);
            if($edicion)
                echo "ok";
        } else
            echo "Ya este pedido fue atendido";
    } else if($_POST["accion"] == "cancelar"){
        include("conectar.php");
        $pedido = ($con->query("SELECT * FROM pedido WHERE id_pedido = ".$_POST["id"]))->fetch_assoc();
        if($pedido["estatus"] == "Procesado"){
            $edicion = $con->query("UPDATE pedido SET estatus='Cancelado' WHERE id_pedido = ".$_POST["id"]);
            if($edicion)
                echo "ok";
        } else
            echo "Ya este pedido fue atendido";
    } else
        echo "Inválido";

} else
    header("Location: ../iniciar_sesion.php");