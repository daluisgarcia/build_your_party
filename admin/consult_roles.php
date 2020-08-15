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
$role = isset($_GET['rol']) ? $_GET['rol'] : '';
$permission = isset($_GET['permiso']) ? $_GET['permiso'] : '';
$id_role = isset($_GET['id_rol']) ? $_GET['id_rol'] : '';

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
      $answer = $connect->updateRole($id_role, $role);
    }else if($option === 'delete'){
      $answer = $connect->deleteRole($id_role);
    }else if($option === 'select'){
      $answer = $connect->getRoles();
    } else if($option === 'create') {
      $answer = $connect->createRole($role);
    } else if($option === 'permisos') {
      $answer = $connect->getPermissionsForRole($role);
    } else if($option === 'all-permisos') {
      $answer = $connect->getAllPermissions();
    } else if($option === 'all-roles') {
      $answer = $connect->getRoles();
    } else if ($option === 'associate') {
      $answer = $connect->associateRoleAndPermission($role, $permission);
    } else if ($option === 'unlink') {
      $answer = $connect->unlinkRoleAndPermission($role, $permission);
    }

  } catch (PDOException $e) {
    $answer = ['error' => 'Error al conectar a la base de datos'];
  }
}

echo json_encode($answer);
