<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .login-img{
            background-image: url("https://img2.goodfon.com/wallpaper/nbig/8/91/party-smoke-electronica.jpg");
            background-repeat: no-repeat;
            background-position-y: bottom;
            background-size: 100%;
            height: 35rem;
        }
        .form-container {
            position: absolute;
            top: 6vh;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #000000;
            width: 365px;

        }
    </style>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
    require 'navbar.php';
?>

<br>
<br>

<div class="row login-img">
    <section class="container-fluid">
        <section class="row justify-content-md-center">
            <section class="col-12 col-sm-6 col-md-3">
                <form class="form-container">
                    <div class="text-center">
                        <h5>
                            Ingresa tus datos
                        </h5>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="email" class="form-control" id="exampleInputName" aria-describedby="emailHelp" placeholder="Nombre Completo">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputId" placeholder="Cédula">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputPhone" placeholder="Teléfono">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputEmail" placeholder="Correo electrónico">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Repetir contraseña">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary text-center">Registrarme</button>
                    </div>
                    <div class="text-center">
                        <a href="login">¿Ya posees una cuenta?</a>
                    </div>

                </form>
            </section>
        </section>
    </section>

</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="../../public/js/bootstrap.min.js"></script>
</body>
</html>