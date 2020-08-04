<?php   session_start();

if(isset($_SESSION['user'])){
    header("Location: index.php");
    die();
}


//chequea que sea un request tipo post
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require 'config.php';

    $usuario = SANITIZE_STRING(strtolower($_POST['user']));
    $pass = $_POST['pass'];

    $error = '';

    if(empty($usuario)){
        $error .= '<li>Usuario no debe estar vacío</li>';
    }
    if(empty($pass)){
        $error .= '<li>contraseña no debe estar vacío</li>';
    }
    include_once './model/user.php';

    if($error == ''){
        try{

            $conexion = new user();
            $login = $conexion->get_user_data($usuario,$pass);

            if(empty($login)){
                $error .= '<li>Datos inválidos</li>';
            } else {
                $_SESSION['user'] = $login['id_usuario'];
                $_SESSION['user'] = $login['nombre_usuario'];
                header("Location: index.php");
                die();
            }

        } catch (PDOException $exc){
            $error .='<li>Error de conexión</li>';
        }
    }
}

include "view/login.view.php";