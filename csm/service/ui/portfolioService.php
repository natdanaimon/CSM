<?php

@session_start();

class portfolioService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = "";
        $strSql .= "SELECT ";
        $strSql .= "  i.*, ";
        $strSql .= "  s.s_detail_th status_th, ";
        $strSql .= "  s.s_detail_en status_en ";
        $strSql .= "FROM ";
        $strSql .= "  tb_portfolio i, ";
        $strSql .= "  tb_status s ";
        $strSql .= "WHERE ";
        $strSql .= " i.s_status = s.s_status ";
        $strSql .= "  AND s.s_type = 'ACTIVE' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_portfolio where i_portf =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfoFile($db) {
        $strSql = "select s_img_p1 img from tb_portfolio ";
        $strSql .= " union ";
        $strSql .= " select s_img_p2 img from tb_portfolio ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_portfolio WHERE i_portf = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_portfolio WHERE i_portf in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_portfolio WHERE i_portf = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_portfolio WHERE i_portf in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function edit($db, $info, $img1, $img2, $img3) {
        if ($img1 == NULL) {
            $img1 = "";
        }
        if ($img2 == NULL) {
            $img2 = "";
        }

        $strSql = "";
        $strSql .= "update tb_portfolio ";
        $strSql .= "set  ";
        $strSql .= "    s_img_p1='$img1', ";
        $strSql .= "    s_img_p2='$img2', ";
        $strSql .= "    i_index=$info[i_index], ";
        $strSql .= "    s_subject='$info[s_subject]', ";
        $strSql .= "    s_detail='$info[s_detail]', ";



        $strSql .= "    i_view=$info[i_view], ";
        $strSql .= "    i_vote=$info[i_vote], ";


        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_portf = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function add($db, $info, $img1, $img2, $img3) {
        if ($img1 == NULL) {
            $img1 = "";
        }
        if ($img2 == NULL) {
            $img2 = "";
        }
        if ($img3 == NULL) {
            $img3 = "";
        }


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_portfolio( ";
        $strSql .= "    s_img_p1, ";
        $strSql .= "    s_img_p2, ";
        $strSql .= "    i_index, ";
        $strSql .= "    s_subject, ";
        $strSql .= "    s_detail, ";

        $strSql .= "    i_view, ";
        $strSql .= "    i_vote, ";

        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";

        $strSql .= "  '$img1', ";
        $strSql .= "  '$img2', ";
        $strSql .= "  $info[i_index], ";
        $strSql .= "  '$info[s_subject]', ";
        $strSql .= "  '$info[s_detail]', ";

        $strSql .= "  $info[i_view], ";
        $strSql .= "  $info[i_vote], ";


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
