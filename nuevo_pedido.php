<?php
session_start();
if (!isset($_SESSION["inicio"]))
    header("Location: iniciar_sesion.php");
else {
    $token = true;
    include("logica/conectar.php");
    $clientes = $con->query("SELECT * FROM cliente");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Pedido</title>
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
                    <h5>Pedido</h5>
                    <form id="form">
                        <input type="hidden" name="token" value="token">
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">person</i>
                            <select name="cliente" id="cliente">
                                <option value="" disabled selected>Seleccione un cliente</option>
                                <option value="0">Nuevo</option>
                                <?php
                                while ($c = $clientes->fetch_assoc()) {
                                    echo "<option value='" . $c["id_cliente"] . "'>" . $c["nombre"] . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="date" name="fecha">
                            <label for="fecha">Día de entrega</label>
                        </div>
                        <div id="nuevo1" class="col s12 m6 input-field" style="display: none;">
                            <input type="text" placeholder="Nombre y Apellido" name="nombre">
                        </div>
                        <div id="nuevo2" class="col s12 m6 input-field" style="display: none;">
                            <textarea name="direccion" name="direccion" class="materialize-textarea" placeholder="Dirección"></textarea>
                        </div>
                        <h6>Marque las opciones del pedido</h6>
                        <div class="input-field col s12 m6" style="border-bottom: 1px dashed black;">
                            <div class="row">
                                <div class="col s4 center">
                                    <p style="margin-top: 20px;"><label>
                                            <input type="checkbox" class="filled-in" id="torta"><span>Torta</span></label></p>
                                </div>
                                <div class="col s4"><input type="number" placeholder="Cantidad" id="tortaCantidad"></div>
                            </div>
                        </div>
                        <div class="input-field col s12 m6" style="border-bottom: 1px dashed black;">
                            <div class="row">
                                <div class="col s4 center">
                                    <p style="margin-top: 20px;"><label><input type="checkbox" class="filled-in" id="ponque"><span>Ponquesitos</span></label></p>
                                </div>
                                <div class="col s4"><input type="number" placeholder="Cantidad" id="ponqueCantidad"></div>
                            </div>
                        </div>
                        <div class="input-field col s12 m6" style="border-bottom: 1px dashed black;">
                            <div class="row">
                                <div class="col s4 center">
                                    <p style="margin-top: 20px;"><label><input type="checkbox" class="filled-in" id="trufas"><span>Trufas</span></label></p>
                                </div>
                                <div class="col s4"><input type="number" placeholder="Cantidad" id="trufaCantidad"></div>
                            </div>
                        </div>
                        <div class="input-field col s12 m6" style="border-bottom: 1px dashed black;">
                            <div class="row">
                                <div class="col s4 center">
                                    <p style="margin-top: 20px;"><label><input type="checkbox" class="filled-in" id="cauchito"><span>Cauchitos</span></label></p>
                                </div>
                                <div class="col s4"><input type="number" placeholder="Cantidad" id="cauchitoCantidad"></div>
                            </div>
                        </div>
                        <div class="input-field col s12 m6" style="border-bottom: 1px dashed black;">
                            <div class="row">
                                <div class="col s4 center">
                                    <p style="margin-top: 20px;"><label><input type="checkbox" class="filled-in" id="dona"><span>Donas</span></label></p>
                                </div>
                                <div class="col s4"><input type="number" placeholder="Cantidad" id="donaCantidad"></div>
                            </div>
                        </div>
                        <div class="input-field col s12 m6" style="border-bottom: 1px dashed black;">
                            <div class="row">
                                <div class="col s4 center">
                                    <p style="margin-top: 20px;"><label><input type="checkbox" class="filled-in" id="galleta"><span>Galletas</span></label></p>
                                </div>
                                <div class="col s4"><input type="number" placeholder="Cantidad" id="galletaCantidad"></div>
                            </div>
                        </div>
                        <div class="input-field col s12 center">
                            <button class="btn pink lighten-1">Enviar</button>
                        </div>
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
        $("#cliente").change(function(e) {
            if ($("#cliente").val() == 0) {
                $("#nuevo1").css("display", "block")
                $("#nuevo2").css("display", "block")
            } else {
                $("#nuevo1").css("display", "none")
                $("#nuevo2").css("display", "none")
            }
        })


        $("#form").submit(function(e) {
            var json = Array()
            pass = false
            if ($("#torta").prop("checked")) {
                pass = true
                if ($("#tortaCantidad").val() != "" && $("#tortaCantidad").val() > 0 && !isNaN($("#tortaCantidad").val())) {
                    json.push([1, $("#tortaCantidad").val()])
                } else{
                    M.toast({
                        html: "Debe ingresar correctamente los datos de Torta",
                        classes: 'rounded red'
                    })
                    pass = false
                }
            }

            if ($("#ponque").prop("checked")) {
                pass = true
                if ($("#ponqueCantidad").val() != "" && $("#ponqueCantidad").val() > 0 && !isNaN($("#ponqueCantidad").val())) {
                    json.push([2, $("#ponqueCantidad").val()])
                } else{
                    M.toast({
                        html: "Debe ingresar correctamente los datos de Ponquesito",
                        classes: 'rounded red'
                    })
                    pass = false
                }
            }

            if ($("#trufas").prop("checked")) {
                pass = true
                if ($("#trufaCantidad").val() != "" && $("#trufaCantidad").val() > 0 && !isNaN($("#trufaCantidad").val())) {
                    json.push([3, $("#trufaCantidad").val()])
                } else{
                    M.toast({
                        html: "Debe ingresar correctamente los datos de Trufas",
                        classes: 'rounded red'
                    })
                    pass = false
                }
            }

            if ($("#cauchito").prop("checked")) {
                pass = true
                if ($("#cauchitoCantidad").val() != "" && $("#cauchitoCantidad").val() > 0 && !isNaN($("#cauchitoCantidad").val())) {
                    json.push([4, $("#cauchitoCantidad").val()])
                } else {
                    M.toast({
                        html: "Debe ingresar correctamente los datos de Cauchitos",
                        classes: 'rounded red'
                    })
                    pass = false
                }
            }

            if ($("#dona").prop("checked")) {
                pass = true
                if ($("#donaCantidad").val() != "" && $("#donaCantidad").val() > 0 && !isNaN($("#donaCantidad").val())) {
                    json.push([5, $("#donaCantidad").val()])
                } else {
                    M.toast({
                        html: "Debe ingresar correctamente los datos de Donas",
                        classes: 'rounded red'
                    })
                    pass = false
                }
            }

            if ($("#galleta").prop("checked")) {
                pass = true
                if ($("#galletaCantidad").val() != "" && $("#galletaCantidad").val() > 0 && !isNaN($("#galletaCantidad").val())) {
                    json.push([6, $("#galletaCantidad").val()])
                } else { 
                    M.toast({
                        html: "Debe ingresar correctamente los datos de Galletas",
                        classes: 'rounded red'
                    })
                    pass = false
                }
            }

            if (pass) {
                var formData = new FormData(document.getElementById("form"));
                formData.append('array', JSON.stringify(json));
                e.preventDefault()
                $.ajax({
                    type: "POST",
                    url: 'logica/realizar_pedido.php',
                    data: formData,
                    enctype: 'application/x-www-form-urlencoded',
                    processData: false, // tell jQuery not to process the data
                    contentType: false,
                    success: function(response) {
                        if (response == "ok" || response.substring(0, 15) == "<!DOCTYPE html>") {
                            M.toast({
                                html: "Pedido exitóso",
                                classes: 'rounded green'
                            })
                            setTimeout(() => {
                                location.href = ""
                            }, 3000);
                        } else {
                            M.toast({
                                html: response,
                                classes: 'rounded red'
                            })
                        }
                    }
                });
            } else
                M.toast({
                    html: "No ha seleccionado ningún elemento",
                    classes: 'rounded red'
                })
            e.preventDefault()
        })
    </script>
</body>

</html>