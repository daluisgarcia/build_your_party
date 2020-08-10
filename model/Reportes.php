<?php


include_once 'Connection.php';

class ReportManagement extends Connection
{

    public function get_fiestas_por_mes(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("select count(*) as cantidad, month(fecha_realizacion_fiesta) as mes from (select fecha_realizacion_fiesta from fiesta where id_fiesta = ANY (SELECT fk_fiesta FROM presupuesto where id_presupuesto= ANY (select fk_presupuesto from contrato) ) )as party group by mes");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_terceros_segun_fecha($inicio,$fin){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("select id_servicio as id, fecha_aprobado_contrato_tercero as fecha_aprobado, precio_total_servicio_presupuesto as precio, nombre_servicio as servicio, fecha_realizacion_fiesta as fecha
        from contrato_tercero, servicio_presupuesto, servicio, presupuesto,fiesta, estado_contrato, contrato
        where fk_servicio_presupuesto=id_servicio_presupuesto
        and contrato.fk_presupuesto=id_presupuesto
        and servicio_presupuesto.fk_presupuesto=id_presupuesto
        and fk_servicio=id_servicio
        and fk_fiesta=id_fiesta
        and fk_estado=1
        and estado_contrato.fk_contrato=id_contrato
        and contrato_tercero.fk_contrato=id_contrato
        and fecha_realizacion_fiesta between '".$inicio."' and '".$fin."'
        order by fecha_realizacion_fiesta");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_ingresos_egresos($inicio,$fin){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("select *
        from 
        (select fecha_realizacion_pago as fecha, CONCAT('CNTRT ',fk_contrato) as motivo, monto_pago as ingreso, 0 as egreso
        from pago
        
        union
        
        select fecha_aprobado_contrato as fecha, CONCAT('SRV ', fk_servicio, ': ', nombre_servicio) as motivo, 0 as ingreso, costo_servicio as egreso
        from contrato c, servicio_presupuesto sp, presupuesto p, servicio s
        where c.fk_presupuesto=id_presupuesto
        and sp.fk_presupuesto=id_presupuesto
        and sp.fk_servicio=id_servicio
        
        union
         
        select fecha_orden_compra as fecha, CONCAT('OC', nro_orden_compra, '. ', cantidad_detalle_compra, ' und ', nombre_producto) as motivo, 0 as ingreso, costo_total_detalle_compra as egreso
        from orden_compra oc, detalle_compra dc, producto p, estado_detalle ed
        where dc.fk_producto_proveedor=ed.fk_detalle_compra_1
        and dc.fk_producto_proveedor2=ed.fk_detalle_compra_2
        and dc.fk_orden_compra=ed.fk_detalle_compra_3
        and dc.fk_orden_compra=nro_orden_compra
        and fk_estado not in (3,2)) as total
        where fecha between '".$inicio."' and '".$fin."'
        order by fecha");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_top_servicios($inicio,$fin){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT COUNT(*) contrataciones, fk_servicio id, nombre_servicio nombre
        FROM servicio_presupuesto sp, servicio, estado_contrato ec, presupuesto p, contrato c
        WHERE fk_servicio=id_servicio 
        AND sp.fk_presupuesto=id_presupuesto
        AND c.fk_presupuesto=id_presupuesto
        AND ec.fk_contrato=id_contrato
        AND c.fecha_aprobado_contrato BETWEEN '".$inicio."' and '".$fin."'
        AND fk_estado=1 GROUP BY fk_servicio 
        ORDER BY COUNT(*) DESC
        LIMIT 10 ");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_descuentos($inicio,$fin){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("Select * from ( select fecha_inicio_descuento as fecha_inicio, fecha_fin_descuento as fecha_fin, nombre_producto as nombre, CONCAT('PROD-',fk_producto) as id, CONCAT(porcentaje_descuento,'%') as dcto from descuento, producto where fk_producto=id_producto UNION select fecha_inicio_descuento as fecha_inicio, fecha_fin_descuento as fecha_fin, nombre_servicio as nombre, CONCAT('SERV-',fk_servicio) as id, CONCAT(porcentaje_descuento,'%') as dcto from descuento, servicio where fk_servicio=id_servicio) result 
        WHERE (fecha_inicio BETWEEN '".$inicio."' and '".$fin."'
        OR fecha_fin BETWEEN '".$inicio."' and '".$fin."'
        OR '".$inicio."' BETWEEN fecha_inicio and fecha_fin
        OR '".$fin."' BETWEEN fecha_inicio and fecha_fin)
        order by fecha_inicio");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }




}