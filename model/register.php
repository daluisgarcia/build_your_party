<?php

include_once 'Connection.php';

class register extends Connection
{
    function __construct(){
        parent::__construct();
    }

    public function create_user($name, $last_name, $id, $phone_area, $phone, $email, $usuario, $pass){
        $statement = $this->con->prepare("insert into persona(cedula_persona, nombre_persona, apellido_persona, correo_persona, fk_lugar) values ($id, '$name', '$last_name', '$email', 21);");
        $statement->execute();
        $statement = $this->con->prepare("insert into telefono(id_telefono, codigo_area_telefono, numero_telefono, fk_persona) values (null, $phone_area, $phone, $id);");
        $statement->execute();
        $statement = $this->con->prepare("insert into usuario(id_usuario, nombre_usuario, passw_usuario, fk_persona) values (null, '$usuario', '$pass', $id);");
        $statement->execute();
        $statement = $this->con->prepare("SELECT * FROM USUARIO WHERE nombre_usuario='$usuario' AND passw_usuario='$pass';");
        $statement->execute();
        return $statement->fetchAll();
    }
}