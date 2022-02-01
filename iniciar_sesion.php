<?php
    session_start();
    if(isset($_SESSION["inicio"]))
        header("Location: nuevo_pedido.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/datatables.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper navcolor fixed">
                <div class="contenedor-nav">
                    <a href="login" class="brand-logo texto-logo">Mil K'prichitos</a>
                </div>
            </div>
        </nav>
    </div>

    <div class="section container contenedor">
        <div class="cont-login">
            <form id="form" style="text-align: center;">
                <h4 >Inicio de Sesión</h4>
                <div class="input-field">
                    <i class="material-icons prefix">person</i>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                </div>
                <div class="input-field">
                    <i class="material-icons prefix" id="ver" style="cursor: pointer;">visibility</i>
                    <input type="password" name="password" id="password" placeholder="Contraseña">
                </div>
                <div class="progress indigo darken-4" id="progress" style="display: none;">
                    <div class="indeterminate"></div>
                </div>
                <button type="submit" class="btn pink lighten-1" id="btn-submit">
                    <i class="material-icons left">send</i>Ingresar</button>
            </form>
        </div>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/materialize.js"></script>
    <script src="js/elementos-materialize.js"></script>
    <script>
        $("#ver").click(function(e) {
            var pass = document.getElementById("password");
            var icon = document.getElementById("ver");

            if (pass.getAttribute("type", "password") == "password") {
                pass.setAttribute("type", "text")
                icon.innerHTML = "visibility_off"
            } else {
                pass.setAttribute("type", "password")
                icon.innerHTML = "visibility"
            }
        })

        $('#form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'logica/login.php',
                data: $(this).serialize(),
                enctype: 'application/x-www-form-urlencoded',
                success: function(response) {
                    if (response == "ok") {
                        location.href = "nuevo_pedido.php"
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