<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Bodas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/carrusel.js"></script>
	<?php
		include_once 'model/tips.php';
		$connect = new PostManagement();
  		$posts = $connect->get_post("XV");
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

</div>
</body>
</html>