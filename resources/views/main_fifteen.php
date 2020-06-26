<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .header-img{
            background-image: url("https://img2.goodfon.com/wallpaper/nbig/8/91/party-smoke-electronica.jpg");
            background-repeat: no-repeat;
            background-position-y: bottom;
            background-size: 100%;
            height: 20rem;
        }
        .right-border-button{
            background-color: white;
            margin: 0px 0px 0px 0px;
            border-right: 2px solid;
            border-bottom: 0px;
            border-top: 0px;
            border-left: 0px;
        }

        .plain-button {
            background-color: white;
            border-right: 0px;
            border-bottom: 0px;
            border-top: 0px;
            border-left: 0px;
        }
    </style>
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

<?php
require 'navbar_quinces.php';
?>
<br>
<br>

<div class="header-img">

</div>

<br>

<div class="col-12 align-self-center">
    <p class="display-6 text-dark bg-white text-justify ml-3 mr-3">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae porta arcu. Quisque tempor dictum mattis. Phasellus pretium dui a mauris ultrices mollis egestas sed ex. Aenean non orci placerat, euismod metus congue, ultrices diam. Nam aliquam lorem sit amet nisi ultricies, sit amet cursus dui sodales. Ut at ante arcu. Curabitur imperdiet accumsan ante quis vehicula. Praesent nibh diam, venenatis quis commodo ut, sagittis ut libero. Etiam hendrerit neque justo, eget mattis ante pellentesque ut. Proin vulputate aliquam iaculis. Etiam luctus arcu tellus, id convallis risus convallis in. Phasellus at rhoncus tortor. Nulla facilisi. Suspendisse tempor, leo sed sodales pharetra, tellus augue euismod sapien, vitae placerat velit mauris eu ipsum. Duis ut mauris eu enim gravida eleifend. Maecenas consectetur eros et mi accumsan, et eleifend enim aliquet.

        Quisque placerat nunc gravida eros euismod posuere. Nulla tempus sapien ex, vel dapibus quam pellentesque quis. Nulla facilisi. Quisque pretium condimentum nibh sollicitudin convallis. Morbi non tristique lectus. Nunc ut lectus ut velit vehicula auctor id vel est. Nam maximus lobortis massa, sed ullamcorper purus elementum vitae. Vestibulum nec eros elit.
        </p>
    <p class="display-6 text-dark bg-white text-justify ml-3 mr-3">
        Maecenas ac ligula non ante condimentum bibendum. Vestibulum malesuada diam a odio ullamcorper gravida. Suspendisse consectetur mi in leo ullamcorper egestas. Donec ac tellus sed metus commodo suscipit a ut metus. Praesent at nulla dui. Suspendisse id ipsum ac massa aliquet suscipit nec eget turpis. Aenean luctus risus non purus blandit, at lobortis mi bibendum. Phasellus blandit mi lectus, sit amet tincidunt ex aliquet quis. Donec consectetur metus at sollicitudin mattis. Phasellus in ullamcorper libero, ac dapibus augue.
    </p>
    <p class="display-6 text-dark bg-white text-justify ml-3 mr-3">
        Sed convallis sapien eros, vel laoreet nisi dignissim a. Nulla facilisi. Quisque ut nunc facilisis, luctus tellus convallis, vulputate libero. Suspendisse auctor tellus ac urna porttitor, id scelerisque massa maximus. Donec sodales auctor dolor, at condimentum mauris fringilla id.

        Curabitur vehicula libero mauris, nec tempus orci mattis non. Ut purus nisi, facilisis in pulvinar ac, iaculis vitae leo. Maecenas in sem id tellus sagittis aliquet eu ut felis. Mauris placerat diam nec eros fringilla, vel porta est tempus. Phasellus commodo mollis odio id bibendum. Morbi sit amet enim id mauris facilisis euismod. Donec suscipit cursus purus, sed aliquet tellus finibus ac. Cras scelerisque magna erat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed a gravida turpis. Nulla aliquam molestie eros, non consectetur nisi consectetur sed.
    </p>
</div>

<div class="contenedor-carrusel">
    <div class="imagen-carrusel actual-carrusel">
        <img src="https://i.pinimg.com/originals/75/2d/54/752d5460f7e2544423199d8d3b693f5e.jpg" />
    </div>

    <div class="imagen-carrusel">
        <img src="https://www.blogchulisimo.com/wp-content/uploads/2020/03/architecture-auditorium-blue-bright-colours-382297-1140x855.jpg" />
    </div>

    <div class="imagen-carrusel">
        <img src="https://comoorganizarlacasa.com/wp-content/uploads/2018/10/programa-para-15-anos.jpg" />
    </div>

    <div class="imagen-carrusel">
        <img src="https://4.bp.blogspot.com/_gLg3CroY0w8/TEL9n5dE2GI/AAAAAAAAAH0/GOa59p1_KrU/s1600/15+años+046.jpg" />
    </div>


    <div class="puntos-carrusel">
        <span class="punto-carrusel activo-carrusel" onclick="mostrar(0);"></span>
        <span class="punto-carrusel" onclick="mostrar(1);"></span>
        <span class="punto-carrusel" onclick="mostrar(2);"></span>
        <span class="punto-carrusel" onclick="mostrar(3);"></span>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="../../public/js/bootstrap.min.js"></script>
</body>
</html>
