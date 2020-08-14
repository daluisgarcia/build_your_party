<?php   session_start();

if(!isset($_SESSION["user"])){
    header("Location: index.php");
    die();
}

$answer = '';
$error = '';

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        //SE PASAN PARAMTEROS DE OTRAS INTERFACES
        if(isset($_GET['idContract'])){
            $id_contract = $_GET['idContract'];
        }
        if(isset($_GET['idCourse'])){
            $id_course1 = $_GET['idCourse'];
        }
        if(isset($_GET['idTemplo'])){
            $id_course2 = $_GET['idTemplo'];
        }

        if(!empty($id_contract)){

            try {
                include_once 'model/PaymentSQL.php';
                $connect = new PaymentSQL();
                include_once  'model/PartySQL.php';
                $conn = new PartySQL();

                //OBTENER LA SUMATORIA DE TODAS LOS PAGOS
                $payments = $connect->get_sum_contract_payments($id_contract);
                $total = $conn->get_contract_price($id_contract);

                if($payments !== null){
                    $total = floatval($total)-floatval($payments);
                }

                if($payments === 0 or $total === 0){
                    $error = '<li>Error al obtener el monto a pagar</li>';
                }
            }catch (PDOException $e){
                $error = '<li>Error al conectar con la base de datos</li>';
            }

        }elseif (empty($id_course1) or empty($id_course2)){
            header("Location: products.php");
            die();
        }
        break;
    case 'POST':
        //PETICION DEL FORMULARIO

        $metodo = isset($_POST['metodo']) ? $_POST['metodo'] : '';

        try {
            include_once 'model/PaymentSQL.php';
            $connect = new PaymentSQL();

            $contract = isset($_POST['contractToPay']) ? $_POST['contractToPay'] : '';
            $course1 = isset($_POST['courseToPay1']) ? $_POST['courseToPay1'] : '';
            $course2 = isset($_POST['courseToPay2']) ? $_POST['courseToPay2'] : '';

            $payments = $connect->get_contract_payments($contract);

            $tipo = '';
            $banco = '';
            $numero = '';
            $vencimiento = '';
            $cod_tarjeta = '';
            $count = isset($_POST['count']) ? $_POST['count'] : '';

            if($metodo === 'add'){
                //AGREGAR METODO DE PAGO
                $tipo = isset($_POST['metodo_pago']) ? $_POST['metodo_pago'] : '';
                $banco = isset($_POST['banco']) ? $_POST['banco'] : '';
                $numero = isset($_POST['numero']) ? $_POST['numero'] : '';
                $vencimiento = isset($_POST['fecha_ven']) ? $_POST['fecha_ven'] : '';
                $cod_tarjeta = isset($_POST['codigo']) ? $_POST['codigo'] : '';

                $metodo = $connect->add_payment_method($tipo,$numero,$vencimiento,$banco,$_SESSION['id_user']);
            }

            //REGISTRAR PAGO
            if(!empty($contract)){
                //REGISTRAR PAGO PARA CONTRATO
                $connect->add_contract_payment($contract, $count, $metodo);
                header("Location: products.php");
                die();
            }elseif (!empty($course1) and !empty($course2)){
                //REGISTRAR PAGO PARA CURSO
                $connect->add_course_payment($course1, $course2, $count, $metodo, $_SESSION['id_user']);
                header("Location: products.php");
                die();
            }

        }catch (PDOException $e){
            $error =  '<li>Error al conectar con la base de datos</li>';
        }

        break;
    default:
        header("Location: products.php");
        die();
}

$pay_methods = [];

try {
    include_once 'model/PaymentSQL.php';
    $connect = new PaymentSQL();

    //OBETENER METODOS DE PAGO PARA UN USUARIO
    $pay_methods = $connect->get_user_pay_methods($_SESSION['id_user']);
}catch (PDOException $e){
    $error = '<li>Error al conectar con la base de datos</li>';
}

require './view/procesar_pago.view.php';