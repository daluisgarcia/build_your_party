<?php   session_start();

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    die();
}

//VALIDAR SI EL USUARIO TIENE ALGUNA FIESTA, DE SER ASI DIRECCIONAR A PRODUCTOS

require './view/party_select.view.php';