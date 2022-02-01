<?php
$usuario = addslashes(trim($_POST["usuario"]));
$clave = addslashes(trim($_POST["password"]));

if($usuario !="" && $clave!=""){
    if($usuario=="milimar" && $clave =="milk1234"){
        session_start();
        $_SESSION["inicio"] = 1;
        echo "ok";
    } else
        echo "Datos inválidos";
} else 
    echo "Debe completar los datos";