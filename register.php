<?php   session_start();

if(isset($_SESSION['user'])){
    header("Location: index.php");
    die();
}


//chequea que sea un request tipo post
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require 'config.php';

    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $id = $_POST['id'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $usuario = SANITIZE_STRING($_POST['user']);
    $pass = $_POST['pass'];
    $pass_con = $_POST['pass_con'];

    $reg_error = '';

    if(empty($name)){
        $reg_error .= '<li>Nombre no debe estar vacío</li>';
    }
    if(empty($last_name)){
        $reg_error .= '<li>Apellido no debe estar vacío</li>';
    }
    if(empty($id)){
        $reg_error .= '<li>Cédula no debe estar vacío</li>';
    }
    if(empty($phone)){
        $reg_error .= '<li>Teléfono no debe estar vacío</li>';
    }
    if(empty($email)){
        $reg_error .= '<li>Correo no debe estar vacío</li>';
    }
    if(empty($usuario)){
        $reg_error .= '<li>Usuario no debe estar vacío</li>';
    }
    if(empty($pass)){
        $reg_error .= '<li>Contraseña no debe estar vacío</li>';
    }
    if(empty($pass_con)){
        $reg_error .= '<li>Repetir contraseña no debe estar vacío</li>';
    }

    if($pass != $pass_con){
        $reg_error .= '<li>Las contraseñas deben coincidir</li>';
    }


    include_once './model/register.php';

    if($reg_error == ''){
        try{
            $area_code = substr($phone, 0, 4);
            $number = substr($phone, 4);
            $conexion = new register();
            $register = $conexion->create_user($name, $last_name, $id, $area_code, $number, $email, $usuario, $pass);

            if(empty($register)){
                $reg_error .= '<li>Datos inválidos</li>';
            } else {
                $_SESSION['user'] = $register['id_usuario'];
                $_SESSION['user'] = $register['nombre_usuario'];
                header("Location: index.php");
                die();
            }

        } catch (PDOException $exc){
            $reg_error .='<li>Error de conexión</li>';
        }
    }
}
include "view/register.view.php";