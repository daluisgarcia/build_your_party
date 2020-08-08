<!DOCTYPE html>
<html lang="en">

<head>
    <style>

    </style>
    <meta charset="UTF-8">
    <title>Inscripción Curso Matrimonial</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
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
                    Cuéntanos sobre tu fiesta/evento
                </h5>
            </div>
            <br>
            <form>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Tipo de Fiesta</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>Matrimonio</option>
                        <option>XV Años</option>
                        <option>Cumpleaños Infantil</option>
                        <option>Cumpleaños Adulto</option>
                        <option>Despedida de Soltero</option>
                        <option>Fiesta de Divorcio</option>
                        <option>Otro</option>
                    </select><br>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Otro</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Especifique su Tipo de Fiesta">
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="exampleInputEmail1">Fecha</label>
                            <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese la fecha">
                        </div>
                        <div class="col">
                            <label for="exampleInputEmail1">Hora</label>
                            <input type="time" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese la fecha">
                        </div>
                    </div><br>
                    <label for="exampleInputEmail1">Descríbenos un poco más</label>
                    <textarea class="form-control" aria-label="With textarea"></textarea>
                    <br>
                    <div class="row">
                        <div class="text-left col">
                            <a href="index" class="btn btn-danger">Cancelar</a>
                        </div>
                        <div class="text-right col">
                            <a href="products" class="btn btn-primary">Continuar</a>
                        </div>
                    </div>
            </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
</body>

</html>