<?php

@session_start();

class customerService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = " select u.*,s.s_detail_th status_th, s.s_detail_en status_en,t.s_title_th , t.s_title_en ";
        $strSql .= "from tb_customer u , tb_status s ,tb_title t ";
        $strSql .= "where u.s_status = s.s_status ";
        $strSql .= "and s.s_type = 'ACTIVE' ";
        $strSql .= "and u.i_title = t.i_title ";
        $strSql .= "order by u.d_create desc , u.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_customer where i_customer =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function validUser($db, $info) {
        $strSql = " select count(*) cnt from tb_customer where s_phone_1 ='" . $info[s_phone_1] . "' ";
        if ($info[func] == "edit") {
            $strSql .= " and i_customer != $info[id]  ";
        }
        $strSql .= " and s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_customer WHERE i_customer = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_customer WHERE i_customer in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_customer WHERE i_customer = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_customer WHERE i_customer in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function add($db, $info, $imgProfile) {


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_customer ( ";
        $strSql .= "    i_title, ";
        $strSql .= "    s_firstname, ";
        $strSql .= "    s_lastname, ";
        $strSql .= "    s_phone_1, ";
        $strSql .= "    s_phone_2, ";
        $strSql .= "    s_email, ";
        $strSql .= "    s_line, ";

        $strSql .= "    s_address, ";
        $strSql .= "    i_province, ";
        $strSql .= "    i_amphure, ";
        $strSql .= "    i_district, ";
        $strSql .= "    i_zipcode, ";




        $strSql .= "    s_image, ";


        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  $info[i_title], ";
        $strSql .= "  '$info[s_firstname]', ";
        $strSql .= "  '$info[s_lastname]', ";
        $strSql .= "  '$info[s_phone_1]', ";
        $strSql .= "  '$info[s_phone_2]', ";
        $strSql .= "  '$info[s_email]', ";
        $strSql .= "  '$info[s_line]', ";

        $strSql .= "  '$info[s_address]', ";
        $strSql .= "  $info[i_province], ";
        $strSql .= "  $info[i_amphure], ";
        $strSql .= "  $info[i_district], ";
        $strSql .= "  $info[i_zipcode], ";



        $strSql .= "  '$imgProfile', ";


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

    function edit($db, $info, $imageProfile) {
        $strSql = "";
        $strSql .= "update tb_customer ";
        $strSql .= "set  ";
        $strSql .= "i_title = $info[i_title], ";
        $strSql .= "s_firstname = '$info[s_firstname]', ";
        $strSql .= "s_lastname = '$info[s_lastname]', ";
        $strSql .= "s_phone_1 = '$info[s_phone_1]', ";
        $strSql .= "s_phone_2 = '$info[s_phone_2]', ";
        $strSql .= "s_email = '$info[s_email]', ";
        $strSql .= "s_line = '$info[s_line]', ";

        $strSql .= "s_address = '$info[s_address]', ";
        $strSql .= "i_province = $info[i_province], ";
        $strSql .= "i_amphure = $info[i_amphure], ";
        $strSql .= "i_district = $info[i_district], ";
        $strSql .= "i_zipcode = $info[i_zipcode], ";



        if ($imageProfile != NULL) {
            $strSql .= "s_image = '$imageProfile', ";
        }

        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_customer = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
