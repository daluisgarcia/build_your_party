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
        $statement = $this->con->prepare("SELECT id_producto as id, nombre_producto as nombre, precio_producto-(precio_producto*descuento_producto) as precio, descuento_producto as descuento FROM $this->products_table WHERE venta_ind_producto = 'SI' AND (fk_categoria = $id_category OR fk_categoria IN (SELECT id_categoria FROM CATEGORIA WHERE fk_categoria = $id_category));");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_services_by_category($id_category){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_servicio as id, nombre_servicio as nombre, precio_servicio-(precio_servicio*descuento_servicio) as precio, descuento_servicio as descuento, detalles_servicio as detalles, modalidad_pago_servicio as modalidad_pago, requiere_cita_servicio as cita FROM $this->services_table WHERE fk_categoria = $id_category OR fk_categoria IN (SELECT id_categoria FROM CATEGORIA WHERE fk_categoria = $id_category);");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

}