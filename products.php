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
    $id = 2;
    $products = $connect->get_products_by_category($id);

}catch (PDOException $e){
    $not = 'No se han encontrado categorias, error al conectar con servidor.';
}

include "./view/products.view.php";

//require './view/footer.php';