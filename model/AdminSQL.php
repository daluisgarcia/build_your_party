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

    public function get_users_and_persons(){
        $statement = $this->con->prepare("select p.cedula_persona as cedula, p.nombre_persona as nombre, p.apellido_persona as apellido, p.correo_persona as correo, t.codigo_area_telefono as codigo_de_area, t.numero_telefono as numero, u.nombre_usuario as usuario, est.nombre_lugar as estado, mun.nombre_lugar as municipio, parr.nombre_lugar as parroquia, t.id_telefono as telefono_id, u.id_usuario as usuario_id, est.id_lugar as estado_id, mun.id_lugar as municipio_id, parr.id_lugar as parroquia_id from telefono t right join persona p on t.fk_persona=p.cedula_persona, usuario u, lugar est, lugar mun, lugar parr where u.fk_persona=p.cedula_persona and parr.fk_lugar=mun.id_lugar and mun.fk_lugar=est.id_lugar and p.fk_lugar=parr.id_lugar;");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function get_posts() {
        $statement = $this->con->prepare("select i.id_imagen as id_imagen, i.ruta_imagen as ruta, p.id_post as id, p.seccion_post as seccion, p.titulo_post as titulo, p.cuerpo_post as cuerpo  from post p left join imagen i on i.fk_post=p.id_post;");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function update_post($id, $title, $section, $body,$id_imagen, $ruta) {
        $statement = $this->con->prepare("update imagen set ruta_imagen='{$ruta}' where id_imagen='{$id_imagen}'");
        $statement->execute();
        $statement = $this->con->prepare("update post set seccion_post='{$section}', titulo_post='{$title}', cuerpo_post='{$body}' where id_post='{$id}'");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function add_post($ruta_imagen, $section, $title, $body) {
        $statement = $this->con->prepare("insert into post(seccion_post, titulo_post, cuerpo_post) values('$section', '$title', '$body');");
        $statement->execute();
        if(!empty($ruta_imagen)) {
            $statement = $this->con->prepare("select id_post from post where seccion_post='$section' and titulo_post='$title' and cuerpo_post='$body';");
            $statement->execute();
            $id = $statement->fetchAll()[0][0];
            $statement = $this->con->prepare("insert into imagen(ruta_imagen, fk_post) values('$ruta_imagen', '$id');");
            $statement->execute();
        }
        return $statement->fetchAll();
    }

    public function delete_post($section, $title, $body) {
        $statement = $this->con->prepare("select id_post from post where seccion_post='$section' and titulo_post='$title' and cuerpo_post='$body';");
        $statement->execute();
        $id = $statement->fetchAll()[0][0];
        $statement = $this->con->prepare("delete from post where seccion_post='$section' and titulo_post='$title' and cuerpo_post='$body';");
        $statement->execute();
        $statement = $this->con->prepare("delete from imagen where fk_post=$id;");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function update_client($cedula, $nombre, $apellido, $correo, $codigo, $numero, $id_telefono, $usuario, $id_usuario, $parroquia) {
        $statement = $this->con->prepare("update persona set cedula_persona=$cedula, nombre_persona='$nombre', apellido_persona='$apellido', correo_persona='$correo', fk_lugar=$parroquia where cedula_persona=$cedula;");
        $statement->execute();
        $statement = $this->con->prepare("update usuario set nombre_usuario='$usuario' where id_usuario=$id_usuario;");
        $statement->execute();
        $statement = $this->con->prepare("update telefono set codigo_area_telefono=$codigo, numero_telefono=$numero, fk_persona=$cedula where id_telefono=$id_telefono;");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function add_client($cedula, $nombre, $apellido, $correo, $codigo, $numero, $usuario, $parroquia) {
        $statement = $this->con->prepare("insert into persona(cedula_persona, nombre_persona, apellido_persona, correo_persona, fk_lugar) values ($cedula, '$nombre', '$apellido', '$correo', $parroquia);");
        $statement->execute();
        $statement = $this->con->prepare("insert into usuario(nombre_usuario, passw_usuario, fk_persona) values ($usuario, '12345678', $cedula);");
        $statement->execute();
        $statement = $this->con->prepare("insert into telefono(codigo_area_telefono, numero_telefono, fk_persona) values ($codigo, $numero, $cedula);");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function delete_client($cedula, $usuario) {
        $statement = $this->con->prepare("delete from usuario where nombre_usuario='$usuario' and fk_persona='$cedula';");
        $statement->execute();
        $statement = $this->con->prepare("delete from persona where cedula_persona='$cedula';");
        $statement->execute();
        $statement = $this->con->prepare("delete from telefono where fk_persona='$cedula';");
        $statement->execute();
        return $statement->fetchAll();
    }



}