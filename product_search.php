<?php   session_start();

//if(!isset($_SESSION["usuario"])){
//    header("Location: index.php");
//    die();
//}

include 'config.php';

error_reporting(0);	//EVITAR MUESTRA DE ERRORES
header('Content-type: application/json; charset=utf-8');    //ESTABLECE LA PAGINA COMO UN VISOR DE JSON

define('NO_CONTENT_FOUND', 'No se se han encontrado resultados.');

$category_id = $_GET['category'];
$answer = '';

if ($category_id !== '') {
    $category_id = SANITIZE_STRING(strtolower($category_id));
}else{
    $answer = ['error' => NO_CONTENT_FOUND];
}

include_once './model/Product.php';

if ($answer == '') {
    try {
        $connect = new Product();

        $products = $connect->get_products_by_category($category_id);
        $service = $connect->get_services_by_category($category_id);

        if (empty($products) or empty($service)) {
            $answer = ['error' => NO_CONTENT_FOUND];
        }else{
            foreach ($products as &$p){
                $arr = array('CLASE' => 'PRODUCTO');
                $p = $p + $arr;
            }
            foreach ($service as &$s) {
                $arr = array('CLASE' => 'SERVICIO');
                $s = $s + $arr;
                array_push($products, $s);
            }
        }

        $answer = $products;

    } catch (PDOException $e) {
        $answer = ['error' => 'Error al conectar a la base de datos'];
    }
}

echo json_encode($answer);
