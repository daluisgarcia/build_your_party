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
$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';
$correo = isset($_GET['correo']) ? $_GET['correo'] : '';
$codigo_de_area = isset($_GET['codigoarea']) ? $_GET['codigoarea'] : '';
$numero = isset($_GET['telefono']) ? $_GET['telefono'] : '';
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
$id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
$id_telefono = isset($_GET['id_telefono']) ? $_GET['id_telefono'] : '';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';
$municipio = isset($_GET['municipio']) ? $_GET['municipio'] : '';
$parroquia = isset($_GET['parroquia']) ? $_GET['parroquia'] : '';
$rol = isset($_GET['rol']) ? $_GET['rol'] : '';

$create = isset($_SESSION['Crear PERSONA']) ? $_SESSION['Crear PERSONA'] : 0 ;
$update = isset($_SESSION['Actualizar PERSONA']) ? $_SESSION['Actualizar PERSONA'] : 0 ;
$delete = isset($_SESSION['Eliminar PERSONA']) ? $_SESSION['Eliminar PERSONA'] : 0 ;
$deleteRU = isset($_SESSION['Eliminar ROL_USUARIO']) ? $_SESSION['Eliminar ROL_USUARIO'] : 0 ;
$createRU = isset($_SESSION['Crear ROL_USUARIO']) ? $_SESSION['Crear ROL_USUARIO'] : 0 ;

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

    if(($option === 'update') && ($update === 1)) {
      $answer1 = $connect->update_client($cedula, $nombre, $apellido, $correo, $codigo_de_area, $numero, $id_telefono, $usuario, $id_usuario, $parroquia);
    } else if(($option === 'delete') && ($delete === 1)){
      $answer = $connect->delete_client($cedula, $id_usuario);
    } else if($option === 'select'){
      $answer = $connect->get_users_and_persons();
    } else if ($option === 'myroles'){
      $answer = $connect->rolesForUser($id_usuario);
    }else if ($option === 'specific'){
      $answer = $connect->specificUser($id_usuario);
    }else if (($option === 'give') && ($createRU === 1)) {
      $answer = $connect->roleToUser($id_usuario, $rol);
    }else if (($option === 'take') && ($deleteRU === 1)) {
      $answer = $connect->takeRoleUser($id_usuario, $rol);
    } else if (($option === 'create') && ($create === 1)) {
      $answer = $connect->add_client($cedula, $nombre, $apellido, $correo, $codigo_de_area, $numero, $usuario, $parroquia);
    }

  } catch (PDOException $e) {
    $answer = ['error' => 'Error al conectar a la base de datos'];
  }
}

echo json_encode($answer);
