<?php

include_once 'Connection.php';

class PartySQL extends Connection
{
    function __construct(){
        parent::__construct();
    }

    public function get_users_partys($user_id){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public  function get_partys_budgets($party_id){

    }
}