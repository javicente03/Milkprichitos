<?php
session_start();
if (!isset($_SESSION["inicio"]))
    header("Location: iniciar_sesion.php");
else {
    $token = true;
    include("logica/conectar.php");
    $pedidos = $con->query("SELECT * FROM pedido P
                                LEFT JOIN cliente C ON P.id_cliente=C.id_cliente
                                WHERE estatus = 'Entregado'");
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
                <div class="container">
                    <div class="contenedor-nav">
                        <a href="login" class="brand-logo texto-logo">Mil K'prichitos</a>

                    </div>

                    <ul class="right hide-on-med-and-down">
                        <li><a href="nuevo_pedido.php">Nuevo Pedido</a></li>
                        <li><a href="editar_precios.php">Editar Precios</a></li>
                        <li><a href="ver_pedidos.php">Ver Pedidos</a></li>
                        <li><a href="pedidos_cancelados.php">Pedidos Cancelados</a></li>
                        <li><a href="pedidos_entregados.php">Pedidos Entregados</a></li>
                        <li><a href="logica/logout.php">Salir</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="section container">
        <div class="row" style="display: flex;flex-direction: row-reverse;">
            <div class="col s12 m9">
                <div class="row">
                    <h5 class="title">Pedidos Entregados</h5>
                    <table id="tabla" class="striped responsive-table centered">
                        <thead class="table-head">
                            <th>Cliente</th>
                            <th>Fecha Realizada</th>
                            <th>Fecha de Entrega</th>
                            <th>Costo Total</th>
                            <th>Ver Pedido</th>
                        </thead>
                        <tbody>
                            <?php while ($p = $pedidos->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $p["nombre"] ?></td>
                                    <td><?php echo $p["fecha_realizado"] ?></td>
                                    <td><?php echo $p["fecha_entrega"] ?></td>
                                    <td><?php echo $p["costo_total"] ?></td>
                                    <td><a class="btn btn-flat" href="revisar_pedido.php?p=<?php echo $p["id_pedido"] ?>"><i class="material-icons">visibility</i></a></td>
                                </tr>
                            <?php } ?>
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
    <script src="js/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla').DataTable({
                "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "zeroRecords": "No hay data encontrada",
                    "info": "Total: _MAX_ resultados",
                    "infoEmpty": "No hay coincidencias",
                    "infoFiltered": "",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
</body>

</html>