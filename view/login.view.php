<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
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
                <form class="form-container-login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="text-center">
                        <h5>
                            ¡Comienza a armar tu fiesta!
                        </h5>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="text" class="form-control" name="user" id="user" placeholder="Usuario">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass" id="pass" placeholder="Contraseña">
                    </div>
                    <ul class="text-light bg-danger">
                        <?php
                            echo (isset($error)) ? $error : '';
                        ?>
                    </ul>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary text-center">Iniciar sesión</button>
                    </div>
                    <div class="text-center">
                        <a href="register">¿No posees una cuenta?</a>
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
