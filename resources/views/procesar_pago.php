<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <script src="../../public/js/carrusel.js"></script>
</head>
<body>

<?php
require 'navbar.php';
?>
<br>
<br>
<br>
<h2 class="text-center">
    Procesar pago
</h2>
<br>
<br>
<div class="row">
    <div class="col-md-6 text-right">
        <p>
            Tipo de pago
        </p>
        <br>
        <p class="mt-3">
            Numero de tarjeta
        </p>
        <br>
        <p>
            Fecha de vencimiento
        </p>
        <br>
        <p>
            CSC
        </p>
    </div>
    <div class="col-md-3 text-left">
        <div class="form-check for">
            <input class="form-check-input mt-2" type="radio" name="visa_card" id="visa" value="visa">
            <label class="form-check-label ml-3" for="inlineRadio1">Visa</label>
            &nbsp
            &nbsp
            &nbsp
            &nbsp
            &nbsp
            &nbsp
            &nbsp
            &nbsp
            <img class="tab-icon" src="https://www.svgrepo.com/show/98426/visa-logo.svg" alt="icono de visa">
        </div>
        <div class="form-check ">
            <input class="form-check-input mt-2" type="radio" name="mastercard_card" id="mastercard" value="mastercard">
            <label class="form-check-label ml-3" for="mastercard">Mastercard</label>
            &nbsp
            &nbsp
            <img class="tab-icon" src="https://image.flaticon.com/icons/svg/38/38943.svg" alt="icono de visa">
        </div>
        <br>
        <div class="col-md-12 text-left">
            <input class="form-control " type="text" placeholder="#">
        </div>
        <br>
        <div class="col-md-8 text-left">
            <input class="form-control mt-1" type="date" placeholder="#">
        </div>
        <br>
        <div class="col-md-4 text-left">
            <input class="form-control " type="text" placeholder="#">
        </div>
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col-md-6 text-center">
        <button type="button" class="btn btn-primary">Volver</button>
    </div>
    <div class="col-md-6 text-center">
        <button type="button" class="btn btn-primary">Pagar</button>
    </div>
</div>
</body>
</html>
