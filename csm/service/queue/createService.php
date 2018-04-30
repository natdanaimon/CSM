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

    function dataTableR10() {
        $db = new ConnectDB();
        $strSql = " select *, i_year , '' as i_brand , '' as i_gen , '' as i_sub from ";
        $strSql .= " (";
        $strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
        $strSql .= " from tb_customer_car u, tb_status s";
        $strSql .= " where u.s_status = s.s_status";
        $strSql .= " and s.s_type = 'REPAIR'";
        $strSql .= " and s.s_status ='RX' ";
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

        
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        return $_data;

        //return $strSql;



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
    
    function dataTableStaff($id) {
        $db = new ConnectDB();
         $strSql = "select s.*,e.s_firstname , e.s_lastname";
        $strSql .= " from   tb_queue_dept_staff s  ";
        $strSql .= " LEFT JOIN  tb_employee e ON  e.i_emp = s.i_staff";
        $strSql .= " where  s.i_queue_dept = '".$id."'" ;
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
    
    function getInfoRef($seq) {
        $db = new ConnectDB();
        $strSql = " select * from tb_customer_car where ref_no =" . $seq;
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

        $strSql = " select ref_no from tb_queue where ref_no = '".$info[s_queue_ref]."' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $count = count($_data);
        
        if($count < 1){
					
				
        
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_queue ( ";
        $strSql .= "    ref_no, ";
        $strSql .= "    d_auto_end, ";
        $strSql .= "    d_fix_date, ";
        //$strSql .= "    i_dept_start, ";
        //$strSql .= "    i_emcs, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by, ";
        $strSql .= "    s_status ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[s_queue_ref]', ";
        $strSql .= "  '" . $util->DateSQL($info[d_sendcar]) . "', ";
        $strSql .= "  '" . $util->DateSQL($info[d_fix_date]) . "', ";
        //$strSql .= "  '$info[i_dept_start]', ";
        //$strSql .= "  '$info[i_emcs]', ";
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
        
 
        
        
        ////////////////////////////// Start Dept
        $p_i_dept_date = "i_dept_date".$info[i_dept_start];
        $total = $info[$p_i_dept_date]*1;
    	$d_inbound = $info[d_inbound];
$newDate = date("Y-m-d", strtotime($d_inbound));
        $newTotal = 0;
        $checkDate = "";
        for($i=1; $i <= $total; $i++){
					$d_end_dpet_start = date("d-m-Y", strtotime($newDate."-".$i." days"));
					$weekDay = date('w', strtotime($d_end_dpet_start));
					$checkDate .= " ".$weekDay;
					if($weekDay == 0){
						$newTotal -= 2;
					}else{
						$newTotal--;
					}
				}	
$d_end_dpet_start = date("d-m-Y", strtotime($newDate."-".$newTotal." days"));
$weekDay = date('w', strtotime($d_end_dpet_start));
$newDate = date("Y-m-d", strtotime($d_end_dpet_start));
					if($weekDay == 0){
						$newTotal = 2;
					}else{
						$newTotal = 1;
					}
//$d_inbound_dept_start_loop =  date("d-m-Y", strtotime($newDate."-".$newTotal." days")); 
$d_inbound_dept_start_loop =  $info[d_sendcar]; 

       
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_queue_dept ( ";
        $strSql .= "    i_queue, ";
        $strSql .= "    i_dept, ";
        $strSql .= "    i_dept_date, ";
        $strSql .= "    d_start, ";
        $strSql .= "    d_end, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$last_id', ";
        $strSql .= "  '" . $info[i_dept_start] . "', ";
        $strSql .= "  '".$info[$p_i_dept_date]."', ";
        $strSql .= "  '" . $util->DateSQL($d_inbound) . "', ";
        $strSql .= "  '" . $util->DateSQL($d_end_dpet_start) . "', ";
        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        //$resluts = $db->insert_for_upadte($arr);
        ////////////////////////////// Start Dept
        
        
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_department b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
        //$strSql .= " and    b.i_dept   <>  '$info[i_dept_start]' ";
        $strSql .= " order by b.i_index desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
 
        foreach($_data as $data){
        	
        	if($info[i_dept_start] == $data[i_dept]){
						$i_dept_start = 1;
					}else{
						$i_dept_start = 0;
					}
        	
        	
        	$p_i_dept_date = "i_dept_date".$data[i_dept];
        	$total = $info[$p_i_dept_date]*1;
    	$d_inbound = $d_inbound_dept_start_loop;
$newDate = date("Y-m-d", strtotime($d_inbound));
        $newTotal = 0;
        $checkDate = "";
        for($i=1; $i <= $total; $i++){
					$d_end_dpet_start = date("d-m-Y", strtotime($newDate."-".$i." days"));
					$weekDay = date('w', strtotime($d_end_dpet_start));
					$checkDate .= " ".$weekDay;
					if($weekDay == 0){
						$newTotal -= 2;
					}else{
						$newTotal--;
					}
				}	
$d_end_dpet_start = date("d-m-Y", strtotime($newDate."+".$newTotal." days"));
$weekDay = date('w', strtotime($d_end_dpet_start));
$newDate = date("Y-m-d", strtotime($d_end_dpet_start));
					if($weekDay == 0){
						$newTotal = 2;
					}else{
						$newTotal = 1;
					}
$d_inbound_dept_start_loop =  date("d-m-Y", strtotime($newDate."-".$newTotal." days")); 


        
        
        
        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_queue_dept ( ";
        $strSql .= "    i_queue, ";
        $strSql .= "    i_dept, ";
        $strSql .= "    i_dept_date, ";
        $strSql .= "    d_start, ";
        $strSql .= "    d_end, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$last_id', ";
        $strSql .= "  '" . $data[i_dept] . "', ";
        $strSql .= "  '".$info[$p_i_dept_date]."', ";
        $strSql .= "  '" . $util->DateSQL($d_inbound) . "', ";
        $strSql .= "  '" . $util->DateSQL($d_end_dpet_start) . "', ";
        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $resluts = $db->insert_for_upadte($arr);
		}
        
        
        
        return $reslut;
    
    }
    
    else{
			///////////////////////////// Edit
					
				

        $strSql = "";
        $strSql .= "update tb_queue ";
        $strSql .= "set  ";
        $strSql .= "d_auto_end = '" . $util->DateSQL($info[d_sendcar]) . "', ";
        $strSql .= "d_fix_date = '" . $util->DateSQL($info[d_fix_date]) . "', ";
        $strSql .= "i_emcs = '$info[i_emcs]', ";
        $strSql .= "i_dept_start = '$info[i_dept_start]', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]' ";
        $strSql .= "where ref_no = '$info[s_queue_ref]' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        
        
        $strSql = " select i_queue from tb_queue where ref_no =" . $info[s_queue_ref];
        $_data = $db->Search_Data_FormatJson($strSql);
        foreach($_data as $aa){
					$last_id = $aa[i_queue];
				}       
        ////////////////////////////// Start Dept
        $p_i_dept_date = "i_dept_date".$info[i_dept_start];
        $total = $info[$p_i_dept_date]*1;
    	$d_inbound = $info[d_inbound];
$newDate = date("Y-m-d", strtotime($d_inbound));
        $newTotal = 0;
        $checkDate = "";
        for($i=1; $i <= $total; $i++){
					$d_end_dpet_start = date("d-m-Y", strtotime($newDate."-".$i." days"));
					$weekDay = date('w', strtotime($d_end_dpet_start));
					$checkDate .= " ".$weekDay;
					if($weekDay == 0){
						$newTotal -= 2;
					}else{
						$newTotal--;
					}
				}	
				//$newTotal = $newTotal - 1 ;
$d_end_dpet_start = date("d-m-Y", strtotime($newDate."-".$newTotal." days"));
$weekDay = date('w', strtotime($d_end_dpet_start));
$newDate = date("Y-m-d", strtotime($d_end_dpet_start));
					if($weekDay == 0){
						$newTotal = 2;
					}else{
						$newTotal = 1;
					}
//$d_inbound_dept_start_loop =  date("d-m-Y", strtotime($newDate."-".$newTotal." days")); 
$d_inbound_dept_start_loop =  $info[d_sendcar]; 

       
        $strSql = "";
        $strSql .= "update tb_queue_dept ";
        $strSql .= "set  ";
        $strSql .= "d_start = '" . $util->DateSQL($d_inbound) . "', ";
        $strSql .= "d_end = '" . $util->DateSQL($d_end_dpet_start) . "', ";
        $strSql .= "i_dept_date = '".$info[$p_i_dept_date]."', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]' ";
        $strSql .= "where i_queue = '$last_id' and i_dept = '$info[i_dept_start]' ";
        $arr = array(
            array("query" => "$strSql")
        );
        //$resluts = $db->insert_for_upadte($arr);
        
        ////////////////////////////// Start Dept
        
        
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_department b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
       // $strSql .= " and    b.i_dept   <>  '$info[i_dept_start]' ";
        $strSql .= " order by b.i_index desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
 
        foreach($_data as $data){
        	
        	if($info[i_dept_start] == $data[i_dept]){
						$i_dept_start = 1;
					}else{
						$i_dept_start = 0;
					}
        	
        	
        	$p_i_dept_date = "i_dept_date".$data[i_dept];
        	$total = $info[$p_i_dept_date]*1;
    	$d_inbound = $d_inbound_dept_start_loop;
$newDate = date("Y-m-d", strtotime($d_inbound));
        $newTotal = 0;
        $checkDate = "";
        for($i=1; $i <= $total; $i++){
					$d_end_dpet_start = date("d-m-Y", strtotime($newDate."-".$i." days"));
					$weekDay = date('w', strtotime($d_end_dpet_start));
					$checkDate .= " ".$weekDay;
					if($weekDay == 0){
						$newTotal -= 2;
					}else{
						$newTotal--;
					}
				}	
$d_end_dpet_start = date("d-m-Y", strtotime($newDate."+".$newTotal." days"));
$weekDay = date('w', strtotime($d_end_dpet_start));
$newDate = date("Y-m-d", strtotime($d_end_dpet_start));
					if($weekDay == 0){
						$newTotal = 2;
					}else{
						$newTotal = 1;
					}
$d_inbound_dept_start_loop =  date("d-m-Y", strtotime($newDate."-".$newTotal." days")); 


        
        $strSql = "";
        $strSql .= "update tb_queue_dept ";
        $strSql .= "set  ";
        //$strSql .= "d_start = '" . $util->DateSQL($d_inbound) . "', ";
        $strSql .= "d_end = '" . $util->DateSQL($d_inbound) . "', ";
        $strSql .= "d_start = '" . $util->DateSQL($d_end_dpet_start) . "', ";
        $strSql .= "i_dept_date = '".$info[$p_i_dept_date]."', ";
        $strSql .= "d_update = " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "s_update_by = '$_SESSION[username]' ";
        $strSql .= "where i_queue = '$last_id' and i_dept = '$data[i_dept]' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $resluts = $db->insert_for_upadte($arr);
        
		
        

        
        
        }



/******************/
 
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_department b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
       // $strSql .= " and    b.i_dept   <>  '$info[i_dept_start]' ";
        $strSql .= " order by b.i_index desc ";
        $_data = $db->Search_Data_FormatJson($strSql);
 
        foreach($_data as $data){
$p_i_dept_date = "i_dept_date".$data[i_dept];
$total = $info[$p_i_dept_date]*1;
if($total > 0){
$depart_start = $data[i_dept];
}

        }
$strSql = "";
        $strSql .= "update tb_queue ";
        $strSql .= "set  ";
        $strSql .= "i_dept_start = '".$depart_start."'";
        $strSql .= "where i_queue = '$last_id' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);

$strSql = "";
        $strSql .= "update tb_queue_dept ";
        $strSql .= "set  ";
        $strSql .= "i_active = '1'";
        $strSql .= "where i_queue = '$last_id'  and i_dept = '".$depart_start."' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);



if($depart_start == 1){  $s_status = "R4";  }
if($depart_start == 2){  $s_status = "R5";  }
if($depart_start == 3){  $s_status = "R6";  }
if($depart_start == 4){  $s_status = "R7";  }
if($depart_start == 5){  $s_status = "R8";  }
if($depart_start == 6){  $s_status = "R9";  }
if($depart_start == 7){  $s_status = "R10";  }


 $strSql = "";
        $strSql .= "update tb_customer_car ";
        $strSql .= "set  ";
        $strSql .= "s_status = '".$s_status."' ";
        $strSql .= "where ref_no = '$info[s_queue_ref]'  ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);


        

        return $reslut;
    
		
		}
    
    
    
    
    
    }

	function addStaff($db, $info) {
        $util = new Utility();


        $strSql = "";
        $strSql .= "INSERT ";
        $strSql .= "INTO ";
        $strSql .= "  tb_queue_dept_staff ( ";
        $strSql .= "    i_queue_dept, ";
        $strSql .= "    i_staff, ";
        $strSql .= "    d_start_work, ";
        $strSql .= "    d_create, ";
        $strSql .= "    d_update, ";
        $strSql .= "    s_create_by, ";
        $strSql .= "    s_update_by ";
        $strSql .= "  ) ";
        $strSql .= "VALUES( ";
        $strSql .= "  '$info[i_queue_dept_staff]', ";
        $strSql .= "  '$info[i_staff_id]', ";


        $strSql .= "  '" . $info[d_start_work] . "', ";

        $strSql .= "  " . $db->Sysdate(TRUE) . ", ";
        $strSql .= " " . $db->Sysdate(TRUE) . ", ";
        $strSql .= "  '$_SESSION[username]', ";
        $strSql .= "  '$_SESSION[username]' ";
        $strSql .= ") ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        $last_id = mysql_insert_id();
        
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
        
        
        return $reslut;
    }
    
    
    function UpdateStatus($db, $info) {
        $util = new Utility();
        $strSql = "";
        $strSql .= "update tb_queue_dept ";
        $strSql .= "set  ";
        $strSql .= "i_status = '$info[i_status]' ";
        $strSql .= "where i_queue_dept = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        $last_id = $info[id];

        
        if($info[i_status] == 1){
            $active = 0;
            $next_active = 1;
        }else{
            $active = 1;
             $next_active = 0;
        }
 $strSql = "";
        $strSql .= "update tb_queue_dept ";
        $strSql .= "set  ";
        $strSql .= "i_active= '".$active."' ";
        $strSql .= "where i_queue_dept = $info[id] ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);




        $strSql = "select* ";
        $strSql .= " from  tb_queue_dept  ";
        $strSql .= " where    i_queue = '".$info[i_queue]."' ";
        $strSql .= " and    i_dept <> '".$info[id]."' ";
        $strSql .= " and    i_status <> '1' ";
        $strSql .= " order by i_queue_dept asc ";
        $_data = $db->Search_Data_FormatJson($strSql);
 
        foreach($_data as $data){
            $total = $data[i_dept_date]*1;
            if($total > 0){
            $depart_start = $data[i_dept];
            }
        }

if($depart_start == 1){  $s_status = "R4";  }
elseif($depart_start == 2){  $s_status = "R5";  }
elseif($depart_start == 3){  $s_status = "R6";  }
elseif($depart_start == 4){  $s_status = "R7";  }
elseif($depart_start == 5){  $s_status = "R8";  }
elseif($depart_start == 6){  $s_status = "R9";  }
elseif($depart_start == 7){  $s_status = "R10";  }
else{ $s_status = "R11"; }


 $strSql = "";
        $strSql .= "update tb_customer_car ";
        $strSql .= "set  ";
        $strSql .= "s_status = '".$s_status."' ";
        $strSql .= "where ref_no = '$info[ref_no]'  ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);




$strSql = "";
        $strSql .= "update tb_queue_dept ";
        $strSql .= "set  ";
        $strSql .= "i_active = '".$next_active."'";
        $strSql .= "where i_queue = '".$info[i_queue]."'  and i_dept = '".$depart_start."' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $reslut = $db->insert_for_upadte($arr);
        
        return $reslut;
    }

    
    function addssss($db, $info) {
    	$strSql = " select ref_no from tb_queue where ref_no = '".$info[s_queue_ref]."' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        //$db->close_conn();
        $count = count($_data);
        if($count > 0){
					return add_new($db, $info);
				}else{
					return add_new($db, $info);
				}
				//return TRUE;
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
