<?php  session_start();

if(!isset($_SESSION["user"])){
    header("Location: index.php");
    die();
}

//SE DESTRUYE/CIERRA LA SESION
session_destroy();
//LA VARIABLE GLOBAL SE COLOCA COMO UN ARRAY VACIO
$_SESSION = array();
//SE REDIRIJE AL INDEX
header("Location: index.php");
die();
