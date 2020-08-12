<?php   session_start();

if(!isset($_SESSION["user"])){
    header("Location: index.php");
    die();
}

function search_category($id, &$categories){
    $result = [];
    foreach ($categories as $category){
        if($category['fk'] == $id){
            array_push($result, $category);
            unset($categories[array_search($category, $categories)]);
        }
    }
    return $result;
}

function print_list($array){
    $id = 'id';
    $n = 'nombre';
    $clase = 'CLASE';
    echo "<ul>";
    $size = sizeof($array);
    for ($i = 0; $i < $size; $i++){
        if (array_key_exists($i,$array)) {
            $a = $array[$i];
            echo "<li>";
            echo "<div id='$a[$id]' href='#' class='category text-shadow'>$a[$n]</div>";
            $result = search_category($a['id'], $array);
            if (!empty($result)) {
                print_list($result);
            }
            $size = sizeof($array);
            echo '</li>';
        }
    }
    echo "</ul>";
}

require 'navbar.php';

include 'config.php';

try {
    //SECCION PARA OBTENER FIESTAS DE UN USUARIO
    include_once 'model/PartySQL.php';
    $connect = new PartySQL();

    //EN ESTE CASO SE PODRIA VALIDAR SI NO EXISTE EL ID SE REDIRIJA A OTRA PAGINA
    $answer = $connect->get_users_partys($_SESSION["id_user"]);

    if(sizeof($answer)===0){
        header("Location: party_select.php");
        die();
    }

}catch (PDOException $e){
    header("Location: index.php");
    die();
}

include_once 'model/Product.php';

$not = '';
$products = '';

try {
    $connect = new Product();

    $categories = $connect->get_categories();
    if (empty($categories)) {
        $not = 'ERROR';
    }
    //$products = $connect->get_products_by_category(0);
    //$service = $connect->get_services_by_category(0);

    if (empty($products) or empty($service)) {
        $not .= 'ERROR';
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
}catch (PDOException $e){
    $not = 'No se han encontrado categorias, error al conectar con servidor.';
}

include "./view/products.view.php";

//require './view/footer.php';