<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Tips Quince años</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/carrusel.js"></script>
	<?php
		include_once 'model/tips.php';
		$connect = new PostManagement();
  		$posts = $connect->get_post('TIPXV');
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

	<h1>Tips para hacer de tus quince una noche mágica</h1>
	<div class="header-img" style="background-image: url(https://www.hoteldemexico.com/wp-content/uploads/2018/07/xv-1080x540.jpg)"> </div>

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
