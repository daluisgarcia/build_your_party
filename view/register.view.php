<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
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
                <form class="form-container-register" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="text-center">
                        <h5>
                            Ingresa tus datos
                        </h5>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="exampleInputName" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="last_name" id="exampleInputName" placeholder="Apellido">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="id" id="exampleInputId" placeholder="Cédula">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" id="exampleInputPhone" placeholder="Teléfono">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" id="exampleInputEmail" placeholder="Correo electrónico">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="user" id="exampleInputEmail" placeholder="Usuario">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass" id="exampleInputPassword1" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass_con" id="exampleInputPassword2" placeholder="Repetir contraseña">
                    </div>
                    <ul class="text-light bg-danger">
                        <?php
                        echo (isset($error)) ? $error : '';
                        ?>
                    </ul>
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
