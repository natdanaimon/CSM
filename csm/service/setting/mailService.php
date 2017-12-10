<?php

@session_start();

class mailService {

    function getInfo() {
        $db = new ConnectDB();
        $strSql = "select * from tb_mail_config ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_mail_config ";
        $strSql .= "set  ";
        $strSql .= "s_insurance = '".$info[s_insurance]."', ";
        $strSql .= "s_claimonline = '".$info[s_claimonline]."', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
