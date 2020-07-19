<?php

include_once 'Connection.php';

class user
{
    private $products_table = 'PRODUCTO';
    private $categories_table = 'CATEGORIA';
    private $services_table = 'SERVICIO';

    function __construct(){
        parent::__construct();
    }

    public function check_user_data($username, $password){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_usuario as id, passw_usuario as password FROM USUARIO WHERE id_usuario = $username AND passw_usuario = $password");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }
}