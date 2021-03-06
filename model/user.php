<?php

include_once 'Connection.php';

class user extends Connection
{
    function __construct(){
        parent::__construct();
    }

    public function get_user_data($username, $password){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT * FROM USUARIO WHERE nombre_usuario='$username' AND passw_usuario='$password';");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function register_and_login($name, $last_name, $id, $phone_area, $phone, $email, $usuario, $pass){
        $statement = $this->con->prepare("insert into persona(cedula_persona, nombre_persona, apellido_persona, correo_persona, fk_lugar) values ($id, '$name', '$last_name', '$email', 21);");
        $statement->execute();
        $statement = $this->con->prepare("insert into telefono(id_telefono, codigo_area_telefono, numero_telefono, fk_persona) values (null, $phone_area, $phone, $id);");
        $statement->execute();
        $statement = $this->con->prepare("insert into usuario(id_usuario, nombre_usuario, passw_usuario, fk_persona) values (null, '$usuario', '$pass', $id);");
        $statement->execute();
        return $this->get_user_data($usuario,$pass);
    }

    public function getAllPermissionsForUser($id_usuario) {
        $statement = $this->con->prepare("select pe.nombre_permiso as nombre_permiso from (select p2.nombre_permiso as nombre_permiso, r.id_rol as id_rol from permiso p2, rol_permiso rp, rol r where rp.fk_permiso=p2.id_permiso and rp.fk_rol=r.id_rol) pe, rol_usuario ru where ru.fk_usuario=$id_usuario and ru.fk_rol = pe.id_rol;");
        $statement->execute();
        return $statement->fetchAll();
    }
}