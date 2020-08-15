<?php   session_start();

if(!isset($_SESSION["user"])){
    header("Location: index.php");
    die();
}

function get_total_price($budget_details){
    $sum = 0;
    foreach ($budget_details as $detail){
        $sum += intval($detail[0]['precio_total']);
    }
    return $sum;
}

function get_details($id_reg, &$details){
    $array = [];
    foreach ($details as $d){
        if($d['id_reg'] === $id_reg){
            array_push($array,$d);
            unset($details[array_search($d, $details)]);
        }
    }
    return $array;
}

$id_budget = isset($_GET['idBudget']) ? $_GET['idBudget'] : '';

$contracts = [];

try {
    include_once 'model/PartySQL.php';
    $connect = new PartySQL();

    $budget_details = [];
    //SE VALIDA QUE NO EXISTA UN CONTRATO PARA ESE PRESUPUESTO
    if(!empty($id_budget) and empty($connect->get_contract($id_budget))) {
        //NO EXISTE CONTRATO, ENTONCES SE CREA
        array_push($budget_details, $connect->get_budget_details($id_budget));
        $size = sizeof($budget_details);
        $ordered = [];
        //SE ITERA SOBRE LOS DETALLES DE CADA PRESUPUESTO
        for ($i = 0; $i < $size; $i++) {
            $a = $budget_details[$i];
            $size2 = sizeof($a);
            $array = [];
            //ITERA SOBRE LOS DETALLES DE UN PRESUPUESTO Y LOS SEPARA POR CODIGO DE REGISTRO
            for ($j = 0; $j < $size2; $j++) {
                if (array_key_exists($j, $a)) {
                    $b = $a[$j];
                    $array = $array + [$b['id_reg'] => get_details($b['id_reg'], $a)];
                }
            }
            array_push($ordered, $array);
        }
        $budget_details = $ordered;
        unset($ordered);
        $price = get_total_price($budget_details[0]);
        //SE INSERTA EL CONTRATO CON EL PRECIO TOTAL CALCULADO
        $connect->add_new_contract($_SESSION['id_user'], $id_budget, $price);
    }

    $contracts = $connect->get_user_contracts($_SESSION['id_user']);

    $courses = $connect->get_courses_by_user($_SESSION['id_user']);

}catch (PDOException $e){
    $answer =  ['error' => NO_CONTENT_FOUND];
}


require './view/contracts.view.php';
