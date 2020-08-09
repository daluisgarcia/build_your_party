<?php   session_start();

if(!isset($_SESSION["user"])){
    header("Location: index.php");
    die();
}

include 'config.php';

error_reporting(0);	//EVITAR MUESTRA DE ERRORES
header('Content-type: application/json; charset=utf-8');    //ESTABLECE LA PAGINA COMO UN VISOR DE JSON

define('NO_CONTENT_FOUND', 'No se se han encontrado resultados.');

$category_id = isset($_GET['category']) ? $_GET['category'] : '';
$service_id = isset($_GET['serviceid']) ? $_GET['serviceid'] : '';
$answer = '';

if ($category_id !== '') {
    $category_id = SANITIZE_STRING(strtolower($category_id));
}elseif($service_id !== ''){
    $service_id = SANITIZE_STRING(strtolower($service_id));
}else{
    $answer = ['error' => NO_CONTENT_FOUND];
}

//SECCION PARA OBTENER FIESTAS DE UN USUARIO
include_once 'model/PartySQL.php';
$p_con = new PartySQL();
$r = $p_con->get_users_partys($_SESSION["id_user"]);

if(empty($r)){
    header("Location: party_select.php");
    die();
}

include_once './model/Product.php';

if ($answer == '') {
    try {
        $connect = new Product();
        if($category_id !== '') {

            $products = $connect->get_products_by_category($category_id);
            $service = $connect->get_services_by_category($category_id);

            foreach ($products as &$p) {
                $arr = array('CLASE' => 'PRODUCTO');
                $p = $p + $arr;
            }
            foreach ($service as &$s) {
                $arr = array('CLASE' => 'SERVICIO');
                $s = $s + $arr;
                array_push($products, $s);
            }

            $answer = $products;
        }elseif($service_id !== ''){
            $answer = $connect->get_products_by_service_id($service_id);
        }

    } catch (PDOException $e) {
        $answer = ['error' => 'Error al conectar a la base de datos'];
    }
}

echo json_encode($answer);
