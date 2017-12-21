<?php

@session_start();

class createService {

    function dataTable() {
        $db = new ConnectDB();
        $strSql = " select *, '' as i_year , '' as i_brand , '' as i_gen , '' as i_sub from ";
        $strSql .= " (";
        $strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
        $strSql .= " from tb_customer_car u, tb_status s";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'REPAIR'";
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

    function dataTableKey($id) {
        $db = new ConnectDB();
        $strSql = " select *, '' as i_year , '' as i_brand , '' as i_gen , '' as i_sub from ";
        $strSql .= " (";
        $strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
        $strSql .= " from tb_customer_car u, tb_status s";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'REPAIR' ";
        $strSql .= " ) tb_cust ,";
        $strSql .= " (";
        $strSql .= " select u.i_customer,concat(t.s_title_th, ' ', u.s_firstname, ' ', u.s_lastname) s_fullname,u.s_phone_1";
        $strSql .= " from tb_customer u, tb_status s, tb_title t";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'ACTIVE' and u.i_title = t.i_title ";
        $strSql .= " ) customer";
        $strSql .= " WHERE tb_cust.i_customer = customer.i_customer ";
        $strSql .= " AND customer.i_customer =  ".$id;
        $strSql .= " order by tb_cust.d_create desc , tb_cust.s_status desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;
    }

    function getYear($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_car_map where s_car_code = '" . $seq . "'";
        $_data = $db->Search_Data_FormatJson($strSql);

        $strSql = " select * from tb_car_year where i_year =" . $_data[0]['i_year'];
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['i_year'];
    }

    function getBrand($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_car_map where s_car_code = '" . $seq . "'";
        $_data = $db->Search_Data_FormatJson($strSql);

        $strSql = " select * from tb_car_brand where s_brand_code ='" . $_data[0]['s_brand_code'] . "'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_brand_name'];
    }

    function getGeneration($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_car_map where s_car_code = '" . $seq . "'";
        $_data = $db->Search_Data_FormatJson($strSql);

        $strSql = " select * from tb_car_generation where s_gen_code ='" . $_data[0]['s_gen_code'] . "'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_gen_name'];
    }

    function getSub($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_car_map where s_car_code = '" . $seq . "'";
        $_data = $db->Search_Data_FormatJson($strSql);

        $strSql = " select * from tb_car_sub where s_sub_code ='" . $_data[0]['s_sub_code'] . "'";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_sub_name'];
    }

    function getInsurance($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_insurance_comp where i_ins_comp =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_comp_th'];
    }

    function getDamage($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_damage where i_dmg =" . $seq;
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data[0]['s_dmg_th'];
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
        $util = new Utility();

        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_customer_car ( ";
        $strSql .= "    i_customer, ";
        $strSql .= "    ref_no, ";
        $strSql .= "    s_car_code, ";
        $strSql .= "    s_license, ";
        $strSql .= "    d_ins_exp, ";
        $strSql .= "    i_ins_type, ";
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
        $strSql .= "  '" . $this->getRunning($db) . "', ";
        $strSql .= "  '$info[s_car_code]', ";
        $strSql .= "  '$info[s_license]', ";
        $strSql .= "  '" . $util->DateSQL($info[d_ins_exp]) . "', ";
        $strSql .= "  $info[i_ins_type], ";
        $strSql .= "  '$info[s_type_capital]', ";
        $strSql .= "  '$info[s_pay_type]', ";

        $strSql .= "  $info[i_ins_comp], ";
        $strSql .= "  $info[i_dmg], ";
        $strSql .= "  '" . $util->DateSQL($info[d_inbound]) . "', ";
        $strSql .= "  '" . $util->DateSQL($info[d_outbound_confirm]) . "', ";

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
        $util = new Utility();
        $strSql = "";
        $strSql .= "update tb_customer_car ";
        $strSql .= "set  ";
        $strSql .= "i_customer = $info[i_customer], ";
        $strSql .= "s_car_code = '$info[s_car_code]', ";
        $strSql .= "s_license = '$info[s_license]', ";
        $strSql .= "d_ins_exp = '" . $util->DateSQL($info[d_ins_exp]) . "', ";
        $strSql .= "i_ins_type = $info[i_ins_type], ";
        $strSql .= "s_type_capital = '$info[s_type_capital]', ";
        $strSql .= "s_pay_type = '$info[s_pay_type]', ";
        $strSql .= "i_ins_comp = $info[i_ins_comp], ";
        $strSql .= "i_dmg = $info[i_dmg], ";
        $strSql .= "d_inbound = '" . $util->DateSQL($info[d_inbound]) . "', ";
        $strSql .= "d_outbound_confirm = '" . $util->DateSQL($info[d_outbound_confirm]) . "', ";

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

    function getRunning($db) {
        $year = date("Y");
        $month = str_pad("", 2 - strlen(date("m")), "0") . date("m");
        $strSql = "SELECT * FROM tb_master_running WHERE s_year = '" . $year . "' and s_month = '" . $month . "' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $current = intval($_data[0]['s_running']);
        $run_new = $current + 1; // str_pad($str, 20, ".");
        $run_new = str_pad("", 3 - strlen($run_new), "0") . $run_new;
        $strSql = "UPDATE tb_master_running set s_running='$run_new'  WHERE s_year = '" . $year . "' and s_month = '" . $month . "' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);

        return $year . $month . $run_new;
    }

}
