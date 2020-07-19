<?php

include_once 'Connection.php';

class Product extends Connection
{

    private $products_table = 'PRODUCTO';
    private $categories_table = 'CATEGORIA';
    private $services_table = 'SERVICIO';

    function __construct(){
        parent::__construct();
    }

    public function get_categories(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_categoria as id, nombre_categoria as nombre, fk_categoria as fk FROM $this->categories_table");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_products_by_category($id_category){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_categoria as id, nombre_categoria as nombre, fk_categoria as fk FROM $this->categories_table");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }


}