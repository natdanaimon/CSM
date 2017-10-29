<?php

@session_start();

class autoService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_department b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_department where i_dept =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

   

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_department ";
        $strSql .= "set  ";
        $strSql .= "i_day= $info[i_day], ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]' ";
//        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_dept = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

   

}
