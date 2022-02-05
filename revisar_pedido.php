<?php
session_start();
if (!isset($_SESSION["inicio"]))
    header("Location: iniciar_sesion.php");
else {
    $token = true;
    include("logica/conectar.php");
    $id_pedido = $_GET["p"];
    $pedido = ($con->query("SELECT * FROM pedido P
                                LEFT JOIN cliente C ON P.id_cliente=C.id_cliente
                                WHERE id_pedido = $id_pedido"))->fetch_assoc();
    $articulos = $con->query("SELECT * FROM contenido_pedido CP
                                LEFT JOIN articulo A ON CP.id_articulo=A.id_articulo
                                WHERE id_pedido = $id_pedido");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar Pedido</title>
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
                    <h5>Información</h5>
                    <div class="col s12 pink lighten-4" style="border: 1px solid black;">
                        <h6>Cliente: <?php echo $pedido["nombre"] ?></h6>
                    </div>
                    <div class="col s12 pink lighten-4" style="border: 1px solid black;">
                        <h6>Dirección: <?php echo $pedido["direccion"] ?></h6>
                    </div>
                    <div class="col s12 m6 pink lighten-4" style="border: 1px solid black;">
                        <h6>Fecha realizada: <?php echo $pedido["fecha_realizado"] ?></h6>
                    </div>
                    <div class="col s12 m6 pink lighten-4" style="border: 1px solid black;">
                        <h6>Fecha de entrega: <?php echo $pedido["fecha_entrega"] ?></h6>
                    </div>
                    <?php if ($pedido["estatus"] == "Procesado") { ?>
                        <div class="col s12 m6 center"><button id="cancelar" class="btn red">Cancelar</button></div>
                        <div class="col s12 m6 center"><button id="entregar" class="btn pink">Entregar</button></div>
                    <?php } ?>
                    <h5>Pedido</h5>
                    <table class="responsive-table striped centered">
                        <thead class="table-head">
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario (para ese momento)</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            <?php while ($a = $articulos->fetch_assoc()) {
                                $costo = $a["cantidad"] * $a["precio"];
                            ?>

                                <tr>
                                    <td><?php echo $a["nombre_articulo"] ?></td>
                                    <td><?php echo $a["cantidad"] ?></td>
                                    <td><?php echo $a["precio_momento"] ?> Bs</td>
                                    <td><?php echo $costo ?> Bs</td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="pink lighten-5">Costo Total:</td>
                                <td class="pink lighten-5"><?php echo $pedido["costo_total"] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/materialize.js"></script>
    <script src="js/elementos-materialize.js"></script>

    <script>
        $("#entregar").click(function(e) {
            var formData = new FormData();
            formData.append('id', <?php echo $id_pedido ?>);
            formData.append('accion', "entregar");
            formData.append('token', "token");
            $.ajax({
                type: "POST",
                url: 'logica/revision_pedido.php',
                data: formData,
                enctype: 'application/x-www-form-urlencoded',
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function(response) {
                    if (response == "ok" || response.substring(0, 15) == "<!DOCTYPE html>") {
                        M.toast({
                            html: "Entrega exitósa",
                            classes: 'rounded green'
                        })
                    } else {
                        M.toast({
                            html: response,
                            classes: 'rounded red'
                        })
                    }
                }
            });
        })

        $("#cancelar").click(function(e) {
            var formData = new FormData();
            formData.append('id', <?php echo $id_pedido ?>);
            formData.append('accion', "cancelar");
            formData.append('token', "token");
            $.ajax({
                type: "POST",
                url: 'logica/revision_pedido.php',
                data: formData,
                enctype: 'application/x-www-form-urlencoded',
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function(response) {
                    if (response == "ok" || response.substring(0, 15) == "<!DOCTYPE html>") {
                        M.toast({
                            html: "Cancelado",
                            classes: 'rounded green'
                        })
                    } else {
                        M.toast({
                            html: response,
                            classes: 'rounded red'
                        })
                    }
                }
            });
        })
    </script>
</body>

</html>