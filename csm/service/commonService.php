<?php

@session_start();

class commonService {

    function DDLStatus() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'CS' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLStatusActive() {
        $db = new ConnectDB();
        $strSql = "select * from tb_status where s_type = 'ACTIVE' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLDepartment() {
        $db = new ConnectDB();
        $strSql = "select * from tb_department where s_status = 'A' order by i_index asc , s_dept_th asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
