<?php

@session_start();

class insuranceService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_insurance_comp b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_insurance_comp where i_ins_comp =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_image from tb_insurance_comp ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_insurance_comp WHERE i_ins_comp = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {
        $strSQL = "DELETE FROM tb_insurance_comp WHERE i_ins_comp in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_insurance_comp WHERE i_ins_comp = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }



    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_insurance_comp  WHERE i_ins_comp in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function edit($db, $info, $img1) {
        if ($img1 == NULL) {
            $img1 = "";
        }

        $strSql = "";
        $strSql .= "update tb_insurance_comp ";
        $strSql .= "set  ";
        $strSql .= "    s_comp_th='$info[s_comp_th]', ";
        $strSql .= "    s_name_display='$info[s_name_display]', ";
        $strSql .= "    s_tax_no='$info[s_tax_no]', ";
        $strSql .= "    s_address='$info[s_address]', ";
        $strSql .= "    s_image='$img1', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_ins_comp = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info, $img1) {
        if ($img1 == NULL) {
            $img1 = "";
        }


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_insurance_comp( ";
        $strSql .= "    s_comp_th, ";
        $strSql .= "    s_name_display, ";
        $strSql .= "    s_address, ";
        $strSql .= "    s_tax_no, ";
        $strSql .= "    s_image, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";

        $strSql .= "  '$info[s_comp_th]', ";
        $strSql .= "  '$info[s_name_display]', ";
        $strSql .= "  '$info[s_address]', ";
        $strSql .= "  '$info[s_tax_no]', ";
        $strSql .= "  '$img1', ";

        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$info[status]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        $last_id = mysql_insert_id();
        if($last_id < 10){
          $s_code = "C00".$last_id;
        }elseif($last_id < 100){
          $s_code = "C0".$last_id;
        }else{
          $s_code = "C".$last_id;
        }
        $strSql = "";
        $strSql .= "update tb_insurance_comp ";
        $strSql .= "set  ";
        $strSql .= "s_code  = '$s_code' ";
        $strSql .= "where i_ins_comp = $last_id ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        
        return $reslut;
    }

}
