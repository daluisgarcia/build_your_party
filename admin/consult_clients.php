<?php session_start();

//VERIFICAR PERMISO DE ADMIN
//if(!isset($_SESSION["usuario"])){
//    header("Location: index.php");
//    die();
//}

include '../config.php';

//error_reporting(0);	//EVITAR MUESTRA DE ERRORES
header('Content-type: application/json; charset=utf-8');    //ESTABLECE LA PAGINA COMO UN VISOR DE JSON

define('NO_CONTENT_FOUND', 'No se se han encontrado resultados.');

$option = isset($_GET['option']) ? $_GET['option'] : '';
$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';
$correo = isset($_GET['correo']) ? $_GET['correo'] : '';
$codigo_de_area = isset($_GET['codigo_de_area']) ? $_GET['codigo_de_area'] : '';
$numero = isset($_GET['numero']) ? $_GET['numero'] : '';
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';
$municipio = isset($_GET['municipio']) ? $_GET['municipio'] : '';
$parroquia = isset($_GET['parroquia']) ? $_GET['parroquia'] : '';

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
      //$answer1 = $connect->update_notary($id, $name, $fklugar);
      //$answer2 = $connect->update_coordinates($coordID, $latitud, $longitud);
      //$answer3 = $connect->update_person($personID, $personname1, $personname2);
      //$answer = [$answer1, $answer2, $answer3];

    }elseif($option === 'delete'){
      //$answer = $connect->delete_notary($id, $coordID, $personID);
    }else if($option === 'select'){
      $answer = $connect->get_users_and_persons();
    }

  } catch (PDOException $e) {
    $answer = ['error' => 'Error al conectar a la base de datos'];
  }
}

echo json_encode($answer);
