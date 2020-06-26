<!DOCTYPE html>
<html lang="en">

<head>
    <style>

    </style>
    <meta charset="UTF-8">
    <title>Inscripción Curso Matrimonial</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require 'navbar.php';
    ?>

    <br>
    <br>

    <div class="img-fondo-seccion-sm" style="background-image: url(https://bungareestation.com.au/wp-content/uploads/2019/10/Bungaree-Station-Weddings-Garden-Wedding-5.jpg)">
        <form class="form-container-m">
            <div class="text-center">
                <h5>
                    Inscripción Curso Matrimonial
                </h5>
            </div>
            <br>
            <div>

            </div>
            <form>
                <div class="row">
                    <div class="col">
                        <label for="nombre_inscrito_1">Nombre y Apellido</label>
                        <input class="form-control" type="text" placeholder="Nombre y Apellido">
                    </div>
                    <div class="col">
                        <label for="cedula_inscrito_1">Cédula</label>
                        <input class="form-control" type="number" placeholder="29845283">
                    </div>
                    <div class="col">
                        <label for="rol_inscrito_1">Rol</label>
                        <select class="form-control" id="rol_inscrito_1">
                            <option>Novia</option>
                            <option>Novio</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label for="nombre_inscrito_2">Nombre y Apellido</label>
                        <input class="form-control" type="text" placeholder="Nombre y Apellido">
                    </div>
                    <div class="col">
                        <label for="cedula_inscrito_2">Cédula</label>
                        <input class="form-control" type="number" placeholder="29845283">
                    </div>
                    <div class="col">
                        <label for="rol_inscrito_2">Rol</label>
                        <select class="form-control" id="rol_inscrito_2">
                            <option>Novia</option>
                            <option>Novio</option>
                        </select>
                    </div>
                </div><br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
</body>

</html>