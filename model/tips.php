<?php


include_once 'Connection.php';

class PostManagement extends Connection
{

    public function get_post_boda(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT cuerpo, titulo, imagen from (SELECT cuerpo_post as cuerpo, titulo_post as titulo, ruta_imagen as imagen, seccion_post as seccion from post left join imagen on fk_post=id_post) as tabla WHERE seccion='BODA'");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_post_xv(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT cuerpo, titulo, imagen from (SELECT cuerpo_post as cuerpo, titulo_post as titulo, ruta_imagen as imagen, seccion_post as seccion from post left join imagen on fk_post=id_post) as tabla WHERE seccion='XV'");
     
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_post_otro(){
        //PREPARACION DEL QUERY
        $statement = $this->con->prepare("SELECT cuerpo, titulo, imagen from (SELECT cuerpo_post as cuerpo, titulo_post as titulo, ruta_imagen as imagen, seccion_post as seccion from post left join imagen on fk_post=id_post) as tabla WHERE seccion='OTRO'");
     
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    

}