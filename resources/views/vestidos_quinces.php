<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <script src="../../public/js/carrusel.js"></script>
    <style>
        img {
            max-width: 25rem;
            height: 18rem;
        }
    </style>
</head>
<body>

<?php
require 'navbar.php';
?>
<br>
<br>
<br>

<?php
require 'navbar_quinces.php';
?>
<br>
<br>
<br>

<h2 class="text-center">
    Brilla en tu gran día con el último grito de la moda
</h2>
<br>
<form class="ml-3">
    <div class="form-row align-items-center">
        <div class="col-auto my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                <option selected>Caracas</option>
                <option value="2">Valencia</option>
                <option value="3">Aragua</option>
            </select>
        </div>
        <div class="col-auto my-1 ml-2">
            <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="modistas_checkbox">
                <label class="custom-control-label" for="modistas_checkbox">Modistas</label>
            </div>
        </div>
        <div class="col-auto my-1 ml-2">
            <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="diseñadores_checkbox">
                <label class="custom-control-label" for="diseñadores_checkbox">Diseñadores</label>
            </div>
        </div>
        <div class="col-auto my-1 ml-2">
            <div class="custom-control custom-checkbox mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="costureras_checkbox">
                <label class="custom-control-label" for="costureras_checkbox">Costureras</label>
            </div>
        </div>
        <div class="col-sm-7 ml-2">
            <input class="form-control" type="text" placeholder="Buscar">
        </div>
    </div>
</form>
<br>
<br>
<div class="row">
    <div class="col-lg-4 col-md-4 col-xs-4 thumb ml-4">
        <a class="thumbnail" href="#">
            <img class="theme_img" src="https://www.latercera.com/resizer/82YKLqyp887B8VFEs8MZGh2HL9I=/900x600/smart/arc-anglerfish-arc2-prod-copesa.s3.amazonaws.com/public/BDZTFLTLB5FDJFW3OD2CI3VTQU.jpg">
        </a>
        <p class="text-center">
            Ozzy Osborne - Diseñador
        </p>
        <p class="text-left">
            Direccion: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            Contacto: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
        </p>
    </div>
    <div class="col-lg-7 col-md-7 ml-2">
        <div class="contenedor-carrusel">
            <div class="imagen-carrusel actual-carrusel">
                <img src="https://www.vanguardiaveracruz.mx/wp-content/uploads/2020/01/ESTADOS-UNIDOS-Ozzy.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img src="https://media.vogue.mx/photos/5e2f2ee76b988c0008c7f964/master/w_2632,c_limit/Osbourne--Grammy-2020-.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img src="https://townsquare.media/site/295/files/2019/03/ozzyGeezer.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img src="https://img.thedailybeast.com/image/upload/c_crop,d_placeholder_euli9k,h_1686,w_3000,x_0,y_0/dpr_1.5/c_limit,w_1600/fl_lossy,q_auto/v1588397111/200430-stern-ozzy-tease_b1wx4q" />
            </div>


            <div class="puntos-carrusel">
                <span class="punto-carrusel activo-carrusel" onclick="mostrar(0);"></span>
                <span class="punto-carrusel" onclick="mostrar(1);"></span>
                <span class="punto-carrusel" onclick="mostrar(2);"></span>
                <span class="punto-carrusel" onclick="mostrar(3);"></span>
            </div>
        </div>
        <div class="col text-center mt-4">
            <button type="button" class="btn  btn-info ">Resevar cita</button>
        </div>
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col-lg-4 col-md-4 col-xs-4 thumb ml-4">
        <a class="thumbnail" href="#">
            <img class="theme_img" src="https://rockandblog.net/wp-content/uploads/2019/11/judas-priest-rob-halford-1.jpg">
        </a>
        <p class="text-center">
            Rob Halford - Modista
        </p>
        <p class="text-left">
            Direccion: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            Contacto: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
        </p>
    </div>
    <div class="col-lg-7 col-md-7 ml-2">
        <div class="contenedor-carrusel">
            <div class="imagen-carrusel actual-carrusel">
                <img src="https://i.pinimg.com/originals/8f/02/ca/8f02caef344b4087f629a0e67adca5eb.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img src="https://i.pinimg.com/originals/64/fe/11/64fe11a394d91aca3eb8443095929cbd.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img src="https://townsquare.media/site/366/files/2019/11/judads-priest-singer-rob-halford-performs-during-firepower-2019-tour.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img src="https://www.rockalavena.cl/wp-content/uploads/2019/03/rob.jpg" />
            </div>


            <div class="puntos-carrusel">
                <span class="punto-carrusel activo-carrusel" onclick="mostrar(4);"></span>
                <span class="punto-carrusel" onclick="mostrar(5);"></span>
                <span class="punto-carrusel" onclick="mostrar(6);"></span>
                <span class="punto-carrusel" onclick="mostrar(7);"></span>
            </div>
        </div>
        <div class="col text-center mt-4">
            <button type="button" class="btn  btn-info ">Resevar cita</button>
        </div>
    </div>
</div>

</body>
</html>
