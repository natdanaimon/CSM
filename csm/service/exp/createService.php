<?php

@session_start();

class createService {

    function dataTable() {
        $db = new ConnectDB();
        /*
        $strSql = " select *, '' as i_year , '' as i_brand , '' as i_gen , '' as i_sub from ";
        $strSql .= " (";
        $strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
        $strSql .= " from tb_po_daily u, tb_status s";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'REPAIR'";
        $strSql .= " and s.s_status = 'R1'";
        $strSql .= " ) tb_cust ,";
        $strSql .= " (";
        $strSql .= " select u.i_customer,concat(t.s_title_th, ' ', u.s_firstname, ' ', u.s_lastname) s_fullname,u.s_phone_1";
        $strSql .= " from tb_customer u, tb_status s, tb_title t";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'ACTIVE' and u.i_title = t.i_title ";
        $strSql .= " ) customer";
        $strSql .= " WHERE tb_cust.i_customer = customer.i_customer ";
        $strSql .= " order by tb_cust.d_create desc , tb_cust.s_status desc ";
        //*/
        $strSql = " SELECT u.* , s.s_detail_th status_th, s.s_detail_en status_en ,e.s_firstname, e.s_lastname , pc.s_comp_th ";
       

        $strSql .= " FROM tb_po_daily u ";
        $strSql .= " LEFT JOIN tb_status s ON u.s_status = s.s_status";
        $strSql .= " LEFT JOIN tb_partner_comp pc ON u.i_daily_shop = pc.i_part_comp";
        $strSql .= " LEFT JOIN tb_employee e ON u.i_daily_receive = e.i_emp";

        $strSql .= " order by u.d_create desc , u.s_status desc ";

        
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
        $strSql .= " AND customer.i_customer =  " . $id;
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
        $strSql = " select * from tb_po_daily where i_po_daily =" . $seq;
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
//        $strSQL = "DELETE FROM tb_customer_car WHERE i_cust_car = '" . $seq . "' ";
        $strSQL = "UPDATE tb_customer_car set s_status = 'R0' WHERE i_cust_car = '" . $seq . "' ";
        $arr = array(
            array("query" => "$strSQL")
        );
        $reslut = $db->insert_for_upadte($arr);
        return $reslut;
    }

    function deleteAll($db, $query) {

//        $strSQL = "DELETE FROM tb_customer_car WHERE i_cust_car in ($query) ";
        $strSQL = "UPDATE tb_customer_car set s_status = 'R0' WHERE i_cust_car in ($query) ";
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
        $strSql .= "  tb_po_daily ( ";
        //$strSql .= "    s_po_daily_order, ";
        $strSql .= "    s_po_daily_ref, ";
        $strSql .= "    d_daily_order, ";
        $strSql .= "    i_daily_shop, ";
        $strSql .= "    i_daily_receive, ";
        $strSql .= "    d_daily_receive, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        //$strSql .= "  '$info[s_po_daily_order]', ";
        $strSql .= "  '$info[s_po_daily_ref]', ";
        $strSql .= "  '" . $util->DateSQL($info[d_daily_order]) . "', ";
        $strSql .= "  '$info[i_daily_shop]', ";
        $strSql .= "  '$info[i_daily_receive]', ";
        $strSql .= "  '" . $util->DateSQL($info[d_daily_receive]) . "', ";
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
        $last_id = mysql_insert_id();
        
 
				 while(
				 list($key, $s_po_daily_order) = each ($_POST['s_po_daily_order'])
				 and list($key, $i_daily_price) = each ($_POST['i_daily_price'])
				 and list($key, $i_daily_amount) = each ($_POST['i_daily_amount'])
				 
				 ){
        	if($s_po_daily_order != '' and $i_daily_price != '' and $i_daily_amount != ''){
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_po_daily_order ( ";
        $strSql .= "    i_po_daily, ";
        $strSql .= "    s_po_daily_order, ";
        $strSql .= "    i_daily_price, ";
        $strSql .= "    i_daily_amount, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$last_id', ";
        $strSql .= "  '$s_po_daily_order', ";
        $strSql .= "  '$i_daily_price', ";
        $strSql .= "  '$i_daily_amount', ";
        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$info[status]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $resluts = $db->insert_for_upadte($arr);
        	}
        }
        
        
        
        return $reslut;
    }

    function edit($db, $info) {
        
        $util = new Utility();
        $strSql = "";
        $strSql .= "update tb_po_daily ";
        $strSql .= "set  ";
        $strSql .= "s_po_daily_ref = '$info[s_po_daily_ref]', ";
        $strSql .= "i_daily_shop = '$info[i_daily_shop]', ";
        $strSql .= "d_daily_order = '" . $util->DateSQL($info[d_daily_order]) . "', ";
        $strSql .= "d_daily_receive = '" . $util->DateSQL($info[d_daily_receive]) . "', ";
        $strSql .= "i_daily_receive = $info[i_daily_receive], ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where i_po_daily = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        
        $last_id = $info[id];
        mysql_query("DELETE FROM tb_po_daily_order WHERE i_po_daily=$last_id ");
 
				 while(
				 list($key, $s_po_daily_order) = each ($_POST['s_po_daily_order'])
				 and list($key, $i_daily_price) = each ($_POST['i_daily_price'])
				 and list($key, $i_daily_amount) = each ($_POST['i_daily_amount'])
				 
				 ){
        	if($s_po_daily_order != '' and $i_daily_price != '' and $i_daily_amount != ''){
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_po_daily_order ( ";
        $strSql .= "    i_po_daily, ";
        $strSql .= "    s_po_daily_order, ";
        $strSql .= "    i_daily_price, ";
        $strSql .= "    i_daily_amount, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$last_id', ";
        $strSql .= "  '$s_po_daily_order', ";
        $strSql .= "  '$i_daily_price', ";
        $strSql .= "  '$i_daily_amount', ";
        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$info[status]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $resluts = $db->insert_for_upadte($arr);
        	}
        }
        
        return $reslut;
    }

    function getRunning($db) {
        $year = substr(date("Y"), 2);
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
