<?php

@session_start();

class transactionService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT  ";
        $strSql .= "m.*, st.s_detail_th status_th, st.s_detail_en status_en , c.s_comp_th , c.s_image , t.s_name s_type_name , p.s_promotion , rp.s_name s_repair_type";
        $strSql .= " FROM  ";
        $strSql .= "tb_insurance m  , tb_insurance_comp c , tb_insurance_type t, tb_status st ,tb_insurance_promotion p , tb_insurance_repair_type rp ";
        $strSql .= "WHERE 1=1 ";
        $strSql .= "AND m.i_ins_comp = c.i_ins_comp ";
        $strSql .= "AND m.i_ins_type = t.i_ins_type ";
        $strSql .= "AND m.i_ins_promotion = p.i_ins_promotion ";
        $strSql .= "AND m.i_prcar_repair_type = rp.i_repair ";
        $strSql .= "AND m.s_status = st.s_status ";
        $strSql .= "AND st.s_type   =  'ACTIVE' ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function dataTableEx() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "        SELECT    ";
        $strSql .= "        m.s_car_code s_code , CONCAT(b.s_brand_name,' : ',y.i_year,' : ',g.s_gen_name,' : ',s.s_sub_name ) as s_name ";
        $strSql .= "        FROM    ";
        $strSql .= "        tb_insurance m , tb_car_year y , tb_car_brand b , tb_car_generation g , tb_car_sub s , tb_status st   ";
        $strSql .= "        WHERE 1=1   ";
        $strSql .= "        AND m.i_year = y.i_year   ";
        $strSql .= "        AND m.s_brand_code = b.s_brand_code   ";
        $strSql .= "        AND m.s_gen_code = g.s_gen_code   ";
        $strSql .= "        AND m.s_sub_code = s.s_sub_code   ";
        $strSql .= "        AND m.s_status = st.s_status   ";
        $strSql .= "        AND st.s_type   =  'ACTIVE'   ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_insurance_trans where i_ins_trans =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }



    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_insurance_trans WHERE i_ins_trans = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {
        $strSQL = "DELETE FROM tb_insurance_trans WHERE i_ins_trans in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_insurance_trans WHERE i_insurance = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

  

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_insurance_trans  WHERE i_ins_trans in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }



}
