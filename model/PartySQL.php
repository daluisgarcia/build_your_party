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

    public function get_party_by_id($id){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT nombre_tipo_fiesta as nombre, fecha_realizacion_fiesta as fecha FROM FIESTA INNER JOIN TIPO_FIESTA ON fk_tipo_fiesta=id_tipo_fiesta WHERE id_fiesta=$id;");
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

    public function get_budget_details($id_budget){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT SP.id_servicio_presupuesto as id_reg,SP.precio_total_servicio_presupuesto as precio_total,SP.cantidad_servicio_presupuesto as cantidad_horas,SP.fk_servicio as id_servicio,S.nombre_servicio as nombre_servicio,CASE WHEN D1.porcentaje_descuento IS NULL THEN S.precio_servicio WHEN D1.porcentaje_descuento IS NOT NULL THEN S.precio_servicio-(S.precio_servicio*D1.porcentaje_descuento/100) END as precio_servicio,D1.porcentaje_descuento as descuento_servicio, S.modalidad_pago_servicio as modalidad,PP.fk_producto as id_producto,PP.cantidad_producto_pedido as cantidad_producto,P.nombre_producto as nombre_producto,CASE WHEN D.porcentaje_descuento IS NULL THEN P.precio_producto WHEN D.porcentaje_descuento IS NOT NULL THEN P.precio_producto-(P.precio_producto*D.porcentaje_descuento/100) END as precio_producto,D.porcentaje_descuento as descuento_producto FROM SERVICIO_PRESUPUESTO AS SP LEFT JOIN SERVICIO AS S ON SP.fk_servicio=S.id_servicio LEFT JOIN PRODUCTO_PEDIDO AS PP ON SP.id_servicio_presupuesto=PP.fk_servicio_presupuesto LEFT JOIN PRODUCTO AS P ON PP.fk_producto=P.id_producto LEFT JOIN DESCUENTO AS D ON D.fk_producto=P.id_producto LEFT JOIN DESCUENTO AS D1 ON D.fk_servicio=S.id_servicio WHERE SP.fk_presupuesto=$id_budget;");
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
        $statement = $this->con->prepare("INSERT INTO PRESUPUESTO (fk_fiesta, fecha_presupuesto) VALUES ($id_fiesta, curdate());");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function add_product_to_budget($product_price, $prodcuts_quantity, $budget, $product){
        $product_price = ($product_price*$prodcuts_quantity);
        $statement = $this->con->prepare("INSERT INTO SERVICIO_PRESUPUESTO (precio_total_servicio_presupuesto, cantidad_servicio_presupuesto, detalles_servicio_presupuesto, fk_presupuesto, fk_servicio) VALUES ($product_price,0,null,$budget,null);");
        $statement->execute();
        //SE CONSULTA LA BD PARA OBTENER EL ID DE LAS INSERCION
        $statement = $this->con->prepare("SELECT id_servicio_presupuesto FROM SERVICIO_PRESUPUESTO WHERE precio_total_servicio_presupuesto=$product_price AND cantidad_servicio_presupuesto=0 AND detalles_servicio_presupuesto IS NULL AND fk_presupuesto=$budget AND fk_servicio is null");
        $statement->execute();
        //SE TOMA EL ID DE LA CONSULTA
        $id = $statement->fetchAll()[0][0];
        $statement = $this->con->prepare("INSERT INTO PRODUCTO_PEDIDO (cantidad_producto_pedido, fk_producto, fk_servicio_presupuesto) VALUES ($prodcuts_quantity, $product, $id);");
        $statement->execute();
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
        return $statement->fetchAll();
    }

    public function get_contracts($id_budget){
        $statement = $this->con->prepare("SELECT fecha_aprobado_contrato FROM CONTRATO WHERE fk_presupuesto=$id_budget;");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function get_user_contracts($id_user){
        $statement = $this->con->prepare("SELECT id_contrato as id, fecha_aprobado_contrato as fecha_aprobado, fecha_pagado_contrato as pagado, monto_total_contrato as monto FROM CONTRATO WHERE fk_usuario=$id_user;");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function add_new_contract($id_user, $id_budget, $price){
        $statement = $this->con->prepare("INSERT INTO CONTRATO (fecha_aprobado_contrato, fecha_pagado_contrato, monto_total_contrato, fk_presupuesto, fk_usuario) VALUES (curdate(), null, $price, $id_budget, $id_user);");
        $statement->execute();
        return $statement->fetchAll();
    }
}