<?php

include_once 'Connection.php';

class user extends Connection
{
    function __construct(){
        parent::__construct();
    }

    public function get_user_data($username, $password){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT * FROM USUARIO WHERE nombre_usuario = $username AND passw_usuario = $password");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }
}