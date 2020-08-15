<?php

include_once 'Connection.php';

class PaymentSQL extends Connection
{
    function __construct(){
        parent::__construct();
    }

    public function get_contract_payments($id_contract){
        $statement = $this->con->prepare("SELECT monto_pago as monto, fecha_realizacion_pago as fecha FROM PAGO WHERE fk_contrato=$id_contract");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function get_sum_contract_payments($id_contract){
        $statement = $this->con->prepare("SELECT sum(monto_pago) FROM PAGO WHERE fk_contrato=$id_contract");
        $statement->execute();
        $sum = $statement->fetchAll();
        if(!empty($sum)){
            return $sum[0][0];
        }else{
            return 0;
        }
    }

    public function get_ins_course_by_user($id_user){
        $statement = $this->con->prepare("SELECT * FROM INSCRIPCION_CUR_M WHERE fk_usuario=$id_user");
        $statement->execute();
        $bool = $statement->fetchAll();
        if(!empty($bool)){
            return true;
        }else{
            return false;
        }
    }

    public function get_user_pay_methods($id_user){
        $statement = $this->con->prepare("SELECT id_metodo_pago as id, banco_metodo_pago as banco, numero_metodo_pago as numero, nombre_tipo_mp as tipo FROM METODO_PAGO INNER JOIN TIPO_METODO_PAGO ON id_tipo_mp=fk_tipo WHERE fk_usuario=$id_user");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function get_payment_methods(){
        $statement = $this->con->prepare("SELECT id_tipo_mp as id, nombre_tipo_mp as nombre FROM TIPO_METODO_PAGO;");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function add_payment_method($type, $number,$bank, $id_user){
        $statement = $this->con->prepare("INSERT INTO METODO_PAGO (numero_metodo_pago, banco_metodo_pago, fk_usuario, fk_tipo) VALUES ($number, '$bank', $id_user, $type);");
        $statement->execute();
        $statement2 = $this->con->prepare("SELECT id_metodo_pago as id FROM METODO_PAGO WHERE banco_metodo_pago='$bank' AND numero_metodo_pago=$number AND fk_tipo=$type AND fk_usuario=$id_user");
        $statement2->execute();
        $id = $statement2->fetchAll();
        var_dump($id);
        $id = $id[0][0];
        return $id;
    }

    public function add_contract_payment($id_contract, $quantity, $id_pay_method){
        $statement = $this->con->prepare("INSERT INTO PAGO (monto_pago, fecha_realizacion_pago, fk_contrato, fk_metodo_de_pago) VALUES ($quantity, curdate(), $id_contract, $id_pay_method)");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function add_course_payment($id_course1, $id_course2, $quantity, $id_pay_method, $id_user){
        $statement = $this->con->prepare("INSERT INTO INSCRIPCION_CUR_M (fk_curso_matrim_1, fk_curso_matrim_2, fk_usuario) VALUES ($id_course1, $id_course2, $id_user)");
        $statement->execute();
        //HACER ALTER TABLE PARA DISMINUIR EL NUMERO DE CUPOS
        $statement = $this->con->prepare("SELECT id_inscripcion FROM INSCRIPCION_CUR_M WHERE fk_curso_matrim_1=$id_course1 AND fk_curso_matrim_2=$id_course2 AND fk_usuario=$id_user");
        $statement->execute();
        $id = $statement->fetchAll();
        $id = $id[0][0];
        $statement = $this->con->prepare("INSERT INTO PAGO (monto_pago, fecha_realizacion_pago, fk_ins_cur_m1, fk_ins_cur_m2, fk_ins_cur_m3, fk_metodo_de_pago) VALUES ($quantity, curdate(), $id_course1, $id_course2, $id, $id_pay_method)");
        $statement->execute();
        return $statement->fetchAll();
    }
}