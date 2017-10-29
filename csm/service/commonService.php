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

    function DDLProvince($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_provinces order by i_province , s_name_th asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLAmphure($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_amphures where i_province = $info[i_province] order by i_amphure , s_name_th asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLDistrict($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_districts where i_amphure =  $info[i_amphure] order by i_district asc";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function DDLZipcode($info) {
        $db = new ConnectDB();
        $strSql = "select * from tb_districts where i_district =  $info[i_district] ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

}
