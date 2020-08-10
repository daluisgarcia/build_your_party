<?php

include_once 'Connection.php';

class PartySQL extends Connection
{
    function __construct(){
        parent::__construct();
    }

    public function get_users_partys($user_id){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_fiesta as id, fecha_realizacion_fiesta as fecha FROM FIESTA WHERE fk_usuario=$user_id;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public  function get_partys_budgets($party_id){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_presupuesto as id, fecha_presupuesto as fecha FROM PRESUPUESTO WHERE fk_fiesta=$party_id;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_party_types(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_tipo_fiesta as id, nombre_tipo_fiesta as nombre FROM TIPO_FIESTA;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_topics(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_tematica as id, nombre_tematica as nombre FROM TEMATICA;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function add_new_party($type, $inv_quantity, $time_begin, $time_end, $date, $topic, $site, $id_user){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("INSERT INTO FIESTA (fecha_realizacion_fiesta, hora_inicio_fiesta, hora_final_fiesta, cantidad_invitados_fiesta, fk_lugar, fk_tipo_fiesta, fk_tematica, fk_usuario) VALUES ('$date', '$time_begin', '$time_end', $inv_quantity, $site, $type, $topic, $id_user); ");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function add_new_budget($id_fiesta){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("INSERT INTO PRESUPUESTO (fk_fiesta, fecha_presupuesto) VALUES ($id_fiesta, curdate());");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function add_product_to_budget($product_price, $prodcuts_quantity, $budget, $product){
        //PREPARACION DEL QUERY
        $product_price = ($product_price*$prodcuts_quantity);
        $statement = $this->con->prepare("INSERT INTO SERVICIO_PRESUPUESTO (precio_total_servicio_presupuesto, cantidad_servicio_presupuesto, detalles_servicio_presupuesto, fk_presupuesto, fk_servicio) VALUES ($product_price,0,null,$budget,null);");
        //EJECUCION DEL QUERY
        $statement->execute();
        //SE CONSULTA LA BD PARA OBTENER EL ID DE LAS INSERCION
        $statement = $this->con->prepare("SELECT id_servicio_presupuesto FROM SERVICIO_PRESUPUESTO WHERE precio_total_servicio_presupuesto=$product_price AND cantidad_servicio_presupuesto=0 AND detalles_servicio_presupuesto IS NULL AND fk_presupuesto=$budget AND fk_servicio is null");
        $statement->execute();
        //SE TOMA EL ID DE LA CONSULTA
        $id = $statement->fetchAll()[0][0];
        $statement = $this->con->prepare("INSERT INTO PRODUCTO_PEDIDO (cantidad_producto_pedido, fk_producto, fk_servicio_presupuesto) VALUES ($prodcuts_quantity, $product, $id);");
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function add_service_to_budget($service_price, $service_hours, $budget, $service_id){
        $service_price = $service_price*$service_hours;
        $statement = $this->con->prepare("INSERT INTO SERVICIO_PRESUPUESTO (precio_total_servicio_presupuesto, cantidad_servicio_presupuesto, detalles_servicio_presupuesto, fk_presupuesto, fk_servicio) VALUES ($service_price,$service_hours,null,$budget,$service_id)");
        $statement->execute();
        $statement = $this->con->prepare("SELECT id_servicio_presupuesto FROM SERVICIO_PRESUPUESTO WHERE precio_total_servicio_presupuesto=$service_price AND cantidad_servicio_presupuesto=$service_hours AND detalles_servicio_presupuesto IS NULL AND fk_presupuesto=$budget AND fk_servicio=$service_id");
        $statement->execute();
        $id = $statement->fetchAll();
        $id = $id[sizeof($id)-1][0];
        return $id;
    }

    public function add_products_to_service($product_id, $product_quantity, $reg_id){
        $statement = $this->con->prepare("INSERT INTO PRODUCTO_PEDIDO (cantidad_producto_pedido, fk_producto, fk_servicio_presupuesto) VALUES ($product_quantity, $product_id, $reg_id);");
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }
}