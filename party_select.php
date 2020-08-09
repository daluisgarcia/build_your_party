<?php   session_start();

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    die();
}

$types='';
$topics='';

require 'model/PartySQL.php';

try{
    $connect = new PartySQL();
    $types = $connect->get_party_types();
    $topics = $connect->get_topics();
}catch(Exception $e){
    $answer .= '<li>Error al obtener tipos de fiesta, intente de nuevo</li>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    require 'config.php';

    $answer = '';
    $type = SANITIZE_STRING($_POST['party_type']);
    $other_type = SANITIZE_STRING($_POST['other-type']);
    $inv_quantity = SANITIZE_STRING($_POST['cantidad_invitados']);
    $time_begin = SANITIZE_STRING($_POST['time-begin']);
    $time_end = SANITIZE_STRING($_POST['time-end']);
    $date = SANITIZE_STRING($_POST['fecha']);
    $topic = SANITIZE_STRING($_POST['party_topic']);
    $site = SANITIZE_STRING($_POST['parroquia-select']);

    if(empty($type) or empty($inv_quantity) or empty($time_begin) or empty($time_end) or empty($date) or empty($topic) or empty($site)){
        $partys = $connect->get_users_partys($_SESSION['id_user']);
        if(!empty($partys)){
            header("Location: products.php");
            die();
        }
        $answer .= '<li>Debe llenar los campos correspodientes</li>';
    }

    if ($answer === ''){
        try{
            $connect = new PartySQL();
            $connect->add_new_party($type,$inv_quantity,$time_begin,$time_end,$date,$topic, $site, $_SESSION['id_user']);
            header("Location: products.php");
            die();
        }catch(Exception $e){
            $answer.='<li>Error al conectar a la base de datos, intentelo mas tarde</li>';
        }
    }

}

require './view/party_select.view.php';