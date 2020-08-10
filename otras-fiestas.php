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
  		$posts = $connect->get_post_otro();
	?>
	
</head>
<body>

<?php
		require 'navbar.php';
	?>

	<br>
	<br>
	<br>



	<h1>Tips para tus super fiestas</h1>
	<div class="header-img" style="background-image: url(https://tendenciasrd.com/wp-content/uploads/2020/03/BBVA-Boda-20012020-1024x576.jpg)"> </div>

	<div class="col-12 align-self-center">
		<p class="display-6 text-dark bg-white text-justify ml-3 mr-3">
		
		</p>
		<ol>
		<?php

		foreach ($posts as $post){
			echo '<li><span class="titulo-lista">'.$post['titulo'].'</span>
			<br><br>'.$post['cuerpo'].'<br><br>
            <div class="text-center">';
            if($post['imagen']!=null)
                echo '<img src='.$post['imagen'].' class="img-ventana-info">';
            echo
            '</div>
            <br><br></li>';
        }
		
		?>
			</ol>
			
	</div>


</div>

</body>
</html>
