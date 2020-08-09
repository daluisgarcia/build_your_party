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
        <div class="form-container-m">
            <div class="text-center">
                <h5>
                    Cuéntanos sobre tu fiesta/evento
                </h5>
                <i>(Si ya tienes un fiesta creada, puedes clickear en continuar)</i>
            </div>
            <br>
            <form id="party-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="party_type">Tipo de Fiesta</label>
                    <select class="form-control" id="party_type" name="party_type">
                        <?php foreach($types as $t): ?>
                            <option value="<?php echo $t['id'];?>"><?php echo $t['nombre'];?></option>
                        <?php endforeach; ?>
                        <option value="0">Otro</option>
                    </select><br>
                    <div class="form-group">
                        <label for="other-type">Otro</label>
                        <input type="text" class="form-control" id="other-type" name="other-type" placeholder="Especifique su Tipo de Fiesta">
                    </div>
                    <label for="party_topic">Tematica de la fiesta</label>
                    <select class="form-control" id="party_topic" name="party_topic">
                        <?php foreach($topics as $t): ?>
                            <option value="<?php echo $t['id'];?>"><?php echo $t['nombre'];?></option>
                        <?php endforeach; ?>
                    </select><br>
                    <div class="row">
                        <div class="col">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                        <div class="col">
                            <label for="cantidad_invitados">Cantidad de invitados</label>
                            <input id="cantidad_invitados" name="cantidad_invitados" class="form-control" type="number" value="1" min="1" max="10000" step="1"/>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <label for="time-begin">Hora Inicio</label>
                            <input type="time" class="form-control" id="time-begin" name="time-begin">
                        </div>
                        <div class="col">
                            <label for="time-end">Hora Final</label>
                            <input type="time" class="form-control" id="time-end" name="time-end">
                        </div>
                    </div><br>
                    <div class="row m-auto">
                        <div class="form-group mx-1">
                            <label for="estado-select" class="m-1 ml-2">Estado</label>
                            <select id="estado-select" class="form-control" onchange="selectMunicipio()">

                            </select>
                        </div>
                        <div class="form-group mx-1">
                            <label for="municipio-select" class="m-1 ml-2">Municipio</label>
                            <select id="municipio-select" class="form-control" onchange="selectParroquia()">

                            </select>
                        </div>
                        <div class="form-group mx-1">
                            <label for="parroquia-select" class="m-1 ml-2">Parroquia</label>
                            <select id="parroquia-select" name="parroquia-select" class="form-control">

                            </select>
                        </div>
                    </div><br>
                    <ul class="row">
                        <?php echo (isset($answer) and $answer!=='')? $answer : '' ;?>
                    </ul>
                    <div class="row">
                        <div class="text-left col">
                            <a href="index" class="btn btn-danger">Cancelar</a>
                        </div>
                        <div class="text-right col">
                            <button type="submit" class="btn btn-primary">Continuar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
    <script onload="selectDrops()" src="./js/map_AJAX.js"></script>
</body>

</html>