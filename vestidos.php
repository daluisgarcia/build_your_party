<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vestidos de Novia</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js\carrusel.js"></script>
    <?php
		include_once 'model/tips.php';
		$connect = new PostManagement();
        $disenadores = $connect->get_disenadores();
	?>
</head>
<body>

<?php
require 'navbar.php';
?>
<br>
<br>
<br>


<h2 class="text-center">
    Brilla en tu gran día con el último grito de la moda
</h2>
<br>
<br>
<?php
       $cont=-1;
		foreach ($disenadores as $disenador){
            echo '
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-xs-4 thumb ml-4">
                        <div class="thumbnail text-center" href="#">
                            <img class="theme_img imagen_disenador" src="'.$disenador['pfp'].'">
                        </div>
                        <p class="text-center">
                            '.$disenador['nombre'].' - '.$disenador['rol'].'
                        </p>
                        <p class="text-center">
                            Direccion: '.$disenador['lugar'].'
                            ';
                            if ($disenador['correo']!= 'null')
                            echo'<br>Correo: '.$disenador['correo'].'
                            ';
            $telefonos = $connect-> get_telefonos_persona($disenador['persona']);
            foreach ($telefonos as $telefono){
                echo '<br>Telefono: '.$telefono['telefono'].'';
            }
            echo'
                        </p>
                     </div>
            <div class="col-lg-7 col-md-7 ml-2">
                <div class="contenedor-carrusel">
                    ';
                    $trabajos = $connect-> get_trabajos_cyc($disenador['persona']);
                    $count2=0;
                    foreach ($trabajos as $trabajo){
                        $count2++;
                        echo '
                        <div class="imagen-carrusel">
                            <img class="imagen_disenador" src="'.$trabajo['imagen'].'" />
                            <div class="texto-carrusel">
                            '.$trabajo['nombre'].' en '.$trabajo['tela'].'. Se hace en '.$trabajo['tiempo'].' meses
                            </div>
                        </div>'
                       
                        ;
                    };
             
           if ($trabajos) {
            echo '<div class="puntos-carrusel">';
                for ($x=0; $x<$count2; $x++) {
                        echo '<span class="punto-carrusel activo-carrusel" onclick="mostrar('.(++$cont).');"></span>';
                };       
            echo  '</div>';
            
            echo' </div>';
        echo'  <div class="col text-center mt-4">
        <a href="products.php"> <button type="button" class="btn  btn-info ">
        Resevar cita
        </button>
        </a>
    </div>
        </div>
        </div>
        <hr>';  
    }
}    
    
?>

<!---
<br>
<br>
<div class="row">
    <div class="col-lg-4 col-md-4 col-xs-4 thumb ml-4">
        <a class="thumbnail" href="#">
            <img class="theme_img imagen_disenador" src="https://rockandblog.net/wp-content/uploads/2019/11/judas-priest-rob-halford-1.jpg">
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
                <img class="imagen_disenador" src="https://rockandblog.net/wp-content/uploads/2019/11/judas-priest-rob-halford-1.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img class="imagen_disenador" src="https://i.pinimg.com/originals/64/fe/11/64fe11a394d91aca3eb8443095929cbd.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img class="imagen_disenador" src="https://townsquare.media/site/366/files/2019/11/judads-priest-singer-rob-halford-performs-during-firepower-2019-tour.jpg" />
            </div>

            <div class="imagen-carrusel">
                <img class="imagen_disenador" src="https://www.rockalavena.cl/wp-content/uploads/2019/03/rob.jpg" />
            </div>


            <div class="puntos-carrusel">
                <span class="punto-carrusel activo-carrusel" onclick="mostrar(1);"></span>
                <span class="punto-carrusel" onclick="mostrar(2);"></span>
                <span class="punto-carrusel" onclick="mostrar(3);"></span>
                <span class="punto-carrusel" onclick="mostrar(4);"></span>
            </div>
        </div>
        <div class="col text-center mt-4">
            <button type="button" class="btn  btn-info ">Resevar cita</button>
        </div>
    </div>
</div>
    -->
</body>
</html>