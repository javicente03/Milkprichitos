<?php
session_start();
if (!isset($_SESSION["inicio"]))
    header("Location: iniciar_sesion.php");
else {
    $token = true;
    include("logica/conectar.php");
    $precioTorta = ($con->query("SELECT * FROM articulo WHERE id_articulo=1"))->fetch_assoc();
    $precioPonque = ($con->query("SELECT * FROM articulo WHERE id_articulo=2"))->fetch_assoc();
    $precioTrufa = ($con->query("SELECT * FROM articulo WHERE id_articulo=3"))->fetch_assoc();
    $precioCauchito = ($con->query("SELECT * FROM articulo WHERE id_articulo=4"))->fetch_assoc();
    $precioDona = ($con->query("SELECT * FROM articulo WHERE id_articulo=5"))->fetch_assoc();
    $precioGalleta = ($con->query("SELECT * FROM articulo WHERE id_articulo=6"))->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Realizados</title>
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/datatables.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
<div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper navcolor fixed">
                        <a href="login" class="brand-logo texto-logo">Mil K'prichitos</a>

                

                    <ul class="right hide-on-med-and-down">
                        <li><a href="nuevo_pedido.php">Nuevo Pedido</a></li>
                        <li><a href="editar_precios.php">Editar Precios</a></li>
                        <li><a href="ver_pedidos.php">Ver Pedidos</a></li>
                        <li><a href="pedidos_cancelados.php">Pedidos Cancelados</a></li>
                        <li><a href="pedidos_entregados.php">Pedidos Entregados</a></li>
                        <li><a href="logica/logout.php">Salir</a></li>
                    </ul>
            </div>
        </nav>
    </div>

    <div class="section container">
        <div class="row" style="display: flex;flex-direction: row-reverse;">
            <div class="col s12 m9">
                <div class="row">
                    <h5>Editar Precios</h5>
                    <form id="form">
                        <input type="hidden" name="token" value="token">
                        <div class="input-field col s12 m6"><input type="text" name="torta" value="<?php echo $precioTorta['precio'] ?>" id="torta"><label for="torta">Precio de 1 torta</label></div>
                        <div class="input-field col s12 m6"><input type="text" name="ponque" value="<?php echo $precioPonque['precio'] ?>" id="ponque"><label for="ponque">Precio de 1 ponquesito</label></div>
                        <div class="input-field col s12 m6"><input type="text" name="trufa" value="<?php echo $precioTrufa['precio'] ?>" id="trufa"><label for="trufa">Precio de 1 trufa</label></div>
                        <div class="input-field col s12 m6"><input type="text" name="cauchito" value="<?php echo $precioCauchito['precio'] ?>" id="cauchito"><label for="cauchito">Precio de 1 cauchito</label></div>
                        <div class="input-field col s12 m6"><input type="text" name="dona" value="<?php echo $precioDona['precio'] ?>" id="dona"><label for="dona">Precio de 1 dona</label></div>
                        <div class="input-field col s12 m6"><input type="text" name="galleta" value="<?php echo $precioGalleta['precio'] ?>" id="galleta"><label for="galleta">Precio de 1 galleta</label></div>
                        <div class="input-field center col s12"><button class="btn pink"><i class="material-icons left">send</i>Guardar</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/materialize.js"></script>
    <script src="js/elementos-materialize.js"></script>

    <script>
        $('#form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'logica/editar_precios_bd.php',
                data: $(this).serialize(),
                enctype: 'application/x-www-form-urlencoded',
                success: function(response) {
                    if (response == "ok") {
                        location.href = ""
                    } else {
                        M.toast({
                            html: response,
                            classes: 'rounded red'
                        })
                    }
                }
            });
        });
    </script>
</body>

</html>