<?php

@session_start();

class createService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = " select * from ";
        $strSql .= " (";
        $strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
        $strSql .= " from tb_customer_car u, tb_status s";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'ACTIVE'";
        $strSql .= " ) tb_cust ,";
        $strSql .= " (";
        $strSql .= " select u.i_customer,concat(t.s_title_th, ' ', u.s_firstname, ' ', u.s_lastname) s_fullname,u.s_phone_1";
        $strSql .= " from tb_customer u, tb_status s, tb_title t";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'ACTIVE' and u.i_title = t.i_title ";
        $strSql .= " ) customer";
        $strSql .= " WHERE tb_cust.i_customer = customer.i_customer ";
        $strSql .= " order by tb_cust.d_create desc , tb_cust.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getInfo($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_customer_car where i_cust_car =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function validUser($db, $info) {
        $strSql = " select count(*) cnt from tb_customer_car where s_phone_1 ='" . $info[s_phone] . "' ";
        if ($info[func] == "edit") {
            $strSql .= " and i_cust_car != $info[id]  ";
        }
        $strSql .= " and s_status = 'A'  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function delete($db, $seq) {
        $strSQL = "DELETE FROM tb_customer_car WHERE i_cust_car = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

        $strSQL = "DELETE FROM tb_customer_car WHERE i_cust_car in ($query) ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function SelectById($db, $seq) {
        $strSql = "SELECT * FROM tb_customer_car WHERE i_cust_car = '" . $seq . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function SelectByArray($db, $query) {
        $strSql = "SELECT * FROM tb_customer_car WHERE i_cust_car in ($query) ";
        $_data = $db->Search_Data_FormatJson($strSql);
        return $_data;
    }

    function add($db, $info) {


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_customer_car ( ";
        $strSql .= "    i_customer, ";
        $strSql .= "    ref_no, ";
        $strSql .= "    s_car_code, ";
        $strSql .= "    s_license, ";
        $strSql .= "    d_ins_exp, ";
        $strSql .= "    s_type_capital, ";
        $strSql .= "    s_pay_type, ";

        $strSql .= "    i_ins_comp, ";
        $strSql .= "    i_dmg, ";
        $strSql .= "    d_inbound, ";
        $strSql .= "    d_outbound_confirm, ";


        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  $info[i_customer], ";
        $strSql .= "  '$info[ref_no]', ";
        $strSql .= "  '$info[s_car_code]', ";
        $strSql .= "  '$info[s_license]', ";
        $strSql .= "  '$info[d_ins_exp]', ";
        $strSql .= "  '$info[s_type_capital]', ";
        $strSql .= "  '$info[s_pay_type]', ";

        $strSql .= "  $info[i_ins_comp], ";
        $strSql .= "  $info[i_dmg], ";
        $strSql .= "  '$info[d_inbound]', ";
        $strSql .= "  '$info[d_outbound_confirm]', ";

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

    function edit($db, $info) {
        $strSql = "";
        $strSql .= "update tb_customer_car ";
        $strSql .= "set  ";
        $strSql .= "i_customer = $info[i_title], ";
        $strSql .= "s_car_code = '$info[s_lastname]', ";
        $strSql .= "s_license = '$info[s_phone_1]', ";
        $strSql .= "d_ins_exp = '$info[d_ins_exp]', ";
        $strSql .= "s_type_capital = '$info[s_type_capital]', ";
        $strSql .= "s_pay_type = '$info[s_pay_type]', ";
        $strSql .= "i_ins_comp = $info[i_ins_comp], ";
        $strSql .= "i_dmg = $info[i_dmg], ";
        $strSql .= "d_inbound = '$info[d_inbound]', ";
        $strSql .= "d_outbound_confirm = '$info[d_outbound_confirm]', ";

        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_cust_car = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

}
