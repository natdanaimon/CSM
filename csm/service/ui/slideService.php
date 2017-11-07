<?php

@session_start();

class slideService {

    function dataTable() {
      
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT ";
        $strSql .= "  sl.*, ";
        $strSql .= "  s.s_detail_th status_th, ";
        $strSql .= "  s.s_detail_en status_en ";
        $strSql .= "FROM ";
        $strSql .= "  tb_slide sl, ";
        $strSql .= "  tb_status s ";
        $strSql .= "WHERE ";
        $strSql .= "   sl.s_status = s.s_status ";
        $strSql .= "  AND s.s_type = 'ACTIVE' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {

        $db = new ConnectDB();
        $strSql = " select * from tb_slide where i_slide =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_image img from tb_slide ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_slide WHERE i_slide = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_slide WHERE i_slide in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_slide WHERE i_slide = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_slide WHERE i_slide in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function edit($db, $info, $img1) {
        if ($img1 == NULL) {
            $img1 = "";
        }


        $strSql = "";
        $strSql .= "update tb_slide ";
        $strSql .= "set  ";
        $strSql .= "    i_index=$info[i_index], ";
        $strSql .= "    s_desc_hl='$info[s_desc_hl]', ";
        $strSql .= "    s_desc_nm='$info[s_desc_nm]', ";



        $strSql .= "    s_image='$img1', ";



        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_slide = $info[id] ";
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
        $strSql .= "  tb_slide( ";

        $strSql .= "    i_index, ";
        $strSql .= "    s_desc_hl, ";
        $strSql .= "    s_desc_nm, ";




        $strSql .= "    s_image, ";


        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";

        $strSql .= "  '$info[i_index]', ";
        $strSql .= "  '$info[s_desc_hl]', ";
        $strSql .= "  '$info[s_desc_nm]', ";



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
        return $reslut;
    }

}
