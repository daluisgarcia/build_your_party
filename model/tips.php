<?php


include_once 'Connection.php';

class PostManagement extends Connection
{

    public function get_post($tipo){
        //PREPARACION DEL QUERY
        $query = "";
        $statement = $this->con->prepare("SELECT cuerpo, titulo, imagen from (SELECT cuerpo_post as cuerpo, titulo_post as titulo, ruta_imagen as imagen, id_post, seccion_post as seccion from post left join imagen on fk_post=id_post) as tabla WHERE seccion='$tipo' ORDER BY id_post DESC");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }
    
    public function get_galeria($post){
        //PREPARACION DEL QUERY
        $query = "";
        $statement = $this->con->prepare("SELECT ruta_imagen as imagen FROM imagen WHERE FK_POST = $post");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_disenadores(){
        //PREPARACION DEL QUERY
        $query = "";
        $statement = $this->con->prepare("SELECT persona, rol, nombre, correo, lugar, ruta_imagen pfp
        FROM
        (SELECT persona.cedula_persona as persona, rol_cyc as rol, CONCAT(nombre_persona,' ',apellido_persona) as nombre, correo_persona as correo, nombre_lugar as lugar
         FROM persona, lugar,corte_y_costura cyc
        WHERE persona.fk_lugar=id_lugar 
        AND cyc.cedula_persona=persona.cedula_persona) info left join imagen
        on info.persona=imagen.fk_persona");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }
    
    public function get_trabajos_cyc($persona){
        //PREPARACION DEL QUERY
        $query = "";
        $statement = $this->con->prepare("SELECT nombre_trabajo_cyc as nombre, tiempo_realizacion_trabajo_cyc as tiempo, tipo_tela_trabajo_cyc as tela,
        ruta_imagen as imagen
        FROM trabajo_cyc, imagen 
        WHERE imagen.fk_trabajo_cyc=trabajo_cyc.id_trabajo_cyc AND imagen.fk_trabajo_cyc_2 = $persona");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }

    public function get_telefonos_persona($persona){
        //PREPARACION DEL QUERY
        $query = "";
        $statement = $this->con->prepare("SELECT codigo_area_telefono,'-',numero_telefono as telefono from telefono where fk_persona= $persona");
        //EJECUCION DEL QUERY
        $statement->execute();
        // El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
        return $statement->fetchAll();
    }
}