<?php

@session_start();

class claimService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT  ";
        $strSql .= "m.*, st.s_detail_th status_th, st.s_detail_en status_en ";
        $strSql .= " FROM  ";
        $strSql .= "tb_insurance_claim m ,   tb_status st  ";
        $strSql .= "WHERE 1=1 ";
        $strSql .= "AND m.s_status = st.s_status ";
        $strSql .= "AND st.s_type   =  'ACTIVE' ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_insurance_claim where i_claim =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }
    
    function getInfoDetail($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_claim_image where s_ref_image ='" . $seq."' order by s_flg_width desc , i_cimage asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_insurance_claim WHERE i_claim = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {
        $strSQL = "DELETE FROM tb_insurance_claim WHERE i_claim in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }
    
     function deleteNotRef($db) {
        $strSQL = "DELETE FROM tb_claim_image WHERE s_ref_image NOT in (select s_ref_image from tb_insurance_claim)";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_insurance_claim WHERE i_insurance = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_insurance_claim  WHERE i_claim in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_copy_claim img from tb_insurance_claim ";
        $strSql .= " union ";
        $strSql .= "select s_copy_driver img from tb_insurance_claim ";
        $strSql .= " union ";
        $strSql .= "select s_copy_insurance img from tb_insurance_claim ";
        $strSql .= " union ";
        $strSql .= "select s_copy_car img from tb_insurance_claim ";
        $strSql .= " union ";
        $strSql .= "select s_copy_pay img from tb_insurance_claim ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }
    
      function getInfoFileDetail($db) {
        $strSql = "select s_image img from tb_claim_image ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

}
