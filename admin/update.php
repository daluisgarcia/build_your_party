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
$id = isset($_GET['id']) ? $_GET['id'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$fklugar = isset($_GET['fklugar']) ? $_GET['fklugar'] : '';
$coordID = isset($_GET['coordID']) ? $_GET['coordID'] : '';
$latitud = isset($_GET['latitud']) ? $_GET['latitud'] : '';
$longitud = isset($_GET['longitud']) ? $_GET['longitud'] : '';
$personID = isset($_GET['personid']) ? $_GET['personid'] : '';
$personname1 = isset($_GET['personname1']) ? $_GET['personname1'] : '';
$personname2 = isset($_GET['personname2']) ? $_GET['personname2'] : '';

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
      $answer1 = $connect->update_notary($id, $name, $fklugar);
      $answer2 = $connect->update_coordinates($coordID, $latitud, $longitud);
      $answer3 = $connect->update_person($personID, $personname1, $personname2);
      $answer = [$answer1, $answer2, $answer3];

    }elseif($option === 'delete'){
      $answer = $connect->delete_notary($id, $coordID, $personID);
    }else{
      $answer = $connect->add_notary('Notaria de mierda', 484, 27880895, 9.99, -70.20, 0212, 5455995);
    }

  } catch (PDOException $e) {
    $answer = ['error' => 'Error al conectar a la base de datos'];
  }
}

echo json_encode($answer);
