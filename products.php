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
    foreach ($array as $a){
        echo "<li>";
        echo "<a href='$a[$id]'>$a[$n]</a>";
        $result = search_category($a['id'], $array);
        if (!empty($result)){
            print_list($result);
        }
        echo '</li>';
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
        $not = 'No se han categorias, intentelo de nuevo.';
    }

}catch (PDOException $e){
    $not = 'No se han encontrado categorias, error al conectar con servidor.';
}

include "./view/products.view.php";

//require './view/footer.php';