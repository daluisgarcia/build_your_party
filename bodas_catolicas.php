<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Tips para Bodas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/carrusel.js"></script>
	<?php
		include_once 'model/tips.php';
		$connect = new PostManagement();
  		$posts = $connect->get_post_bodacat();
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
		require 'navbar_bodas.php';
            ?>
            <br>
            <br>
            <?php
		foreach ($posts as $post){
            echo '<h1>'.$post['titulo'].'</h1>';	
			if($post['imagen']!=null)
                echo '<div class="header-img" style="background-image: url('.$post['imagen'].')"> </div>';
			echo
			'<div class="col-12 align-self-center">
            <p class="display-6 text-dark bg-white text-justify ml-3 mr-3">
            '.$post['cuerpo'].'
            </p>
            </div>  <br><hr>';
            
		}
		    ?>
			
<div class="row">

    <div class="contenedor-carrusel col-md-4">
        <div class="imagen-carrusel actual-carrusel">
            <img src="https://www.venezuelatuya.com/caracas/iglesias/santa_capilla_gde.jpg" />
        </div>

        <div class="imagen-carrusel">
            <img src="https://www.venezuelatuya.com/caracas/iglesias/catedral_de_caracas_gde.jpg" />
        </div>

        <div class="imagen-carrusel">
            <img src="https://guiaccs.com/wp-content/uploads/2017/08/Iglesia-de-Altagracia_DDN-2-DESTACADA.jpg" />
        </div>

        <div class="imagen-carrusel">
            <img src="https://imgs-akamai.mnstatic.com/b6/c2/b6c2dacf7456bf4d1a77e06c2d1474a4.jpg" />
        </div>

        <div class="imagen-carrusel">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/La_Candelaria_Church.jpg/1200px-La_Candelaria_Church.jpg" />
        </div>

        <div class="imagen-carrusel">
            <img src="https://4.bp.blogspot.com/-JshDvE3upUo/TaeiPo3EgtI/AAAAAAAAADQ/NisVDhm5cYk/s1600/IMG_5135.JPG" />
        </div>


        <div class="puntos-carrusel">
            <span class="punto-carrusel activo-carrusel" onclick="mostrar(0);"></span>
            <span class="punto-carrusel" onclick="mostrar(1);"></span>
            <span class="punto-carrusel" onclick="mostrar(2);"></span>
            <span class="punto-carrusel" onclick="mostrar(3);"></span>
            <span class="punto-carrusel" onclick="mostrar(4);"></span>
            <span class="punto-carrusel" onclick="mostrar(5);"></span>
        </div>

    </div>
</div>
<br>
<div class="col text-center">
    <button type="button" class="btn  btn-info btn-lg">Reserva tu templo</button>
</div>
<br>
</body>
</html>
