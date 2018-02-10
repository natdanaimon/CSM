<?php

@session_start();

class commentService {

    function dataTable($info) {
        $db = new ConnectDB();
        $strSql = " select * from tb_comment where ref_no = '$info[ref_no]' order by 1 desc  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function addComment($db, $info) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_comment ( ";
        $strSql .= "    ref_no, ";
        $strSql .= "    s_comment, ";
        $strSql .= "    d_create, ";
        $strSql .= "    s_create_by ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[ref_no]', ";
        $strSql .= "  '$info[s_comment]', ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function delete($db, $seq) {
//        $strSQL = "DELETE FROM tb_customer_car WHERE i_cust_car = '" . $seq . "' ";
        $strSQL = "DELETE FROM tb_comment WHERE i_comment = " . $seq . " ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
