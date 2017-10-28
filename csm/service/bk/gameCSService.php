<?php

@session_start();

class gameCSService {

    function dataTable() {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_cs_game b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $strSql = " select * from tb_cs_game where i_game =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_cs_game WHERE i_game = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_cs_game WHERE i_game in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_cs_game WHERE i_game = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_cs_game WHERE i_game in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function getAmountCurrent($f_amount_base , $i_game) {
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
    
        $strSql = "select IFNULL(sum(f_total),0) amt from tb_cs_dp where s_status = 'APPR' and i_game = $i_game";
        $_dp = $db->Search_Data_FormatJson($strSql);

        $strSql = "select IFNULL(sum(f_amount),0) amt from tb_cs_wd where s_status = 'APPR' and i_game = $i_game";
        $_wd = $db->Search_Data_FormatJson($strSql);
        $summary = ($f_amount_base + $_wd[0][amt]) - $_dp[0][amt];
        return $summary;
    }

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_cs_game ";
        $strSql .= "set  ";
        $strSql .= "s_game = '$info[s_game]', ";
        $strSql .= "f_amount_base= $info[f_amount_base], ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_game = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info) {
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_cs_game( ";
        $strSql .= "    s_game, ";
        $strSql .= "    f_amount_base, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_game]', ";
        $strSql .= "  $info[f_amount_base], ";
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
        return $reslut;
    }

}
