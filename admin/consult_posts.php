<?php session_start();

//VERIFICAR PERMISO DE ADMIN
//if(!isset($_SESSION["usuario"])){
//    header("Location: index.php");
//    die();
//}

include '../config.php';

//error_reporting(0);	//EVITAR MUESTRA DE ERRORES
//header('Content-type: application/json; charset=utf-8');    //ESTABLECE LA PAGINA COMO UN VISOR DE JSON

define('NO_CONTENT_FOUND', 'No se se han encontrado resultados.');

$option = isset($_GET['option']) ? $_GET['option'] : '';
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : '';
$imagen = isset($_GET['id_imagen']) ? $_GET['id_imagen'] : '';
$id = isset($_GET['id_post']) ? $_GET['id_post'] : '';
$seccion = isset($_GET['seccion']) ? $_GET['seccion'] : '';
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : '';
$cuerpo = isset($_GET['cuerpo']) ? $_GET['cuerpo'] : '';


$answer = '';

if ($option !== '') {
  $option = SANITIZE_STRING(strtolower($option));
}else{
  $answer = ['error' => NO_CONTENT_FOUND];
}

include_once '../model/AdminSQL.php';

if ($answer == '') {
  try {
    $connect = new AdminSQL();

    if($option === 'update') {
      $answer = $connect->update_post($id, $titulo, $seccion, $cuerpo, $imagen, $ruta);
    }elseif($option === 'delete'){
      $answer = $connect->delete_post($id);
    }else if($option === 'select'){
      $answer = $connect->get_posts();
    } else {
      $answer = $connect->add_post('', $seccion, $titulo, $cuerpo);
    }

  } catch (PDOException $e) {
    $answer = ['error' => 'Error al conectar a la base de datos'];
  }
}

echo json_encode($answer);
