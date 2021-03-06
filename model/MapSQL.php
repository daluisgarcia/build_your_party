<?php

include_once 'Connection.php';

class MapSQL extends Connection
{

    private $site_table = 'LUGAR';
    private $religion_table = 'RELIGION';

    function __construct(){
        parent::__construct();
    }

    public function get_sites_by_type($type){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_lugar as id, nombre_lugar as nombre FROM $this->site_table WHERE tipo_lugar='$type'");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_sites_by_fk($fk){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_lugar as id, nombre_lugar as nombre FROM $this->site_table WHERE fk_lugar=$fk");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_coordinates($table, $id_site, $religion=''){
        //PREPARACION DEL QUERY
        $statement = '';
        if($religion === ''){
            $statement = $this->con->prepare("SELECT a.id_$table as id, a.nombre_$table as nombre, c.x_coordenada as latitud, c.y_coordenada as longitud, concat(p.nombre_persona, ' ',p.apellido_persona) as persona FROM $table AS a JOIN COORDENADA AS c ON c.fk_$table=a.id_$table JOIN PERSONA AS p ON a.fk_persona=p.cedula_persona WHERE a.fk_lugar=$id_site;");
        }else{
            $statement = $this->con->prepare("SELECT id_lugar as id, nombre_lugar as nombre FROM $this->site_table WHERE fk_lugar=$id_site");
        }
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_religions(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_religion as id, nombre_religion as nombre FROM $this->religion_table");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_chuchs_by_fk_for_courses($fk_lugar){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT id_templo, nombre_templo FROM TEMPLO WHERE fk_lugar=$fk_lugar AND id_templo IN (SELECT fk_templo FROM CURSO_MATRIM);");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_chuch_and_courses_info($id_church){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT cu.id_curso_matrim as id, cu.fk_templo as templo, t.nombre_templo, c.x_coordenada as latitud, c.y_coordenada as longitud, cu.costo_curso_matrim as costo, cu.fecha_inicio_curso_matrim as fecha_inicio, cu.fecha_final_curso_matrim as fecha_final, cu.descripcion_curso_matrim as descripcion, cu.cupos_curso_matrim as cupos, p.nombre_persona as nombre_persona, tf.codigo_area_telefono as codigo, tf.numero_telefono as numero FROM TEMPLO as t INNER JOIN CURSO_MATRIM as cu ON t.id_templo=cu.fk_templo LEFT JOIN TELEFONO as tf ON t.id_templo=tf.fk_templo INNER JOIN PERSONA as p ON t.fk_persona=p.cedula_persona INNER JOIN COORDENADA as c ON t.id_templo=c.fk_templo WHERE t.id_templo=$id_church;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

}