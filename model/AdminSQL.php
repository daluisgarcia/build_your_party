<?php

include_once 'Connection.php';

class AdminSQL extends Connection
{

    private $notaries_table = 'NOTARIA';
    private $coordinates_table = 'COORDENADA';
    private $person_table = 'PERSONA';
    private $site_table = 'LUGAR';
    private $religion_table = 'RELIGION';

    function __construct(){
        parent::__construct();
    }

    public function get_notaries(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT a.id_notaria as id, a.nombre_notaria as nombre, c.id_coordenada as id_coordenada, c.x_coordenada as latitud, c.y_coordenada as longitud, p.cedula_persona as id_persona, concat(p.nombre_persona, ' ',p.apellido_persona) as persona, l.id_lugar as id_parroquia, l.nombre_lugar as nombre_parroquia, lp.id_lugar as id_municipio, lp.nombre_lugar as nombre_municipio, lpp.id_lugar as id_estado, lpp.nombre_lugar as nombre_estado FROM $this->notaries_table AS a LEFT JOIN $this->coordinates_table AS c ON c.id_coordenada=a.id_notaria LEFT JOIN $this->person_table AS p ON a.fk_persona=p.cedula_persona LEFT JOIN $this->site_table as l ON a.fk_lugar=l.id_lugar LEFT JOIN $this->site_table as lp ON l.fk_lugar=lp.id_lugar LEFT JOIN $this->site_table as lpp ON lp.fk_lugar=lpp.id_lugar;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function update_notarie(){

    }

    public function update_coordinates(){

    }

}