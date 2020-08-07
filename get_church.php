<?php   session_start();

//if(!isset($_SESSION["usuario"])){
//    header("Location: index.php");
//    die();
//}

error_reporting(0);	//EVITAR MUESTRA DE ERRORES
header('Content-type: application/json; charset=utf-8');    //ESTABLECE LA PAGINA COMO UN VISOR DE JSON

define('NO_CONTENT_FOUND', 'No se se han encontrado resultados.');

include 'config.php';

$id_lugar = isset($_GET['idlugar']) ? $_GET['idlugar'] : '';
$id_church = isset($_GET['idchurch']) ? $_GET['idchurch'] : '';
$answer = '';

if(!empty($id_lugar)){
    try {
        include_once 'model/MapSQL.php';
        $connect = new MapSQL();

        $id_lugar = SANITIZE_STRING(strtolower($id_lugar));
        $answer = $connect->get_chuchs_by_fk_for_courses($id_lugar);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }
}elseif (!empty($id_church)){
    try {
        include_once 'model/MapSQL.php';
        $connect = new MapSQL();

        $id_church = SANITIZE_STRING(strtolower($id_church));
        $answer = $connect->get_chuch_and_courses_info($id_church);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }
}else{
    $answer =  ['error' => NO_CONTENT_FOUND];
}

echo json_encode($answer);