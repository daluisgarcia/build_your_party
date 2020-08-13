<?php

include_once 'Connection.php';

class PaymentSQL extends Connection
{
    function __construct(){
        parent::__construct();
    }

    public function get_contract_payments($id_contract){
        $statement = $this->con->prepare("SELECT monto_pago as monto, fecha_realizacion_pago as fecha FROM PAGO WHERE fk_contrato=$id_contract");
        $statement->execute();
        return $statement->fetchAll();
    }
}