<?php

include_once 'Connection.php';

class Product extends Connection
{

    private $products_table = 'PRODUCTO';
    private $categories_table = 'CATEGORIA';
    private $services_table = 'SERVICIO';
    private $image_table = 'IMAGEN';

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
        if($id_category === 0){
            $statement = $this->con->prepare("SELECT id_producto as id, nombre_producto as nombre,CASE WHEN D.porcentaje_descuento IS NULL THEN precio_producto WHEN D.porcentaje_descuento IS NOT NULL THEN precio_producto-(precio_producto*D.porcentaje_descuento/100) END as precio,D.porcentaje_descuento as descuento, I.ruta_imagen as imagen FROM PRODUCTO LEFT JOIN IMAGEN AS I ON I.fk_producto=id_producto LEFT JOIN DESCUENTO AS D ON id_producto=D.fk_producto WHERE venta_ind_producto = 'SI';");
        }else{
            $statement = $this->con->prepare("SELECT id_producto as id, nombre_producto as nombre,CASE WHEN D.porcentaje_descuento IS NULL THEN precio_producto WHEN D.porcentaje_descuento IS NOT NULL THEN precio_producto-(precio_producto*D.porcentaje_descuento/100) END as precio,D.porcentaje_descuento as descuento, I.ruta_imagen as imagen FROM PRODUCTO LEFT JOIN IMAGEN AS I ON I.fk_producto=id_producto LEFT JOIN DESCUENTO AS D ON id_producto=D.fk_producto WHERE venta_ind_producto = 'SI' AND (fk_categoria = $id_category OR fk_categoria IN (SELECT id_categoria FROM CATEGORIA WHERE fk_categoria = $id_category));");
        }
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_services_by_category($id_category){
        //PREPARACION DEL QUERY
        if($id_category === 0){
            $statement = $this->con->prepare("SELECT id_servicio as id, nombre_servicio as nombre, CASE WHEN D.porcentaje_descuento IS NULL THEN precio_servicio WHEN D.porcentaje_descuento IS NOT NULL THEN precio_servicio-(precio_servicio*D.porcentaje_descuento/100) END as precio, D.porcentaje_descuento as descuento, detalles_servicio as detalles, modalidad_pago_servicio as modalidad_pago, requiere_cita_servicio as cita, I.ruta_imagen as imagen FROM SERVICIO LEFT JOIN IMAGEN AS I ON I.fk_servicio=id_servicio LEFT JOIN DESCUENTO AS D ON D.fk_servicio=id_servicio");
        }else {
            $statement = $this->con->prepare("SELECT id_servicio as id, nombre_servicio as nombre, CASE WHEN D.porcentaje_descuento IS NULL THEN precio_servicio WHEN D.porcentaje_descuento IS NOT NULL THEN precio_servicio-(precio_servicio*D.porcentaje_descuento/100) END as precio, D.porcentaje_descuento as descuento, detalles_servicio as detalles, modalidad_pago_servicio as modalidad_pago, requiere_cita_servicio as cita, I.ruta_imagen as imagen FROM SERVICIO LEFT JOIN IMAGEN AS I ON I.fk_servicio=id_servicio LEFT JOIN DESCUENTO AS D ON D.fk_servicio=id_servicio WHERE fk_categoria = $id_category OR fk_categoria IN (SELECT id_categoria FROM CATEGORIA WHERE fk_categoria = $id_category);");
        }
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_products_by_service_id($id_service){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT p.id_producto as id_producto, p.nombre_producto as nombre_producto, p.precio_producto as precio_producto, t.cantidad_minima as cantidad_minima FROM PRODUCTO as p INNER JOIN PRODUCTO_SERVICIO as t ON p.id_producto=t.fk_producto WHERE t.fk_servicio=$id_service;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

}