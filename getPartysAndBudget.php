<?php   session_start();

//if(!isset($_SESSION["usuario"])){
//    header("Location: index.php");
//    die();
//}

error_reporting(0);	//EVITAR MUESTRA DE ERRORES
header('Content-type: application/json; charset=utf-8');    //ESTABLECE LA PAGINA COMO UN VISOR DE JSON

define('NO_CONTENT_FOUND', 'No se se han encontrado resultados.');

include 'config.php';

$id_fiesta = isset($_GET['idfiesta']) ? $_GET['idfiesta'] : '';

$answer = '';

if(empty($id_fiesta)){
    try {
        //SECCION PARA OBTENER FIESTAS DE UN USUARIO
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        //EN ESTE CASO SE PODRIA VALIDAR SI NO EXISTE EL ID SE REDIRIJA A OTRA PAGINA
        $answer = $connect->get_users_partys($_SESSION["id"]);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }
}else{
    try {
        //SECCION PARA OBTENER PRESUPUESTOS DE UNA FIESTA
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        $id_fiesta = SANITIZE_STRING(strtolower($id_fiesta));
        $answer = $connect->get_partys_budgets($id_fiesta);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }
}

echo json_encode($answer);