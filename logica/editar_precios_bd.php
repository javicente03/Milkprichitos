<?php
if(isset($_POST["token"])){
    $torta = addslashes(trim($_POST["torta"]));
    $ponque = addslashes(trim($_POST["ponque"]));
    $trufa = addslashes(trim($_POST["trufa"]));
    $cauchito = addslashes(trim($_POST["cauchito"]));
    $dona = addslashes(trim($_POST["dona"]));
    $galleta = addslashes(trim($_POST["galleta"]));
    $token =true;

    if($torta!="" && $ponque!="" && $trufa!="" && $cauchito!="" && $dona!="" && $galleta!=""){
        if(is_numeric($torta) && is_numeric($ponque) && is_numeric($trufa) && is_numeric($cauchito)
            && is_numeric($dona) && is_numeric($galleta)){
                include("conectar.php");
                $con->query("UPDATE articulo SET precio='$torta' WHERE id_articulo=1");
                $con->query("UPDATE articulo SET precio='$ponque' WHERE id_articulo=2");
                $con->query("UPDATE articulo SET precio='$trufa' WHERE id_articulo=3");
                $con->query("UPDATE articulo SET precio='$cauchito' WHERE id_articulo=4");
                $con->query("UPDATE articulo SET precio='$dona' WHERE id_articulo=5");
                $con->query("UPDATE articulo SET precio='$galleta' WHERE id_articulo=6");
                echo "ok";
        } else
            echo "Datos inválidos";
    } else
        echo "Datos inválidos";
} else
    header("Location: ../iniciar_sesion.php");