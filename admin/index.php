<?php session_start();

//VALIDAR TAMBIEN QUE EXISTA EL PERMISO DE ADMIN
//if(!isset($_SESSION["usuario"])){
//    header("Location: index.php");
//    die();
//}

require './view/index.view.php';
