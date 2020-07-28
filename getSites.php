<?php

include 'config.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$table = isset($_GET['option']) ? $_GET['option'] : '';
$religion = isset($_GET['religion']) ? $_GET['religion'] : '';
$cityid = isset($_GET['cityid']) ? $_GET['cityid'] : '';
$answer = '';

if(!empty($id) and empty($tipo)){
    try {
        include_once 'model/MapSQL.php';
        $connect = new MapSQL();

        $id = SANITIZE_STRING(strtolower($id));
        $answer = $connect->get_sites_by_fk($id);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }
}elseif (empty($id) and !empty($tipo)){
    try {
        include_once 'model/MapSQL.php';
        $connect = new MapSQL();

        $tipo = SANITIZE_STRING(strtolower($tipo));
        $answer = $connect->get_sites_by_type($tipo);

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }
}else{
    if(!empty($table) and !empty($cityid)){
        try {
            include_once 'model/MapSQL.php';
            $connect = new MapSQL();

            $table = SANITIZE_STRING(strtolower($table));
            $cityid = SANITIZE_STRING(strtolower($cityid));
            $religion = SANITIZE_STRING(strtolower($religion));
            $answer = $connect->get_coordinates($table,$cityid,$religion);

        }catch (PDOException $e){
            $answer =  ['error' => NO_CONTENT_FOUND];
        }
    }elseif (!empty($religion) and $religion === 'all'){
        try {
            include_once 'model/MapSQL.php';
            $connect = new MapSQL();

            $religion = SANITIZE_STRING(strtolower($religion));
            $answer = $connect->get_religions();

        }catch (PDOException $e){
            $answer =  ['error' => NO_CONTENT_FOUND];
        }
    }else{
        $answer = ['error' => NO_CONTENT_FOUND];
    }
}

echo json_encode($answer);
