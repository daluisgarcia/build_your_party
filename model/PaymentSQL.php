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

    public function get_user_pay_methods($id_user){
        $statement = $this->con->prepare("SELECT id_metodo_pago as id, banco_metodo_pago as banco, CASE WHEN tipo = 'TDC' THEN numero_tdc WHEN tipo = 'TDD' THEN numero_tdd WHEN tipo = 'TRANSFERENCIA' THEN numero_transferencia END as numero,tipo FROM METODO_PAGO WHERE fk_usuario=$id_user");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function add_payment_method($type, $number, $out_date, $bank, $id_user){
        switch ($type){
            case 'TDC':
                $statement = $this->con->prepare("INSERT INTO METODO_PAGO (banco_metodo_pago, numero_tdc, fecha_vencimiento_tdc, tipo, fk_usuario) VALUES ('$bank',$number,'$out_date','$type',$id_user)");
                $statement2 = $this->con->prepare("SELECT id_metodo_pago as id FROM METODO_PAGO WHERE banco_metodo_pago='$bank' AND numero_tdc=$number AND fecha_vencimiento_tdc='$out_date' AND tipo='$type' AND fk_usuario=$id_user");
                break;
            case 'TDD':
                $statement = $this->con->prepare("INSERT INTO METODO_PAGO (banco_metodo_pago, numero_tdd, tipo, fk_usuario) VALUES ('$bank',$number,'$type',$id_user);");
                $statement2 = $this->con->prepare("SELECT id_metodo_pago as id FROM METODO_PAGO WHERE banco_metodo_pago='$bank' AND numero_tdd=$number AND tipo='$type' AND fk_usuario=$id_user");
                break;
            case 'TRANSFERENCIA':
                $statement = $this->con->prepare("INSERT INTO METODO_PAGO (banco_metodo_pago, numero_transferencia, tipo, fk_usuario) VALUES ('$bank',$number,'$type',$id_user);");
                $statement2 = $this->con->prepare("SELECT id_metodo_pago as id FROM METODO_PAGO WHERE banco_metodo_pago='$bank' AND numero_transferencia=$number AND tipo='$type' AND fk_usuario=$id_user");
                break;
            default:
                $statement = '';
        }
        $statement->execute();
        $statement2->execute();
        $id = $statement2->fetchAll();
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