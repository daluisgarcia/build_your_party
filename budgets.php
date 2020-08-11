<?php   session_start();

if(!isset($_SESSION["user"])){
    header("Location: index.php");
    die();
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

function get_total_price($budget_details){
    $sum = 0;
    foreach ($budget_details as $detail){
        $sum += intval($detail[0]['precio_total']);
    }
    return $sum;
}

$id_party = isset($_GET['idParty']) ? $_GET['idParty'] : '';
$party_info = [];
$budgets = [];
$budget_details = [];

if(!empty($id_party)){

    try {
        include_once 'model/PartySQL.php';
        $connect = new PartySQL();

        $party_info = $connect->get_party_by_id($id_party);
        $party_info = $party_info[0];
        $budgets = $connect->get_partys_budgets($id_party);
        foreach ($budgets as $bud){
            array_push($budget_details, $connect->get_budget_details($bud['id']));
        }
        $size = sizeof($budget_details);
        $ordered = [];
        //SE ITERA SOBRE LOS DETALLES DE CADA PRESUPUESTO
        for ($i = 0; $i < $size; $i++){
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

    }catch (PDOException $e){
        $answer =  ['error' => NO_CONTENT_FOUND];
    }

}else{
    header("Location: products.php");
    die();
}

require './view/budgets.view.php';
