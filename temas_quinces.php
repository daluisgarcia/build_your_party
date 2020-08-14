<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Tips Otras Fiestas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/carrusel.js"></script>
	<?php
		include_once 'model/tips.php';
		$connect = new PostManagement();
        $imagenes = $connect->get_galeria(8888);
	?>
	
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


	<h1>TEMAS DE QUINCE AÑOS</h1>
	<div class="header-img" style="background-image: url(https://organizadoradm.com/wp-content/uploads/2019/09/outdoors-3156323_1920-1024x683.jpg)"> </div>
<br><br><div>
<h5>LAS FIESTAS CON TEMAS MAS UNICOS QUE HEMOS REALIZADO:</h5></div><br>
	<div class="col-12 align-self-center">
		
    <div class="row ml-2 mr-2">
        
        <?php
        
		foreach ($imagenes as $imagen){

    
                echo ' <div class="col-lg-4 col-md-4 col-xs-4 thumb">
        <a class="thumbnail" href="#">
            <img class="theme_img" src='.$imagen['imagen'].' ">
        </a>
    </div>';
        }
		
		?>
     </div>
			
	</div>       

</body>
</html>
