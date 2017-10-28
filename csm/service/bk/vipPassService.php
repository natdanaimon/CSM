<?php

@session_start();

class vipPassService {

    public function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT a.* ,  s.s_detail_th status_th, s.s_detail_en status_en from tb_cs_user_pass a , tb_status s where a.s_status = s.s_status";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    public function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT * from tb_cs_user_pass where s_username='$seq'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function add($db, $info) {
        $sql = " insert into tb_cs_user_pass ( s_username ,s_username_login, s_password , d_create, d_update , s_create_by , s_update_by , s_status) ";
        $sql .= " values ";
        $sql .= " ( ";
        $sql .= "  '$info[s_username]' , ";
        $sql .= "  '$info[s_username_login]' , ";
        $sql .= "  '$info[s_password]' , ";
        $sql .= "  " . $db->Sysdate(TRUE) . ", ";
        $sql .= " " . $db->Sysdate(TRUE) . ", ";
        $sql .= "  '$_SESSION[username]', ";
        $sql .= "  '$_SESSION[username]', ";
        $sql .= "  '$info[status]' ";
        $sql .= " ) ";
        $arr = array(
            array("query" => "$sql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function edit($db, $info) {
        $sql = " update tb_cs_user_pass ";
        $sql .= " set ";
        $sql .= " s_password = '$info[s_password]' ";
        $sql .= " where s_username = '$info[s_username]' ";
        $arr = array(
            array("query" => "$sql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function createStatementEdit($db, $info) {
        $sql = " update tb_cs_user_pass ";
        $sql .= " set ";
        $sql .= " s_password = '$info[s_password]' ";
        $sql .= " where s_username = '$info[s_username]' ";
        return array("query" => "$sql");
    }

    function validMain($db, $s_main) {
        $strSql = "select count(*) cnt from tb_cs_user_pass  where s_username = '$s_main' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        if ($_data[0][cnt] > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_cs_user_pass WHERE s_username = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_cs_user_pass WHERE s_username in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
