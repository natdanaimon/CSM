<?php

@session_start();

class vatService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "select v.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= "from   tb_vat v , tb_status s  ";
        $strSql .= "where  v.s_status =  s.s_status ";
        $strSql .= "and    s.s_type   =  'ACTIVE' ";
//        $strSql .= "and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_vat where i_vat =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_vat ";
        $strSql .= "set  ";
        $strSql .= "f_vat  = $info[f_vat], ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_vat = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
