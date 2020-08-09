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
        $statement = $this->con->prepare("SELECT id_presupuesto as id, fecha_presupuesto as fecha FROM PRESUPUESTO WHERE id_presupuesto=$party_id;");
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
}