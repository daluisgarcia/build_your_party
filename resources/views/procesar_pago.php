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

<section class="container-fluid">
    <section class="row justify-content-md-center">
        <section class="col-12 col-md-4">
            <form class="form-container">
                <div></div>
            </form>
        </section>
    </section>
</section>

<div>
    <div class="text-left">
        <div>
            <p>
                Tipo de pago
            </p>
            <div class="form-check ">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">Visa</label>
            </div>
        </div>
        <div class="form-check ">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
            <label class="form-check-label" for="inlineRadio2">Mastercard</label>
        </div>
    </div>
</div>
</body>
</html>
