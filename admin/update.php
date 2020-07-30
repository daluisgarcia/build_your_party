<?php session_start();

//VERIFICAR PERMISO DE ADMIN
//if(!isset($_SESSION["usuario"])){
//    header("Location: index.php");
//    die();
//}

include '../config.php';

error_reporting(0);	//EVITAR MUESTRA DE ERRORES
header('Content-type: application/json; charset=utf-8');    //ESTABLECE LA PAGINA COMO UN VISOR DE JSON

define('NO_CONTENT_FOUND', 'No se se han encontrado resultados.');

$option = isset($_GET['option']) ? $_GET['option'] : '';
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

    $notaries = $connect->get_notaries();

    if (empty($notaries)) {
      $answer = ['error' => NO_CONTENT_FOUND];
    }else{
      $answer = $notaries;
    }

  } catch (PDOException $e) {
    $answer = ['error' => 'Error al conectar a la base de datos'];
  }
}

echo json_encode($answer);

