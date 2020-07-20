<?php   session_start();

//if(!isset($_SESSION["usuario"])){
//    header("Location: index.php");
//    die();
//}

function search_category($id, &$categories){
    $result = [];
    $i = -1;
    foreach ($categories as $category){
        $i++;
        if($category['fk'] == $id){
            array_push($result, $category);
            unset($categories[$i]);
        }
    }
    return $result;
}

function print_list($array){
    $id = 'id';
    $n = 'nombre';
    echo "<ul>";
    $size = sizeof($array);
    for ($i = 0; $i < $size; $i++){
        if (array_key_exists($i,$array)) {
            $a = $array[$i];
            echo "<li>";
            echo "<a href='$a[$id]'>$a[$n]</a>";
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

include_once 'model/Product.php';

$not = '';

try {
    $connect = new Product();

    $categories = $connect->get_categories();
    if (empty($categories)) {
        $not = 'ERROR';
    }
    $id = 1;
    $products = $connect->get_products_by_category($id);
    //var_dump($products);
    $service = $connect->get_services_by_category($id);
    //var_dump($service);

    if (empty($products) or empty($service)) {
        $not = 'ERROR';
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