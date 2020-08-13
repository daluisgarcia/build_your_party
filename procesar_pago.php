
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
    <form class="form-group">
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                    Default radio
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    Second default radio
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
                <label class="form-check-label" for="exampleRadios3">
                    Disabled radio
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Numero de tarjeta</label>
            <input class="form-control " type="text" placeholder="#">
        </div>
        <div class="form-group">
            <label class="form-label">Fecha de vencimiento</label>
            <input class="form-control " type="date" placeholder="#">
        </div>
        <div class="form-group">
            <label class="form-label">Fecha de vencimiento</label>
            <input class="form-control " type="date" placeholder="#">
        </div>
        <div class="row">
            <div class="col-md-6 text-center">
                <button type="button" class="btn btn-primary">Volver</button>
            </div>
            <div class="col-md-6 text-center">
                <button type="button" class="btn btn-primary">Pagar</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
