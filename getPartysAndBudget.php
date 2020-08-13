<?php   session_start();

if(!isset($_SESSION["user"])){
    header("Location: index.php");
    die();
}

error_reporting(0);	//EVITAR MUESTRA DE ERRORES
header('Content-type: application/json; charset=utf-8');    //ESTABLECE LA PAGINA COMO UN VISOR DE JSON

define('NO_CONTENT_FOUND', 'No se se han encontrado resultados.');

include 'config.php';

$id_fiesta = isset($_GET['idfiesta']) ? $_GET['idfiesta'] : '';
$option = isset($_GET['option']) ? $_GET['option'] : '';
$product_price = isset($_GET['productprice']) ? $_GET['productprice'] : 0;
$product_quantity = isset($_GET['productquantity']) ? $_GET['productquantity'] : 0;
$product_id = isset($_GET['productid']) ? $_GET['productid'] : null;
$budget_id = isset($_GET['idbudget']) ? $_GET['idbudget'] : null;
$service_id = isset($_GET['serviceid']) ? $_GET['serviceid'] : '';
$service_price = isset($_GET['serviceprice']) ? $_GET['serviceprice'] : '';
$service_hours = isset($_GET['servicehours']) ? $_GET['servicehours'] : '';
$reg_id = isset($_GET['regid']) ? $_GET['regid'] : '';

$answer = '';

if($option === 'getPartys'){
    try {
        //SECCION PARA OBTENER FIESTAS DE UN USUARIO
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        //EN ESTE CASO SE PODRIA VALIDAR SI NO EXISTE EL ID SE REDIRIJA A OTRA PAGINA
        $answer = $connect->get_users_partys($_SESSION["id_user"]);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }
}else if($option === 'getBudgets') {
    try {
        //SECCION PARA OBTENER PRESUPUESTOS DE UNA FIESTA
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        $id_fiesta = SANITIZE_STRING(strtolower($id_fiesta));
        $answer = $connect->get_partys_budgets($id_fiesta);

    } catch (PDOException $e) {
        $answer = ['error' => NO_CONTENT_FOUND];
    }
}else if ($option === 'addBudget'){
    try {
        //SECCION PARA AÑADIR UN PRESUPUESTO NUEVO
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        //EN ESTE CASO SE PODRIA VALIDAR SI NO EXISTE EL ID SE REDIRIJA A OTRA PAGINA
        $answer = $connect->add_new_budget($id_fiesta);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }
}else if($option === 'addProductNoService'){

    try {
        //SECCION PARA AÑADIR UN PRODUCTO SOLO
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        //EN ESTE CASO SE PODRIA VALIDAR SI NO EXISTE EL ID SE REDIRIJA A OTRA PAGINA
        $answer = $connect->add_product_to_budget($product_price, $product_quantity, $budget_id, $product_id);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }

}else if($option === 'addServiceByHour'){

    try {
        //SECCION PARA AÑADIR UN SERVICIO EN MODALIDAD POR HORAS
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        //EN ESTE CASO SE PODRIA VALIDAR SI NO EXISTE EL ID SE REDIRIJA A OTRA PAGINA
        $answer = $connect->add_service_to_budget($service_price,$service_hours,$budget_id, $service_id);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }

}else if($option === 'addService'){

    try {
        //SECCION PARA AÑADIR UN SERVICIO
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        $service_price = $product_price+$service_price;

        //EN ESTE CASO SE PODRIA VALIDAR SI NO EXISTE EL ID SE REDIRIJA A OTRA PAGINA
        $answer = $connect->add_service_to_budget($service_price,1,$budget_id, $service_id);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }

}else if($option === 'addServicesProduct'){

    try {
        //SECCION PARA AÑADIR UN PRODUCTO DE UN SERVICIO
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        //EN ESTE CASO SE PODRIA VALIDAR SI NO EXISTE EL ID SE REDIRIJA A OTRA PAGINA
        $answer = $connect->add_products_to_service($product_id, $product_quantity, $reg_id);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }

}

echo json_encode($answer);