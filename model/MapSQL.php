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
            $statement = $this->con->prepare("SELECT a.id_$table as id, a.nombre_$table as nombre, c.x_coordenada as latitud, c.y_coordenada as longitud, p.nombre_persona as persona FROM $table AS a JOIN COORDENADA AS c ON c.id_coordenada=a.id_$table JOIN PERSONA AS p ON a.fk_persona=p.cedula_persona WHERE a.fk_lugar=$id_site;");
        }else{
            $statement = $this->con->prepare("SELECT id_lugar as id, nombre_lugar as nombre FROM $this->site_table WHERE fk_lugar=$id_site");
        }
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

}