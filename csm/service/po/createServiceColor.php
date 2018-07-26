<?php

@session_start();

class createService {

    function dataTable() {
        $db = new ConnectDB();
        /*
        $strSql = " select *, '' as i_year , '' as i_brand , '' as i_gen , '' as i_sub from ";
        $strSql .= " (";
        $strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
        $strSql .= " from tb_po_color u, tb_status s";
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
       

        $strSql .= " FROM tb_po_color u ";
        $strSql .= " LEFT JOIN tb_status s ON u.s_status = s.s_status";
        $strSql .= " LEFT JOIN tb_partner_comp pc ON u.i_color_shop = pc.i_part_comp";
        $strSql .= " LEFT JOIN tb_employee e ON u.i_color_receive = e.i_emp";

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
        $strSql = " select * from tb_po_color where i_po_color =" . $seq;
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

    
    function addOrder($db, $info) {
    	$util = new Utility();

       	$strSql = " select i_index ";
				$strSql .= " FROM tb_po_color_list  WHERE ref_id = '".$info[ref_id]."' ";
				$strSql .= " ORDER BY id desc limit 1 ";
				$_dataTable = $db->Search_Data_FormatJson($strSql);
				
				$strSql = " select ref_no ";
				$strSql .= " FROM tb_customer_car WHERE i_cust_car = '".$info[ref_id]."' ";
				$customer_car = $db->Search_Data_FormatJson($strSql);
				
				$ref_no = $customer_car[0][ref_no];
				$i_index = $_dataTable[0][i_index]+1;
				
				
				if($i_index == 1){
					$strSql = "";
	        $strSql .= "INSERT ";
	        $strSql .= "INTO ";
	        $strSql .= "  tb_po_color ( ";
	        $strSql .= "    ref_id ";
	        $strSql .= "    ,ref_no ";
	        $strSql .= "    ,s_po_color_ref ";
	        $strSql .= "    ,i_shop ";
	        $strSql .= "    ,i_color_shop ";
	        $strSql .= "  ) ";
	        $strSql .= "VALUES( ";
	        $strSql .= "  '$info[ref_id]' ";
	        $strSql .= "  ,'$info[ref_id]' ";
	        $strSql .= "  ,'$ref_no' ";
	        $strSql .= "  ,'$info[i_shop]' ";
	        $strSql .= "  ,'$info[i_shop]' ";
	        $strSql .= ") ";
	        $arr = array(
	            array("query" => "$strSql")
	        );
	        $reslut = $db->insert_for_upadte($arr);
				}else{
					$strSql = "";
	        $strSql .= "update tb_po_color ";
	        $strSql .= "set  ";
	        $strSql .= "i_shop = '$info[i_shop]' ";
	        $strSql .= ",i_color_shop = '$info[i_shop]' ";
	        $strSql .= ",d_update = " . $db->Sysdate(TRUE) . " ";
	        $strSql .= ",s_update_by = '$_SESSION[username]' ";
	        $strSql .= "where ref_id = '$info[ref_id]' ";
	        $arr = array(
	            array("query" => "$strSql")
	        );
	        $reslut = $db->insert_for_upadte($arr);
				}
				
				
				if($i_index < 10){
					$i_index = "0".$i_index;
				}
       $s_no = $ref_no."-P".$i_index;

				
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_po_color_list ( ";
        $strSql .= "    ref_id ";
        $strSql .= "    ,ref_no ";
        $strSql .= "    ,s_no ";
        $strSql .= "    ,s_code ";
        $strSql .= "    ,s_name ";
        $strSql .= "    ,i_amount ";
        $strSql .= "    ,d_order ";
        $strSql .= "    ,i_shop ";
        $strSql .= "    ,i_index ";
        $strSql .= "    ,d_create ";
        $strSql .= "    ,d_update ";
        $strSql .= "    ,s_create_by ";
        $strSql .= "    ,s_update_by ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[ref_id]' ";
        $strSql .= "  ,'$ref_no' ";
        $strSql .= "  ,'$s_no' ";
        $strSql .= "  ,'$info[s_code]' ";
        $strSql .= "  ,'$info[s_name]' ";
        $strSql .= "  ,'$info[i_amount]' ";
        $strSql .= "  ,'" . $util->DateSQL($info[d_order]) . "' ";
        $strSql .= "  ,'$info[i_shop]' ";
        $strSql .= "  ,$i_index ";
        $strSql .= "  ," . $db->Sysdate(TRUE) . " ";
        $strSql .= " 	," . $db->Sysdate(TRUE) . " ";
        $strSql .= "  ,'$_SESSION[username]' ";
        $strSql .= "  ,'$_SESSION[username]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        $last_id = mysql_insert_id();
    	return $reslut;
		}
		
		function recieveOrder($db, $info) {
    	$util = new Utility();
        $strSql = "";
        $strSql .= "update tb_po_color_list ";
        $strSql .= "set  ";
        $strSql .= "i_price = '$info[i_price]' ";
        $strSql .= ",i_receive = '$info[i_receive]' ";
        $strSql .= ",i_pay = '$info[i_pay]' ";
        $strSql .= ",s_store = '$info[s_store]' ";
        $strSql .= ",d_receive = '" . $util->DateSQL($info[d_receive]) . "' ";
        $strSql .= ",d_update = " . $db->Sysdate(TRUE) . " ";
        $strSql .= ",s_update_by = '$_SESSION[username]' ";
        $strSql .= "where s_no = '$info[s_no]' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        
        $strSql = "";
	        $strSql .= "update tb_po_color ";
	        $strSql .= "set  ";
	        $strSql .= "i_receive = '$info[i_receive]' ";
	        $strSql .= ",i_color_receive = '$info[i_receive]' ";
	        $strSql .= ",d_update = " . $db->Sysdate(TRUE) . " ";
	        $strSql .= ",s_update_by = '$_SESSION[username]' ";
	        $strSql .= "where ref_id = '$info[ref_id]' ";
	        $arr = array(
	            array("query" => "$strSql")
	        );
	        $reslut = $db->insert_for_upadte($arr);
        
    	return $reslut;
		}
        
        function withdrawOrder($db, $info) {
    	$util = new Utility();
        $strSql = "";
        $strSql .= "update tb_po_color_list ";
        $strSql .= "set  ";
        $strSql .= "i_withdraw = '$info[i_withdraw]' ";
        $strSql .= ",d_withdraw = '" . $util->DateSQL($info[d_withdraw]) . "' ";
        $strSql .= ",d_update = " . $db->Sysdate(TRUE) . " ";
        $strSql .= ",s_update_by = '$_SESSION[username]' ";
        $strSql .= "where s_no = '$info[s_no]' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
    	return $reslut;
		}
        
		
		
		
		
    function add($db, $info) {
    	$strSql = " select * ";
			$strSql .= " FROM tb_po_color  WHERE ref_no = '".$info[s_po_color_ref]."' ";
			$_dataTable = $db->Search_Data_FormatJson($strSql);
			
			$strSql = " select ref_no ";
			$strSql .= " FROM tb_customer_car WHERE i_cust_car = '".$info[s_po_color_ref]."' ";
			$customer_car = $db->Search_Data_FormatJson($strSql);
			
			$ref_no = $customer_car[0][ref_no];
			if($_dataTable == NULL){
				//$this->add_new($db, $info,$ref_no);
			}else{
				//$this->edit($db, $info,$ref_no);
			}
			
			return TRUE;
    }
    
    function add_new($db, $info,$ref_no) {
        $util = new Utility();

        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_po_color ( ";
        $strSql .= "    ref_no, ";
        $strSql .= "    s_po_color_ref, ";
        $strSql .= "    d_color_order, ";
        $strSql .= "    i_color_shop, ";
        $strSql .= "    i_color_receive, ";
        $strSql .= "    d_color_receive, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        //$strSql .= "  '$info[s_po_color_order]', ";
        $strSql .= "  '$info[s_po_color_ref]', ";
        $strSql .= "  '$ref_no', ";
        $strSql .= "  '" . $util->DateSQL($info[d_color_order]) . "', ";
        $strSql .= "  '$info[i_color_shop]', ";
        $strSql .= "  '$info[i_color_receive]', ";
        $strSql .= "  '" . $util->DateSQL($info[d_color_receive]) . "', ";
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
				 list($key, $s_po_color_order) = each ($_POST['s_po_color_order'])
				 and list($key, $i_color_price) = each ($_POST['i_color_price'])
				 and list($key, $i_color_amount) = each ($_POST['i_color_amount'])
				 and list($key, $s_color_code) = each ($_POST['s_po_color_code'])
				 
				 ){
       if($s_po_color_order != '' and $i_color_price != '' and $i_color_amount != '' and $s_color_code != ''){
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_po_color_order ( ";
        $strSql .= "    s_color_code, ";
        $strSql .= "    ref_no, ";
        $strSql .= "    i_po_color, ";
        $strSql .= "    s_po_color_order, ";
        $strSql .= "    i_color_price, ";
        $strSql .= "    i_color_amount, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$s_color_code', ";
        $strSql .= "  '$info[s_po_color_ref]', ";
        $strSql .= "  '$last_id', ";
        $strSql .= "  '$s_po_color_order', ";
        $strSql .= "  '$i_color_price', ";
        $strSql .= "  '$i_color_amount', ";
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

    function edit($db, $info,$ref_no) {
        
        $util = new Utility();
        $strSql = "";
        $strSql .= "update tb_po_color ";
        $strSql .= "set  ";
        $strSql .= "s_po_color_ref = '$ref_no', ";
        $strSql .= "ref_no = '$info[s_po_color_ref]', ";
        $strSql .= "i_color_shop = '$info[i_color_shop]', ";
        $strSql .= "d_color_order = '" . $util->DateSQL($info[d_color_order]) . "', ";
        $strSql .= "d_color_receive = '" . $util->DateSQL($info[d_color_receive]) . "', ";
        $strSql .= "i_color_receive = $info[i_color_receive], ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]', ";
        $strSql .= "s_status = '$info[status]' ";
        $strSql .= "where ref_no = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        
        $last_id = $info[id];
        mysql_query("DELETE FROM tb_po_color_order WHERE ref_no='$last_id' ");
 
				 while(
				 list($key, $s_po_color_order) = each ($_POST['s_po_color_order'])
				 and list($key, $i_color_price) = each ($_POST['i_color_price'])
				 and list($key, $i_color_amount) = each ($_POST['i_color_amount'])
				 and list($key, $s_color_code) = each ($_POST['s_po_color_code'])
				 
				 ){
       if($s_po_color_order != '' and $i_color_price != '' and $i_color_amount != '' and $s_color_code != ''){
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_po_color_order ( ";
        $strSql .= "    s_color_code, ";
        $strSql .= "    ref_no, ";
        $strSql .= "    i_po_color, ";
        $strSql .= "    s_po_color_order, ";
        $strSql .= "    i_color_price, ";
        $strSql .= "    i_color_amount, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$s_color_code', ";
        $strSql .= "  '$info[s_po_color_ref]', ";
        $strSql .= "  '$last_id', ";
        $strSql .= "  '$s_po_color_order', ";
        $strSql .= "  '$i_color_price', ";
        $strSql .= "  '$i_color_amount', ";
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
