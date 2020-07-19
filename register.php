<!DOCTYPE html>
<html lang="en">
<head>
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

<div class="row register-img">
    <section class="container-fluid">
        <section class="row justify-content-md-center">
            <section class="col-12 col-sm-6 col-md-3">
                <form class="form-container-register">
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
