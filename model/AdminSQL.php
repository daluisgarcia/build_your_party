<?php

include_once 'Connection.php';

class AdminSQL extends Connection
{

    private $notaries_table = 'NOTARIA';
    private $coordinates_table = 'COORDENADA';
    private $person_table = 'PERSONA';
    private $site_table = 'LUGAR';
    private $religion_table = 'RELIGION';
    private $phone_table = 'TELEFONO';

    function __construct(){
        parent::__construct();
    }

    public function get_notaries(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT a.id_notaria as id, a.nombre_notaria as nombre, c.id_coordenada as id_coordenada, c.x_coordenada as latitud, c.y_coordenada as longitud, p.cedula_persona as id_persona, concat(p.nombre_persona, ' ',p.apellido_persona) as persona, l.id_lugar as id_parroquia, l.nombre_lugar as nombre_parroquia, lp.id_lugar as id_municipio, lp.nombre_lugar as nombre_municipio, lpp.id_lugar as id_estado, lpp.nombre_lugar as nombre_estado FROM $this->notaries_table AS a LEFT JOIN $this->coordinates_table AS c ON c.fk_notaria=a.id_notaria LEFT JOIN $this->person_table AS p ON a.fk_persona=p.cedula_persona LEFT JOIN $this->site_table as l ON a.fk_lugar=l.id_lugar LEFT JOIN $this->site_table as lp ON l.fk_lugar=lp.id_lugar LEFT JOIN $this->site_table as lpp ON lp.fk_lugar=lpp.id_lugar;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function update_notary($id, $name, $fklugar){
        $statement = $this->con->prepare("UPDATE $this->notaries_table SET nombre_notaria = '$name', fk_lugar = $fklugar WHERE id_notaria = $id;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function update_coordinates($id, $latitud, $longitud){
        $statement = $this->con->prepare("UPDATE $this->coordinates_table SET x_coordenada = $latitud, y_coordenada = $longitud WHERE id_coordenada = $id;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function update_person($id, $name, $lname){
        $statement = $this->con->prepare("UPDATE $this->person_table SET nombre_persona = '$name', apellido_persona = '$lname' WHERE cedula_persona = $id;");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function delete_notary($id, $coordID, $personID){
        //SE ELIMINA LA TUPLA DE COORDENADA
        $statement = $this->con->prepare("DELETE FROM $this->coordinates_table WHERE id_coordenada=$coordID");
        $statement->execute();
        //SE ELIMINA LA TUPLA DE TELEFONO
        $statement = $this->con->prepare("DELETE FROM $this->phone_table WHERE fk_notaria=$id");
        $statement->execute();
        //SE ELIMINA LA TUPLA DE NOTARIA
        $statement = $this->con->prepare("DELETE FROM $this->notaries_table WHERE id_notaria=$id");
        $statement->execute();
        //SE ELIMINA LA TUPLA DE PERSONA
        $statement = $this->con->prepare("DELETE FROM $this->person_table WHERE cedula_persona=$personID");
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function add_notary($notary_name, $fk_lugar, $cedula, $latitud, $longitud, $codigo_area, $telefono){
        $statement = $this->con->prepare("INSERT INTO $this->notaries_table VALUES (null, '$notary_name', $fk_lugar, $cedula);");
        $statement->execute();
        $statement = $this->con->prepare("SELECT id_notaria FROM $this->notaries_table WHERE nombre_notaria = '$notary_name' AND fk_lugar=$fk_lugar AND fk_persona=$cedula;");
        $statement->execute();
        $id = $statement->fetchAll()[0][0];
        $statement = $this->con->prepare("INSERT INTO $this->coordinates_table (x_coordenada, y_coordenada, fk_notaria) VALUES ($latitud, $longitud, $id);");
        $statement->execute();
        $statement = $this->con->prepare("INSERT INTO $this->phone_table (id_telefono, codigo_area_telefono, numero_telefono, fk_notaria) VALUES (null, $codigo_area, $telefono, $id);");
        $statement->execute();
        return $statement->fetchAll();
    }

}