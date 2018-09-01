<?php

@session_start();

class createService {

  function dataTableQuotation() {
    $db = new ConnectDB();
    $strSql = " SELECT * ";
    $strSql .= " FROM tb_report_quotation  ";
    $strSql .= " order by id desc ";
    $_data = $db->Search_Data_FormatJson($strSql);
    $db->close_conn();
    return $_data;
  }

  function dataTableInvoice() {
    $db = new ConnectDB();
    $strSql = " SELECT * ";
    $strSql .= " FROM tb_report_invoice  ";
    $strSql .= " order by id desc ";
    $_data = $db->Search_Data_FormatJson($strSql);
    $db->close_conn();
    return $_data;
  }

  function dataTableWithholding() {
    $db = new ConnectDB();
    $strSql = " SELECT * ";
    $strSql .= " FROM tb_report_withholding  ";
    $strSql .= " order by id desc ";
    $_data = $db->Search_Data_FormatJson($strSql);
    $db->close_conn();
    return $_data;
  }

  function dataTableReceipt() {
    $db = new ConnectDB();
    $strSql = " SELECT * ";
    $strSql .= " FROM tb_report_receipt  ";
    $strSql .= " order by id desc ";
    $_data = $db->Search_Data_FormatJson($strSql);
    $db->close_conn();
    return $_data;
  }
  function dataTableBill() {
    $db = new ConnectDB();
    $strSql = " SELECT * ";
    $strSql .= " FROM tb_report_bill  ";
    $strSql .= " order by id desc ";
    $_data = $db->Search_Data_FormatJson($strSql);
    $db->close_conn();
    return $_data;
  }

  function getDetail($db,$info) {

    $strSql = "";
    $strSql .= " SELECT ";
    $strSql .= " car.* ";
    $strSql .= " ,cus.s_firstname , cus.s_lastname , cus.s_address ,cus.s_phone_1 , cus.s_phone_2,cus.s_tax_no";
    $strSql .= " ,ins.s_name_display ";
    $strSql .= " ,brand.s_brand_name ";
    $strSql .= " ,gen.s_gen_name ";
    $strSql .= " ,pay.s_detail ";
    $strSql .= " FROM tb_customer_car car ";
    $strSql .= " LEFT JOIN tb_customer cus ON car.i_customer = cus.i_customer ";
    $strSql .= " LEFT JOIN tb_insurance_comp ins ON car.i_ins_comp = ins.i_ins_comp ";
    $strSql .= " LEFT JOIN tb_car_brand brand ON car.s_brand_code = brand.s_brand_code ";
    $strSql .= " LEFT JOIN tb_car_generation gen ON car.s_gen_code = gen.s_gen_code ";
    $strSql .= " LEFT JOIN tb_pay pay ON car.s_pay_type = pay.s_pay_type ";
    $strSql .= " WHERE car.ref_no =".$info[ref];

    $_data = $db->Search_Data_FormatJson($strSql);
    $db->close_conn();

    $response[td_name] = $_data[0][s_firstname]." ".$_data[0][s_lastname];
    $response[s_firstname] = $_data[0][s_firstname];
    $response[s_lastname] = $_data[0][s_lastname];
    $response[s_address] = $_data[0][s_address];
    $response[td_ins_comp] = $_data[0][s_name_display];
    $response[td_band] = $_data[0][s_brand_name];
    $response[td_gen] = $_data[0][s_gen_name];
    $response[td_pay_type] = $_data[0][s_detail];
    $response[td_license] = $_data[0][s_license];
    $response[s_tax_no] = $_data[0][s_tax_no];
    return $response;
  }

  function addQuatation($db,$info) {
    $util = new Utility();
    $strSql = "";
    $strSql .= "INSERT ";
    $strSql .= "INTO ";
    $strSql .= "  tb_report_quotation ( ";
    $strSql .= "    ref_id ";
    $strSql .= "    ,i_amount ";
    $strSql .= "    ,s_no_bill ";
    $strSql .= "    ,ref_no ";
    $strSql .= "    ,s_license ";
    $strSql .= "    ,s_province ";
    $strSql .= "    ,s_name ";
    $strSql .= "    ,s_address ";
    $strSql .= "    ,s_tax_no ";
    $strSql .= "    ,d_create ";
    $strSql .= "    ,d_update ";
    $strSql .= "    ,s_create_by ";
    $strSql .= "    ,s_update_by ";
    $strSql .= "  ) ";
    $strSql .= "VALUES( ";
    $strSql .= "  '$info[id]' ";
    $strSql .= "  ,'".$info[i_amount]."' ";
    $strSql .= "  ,'".$info[s_no_bill]."' ";
    $strSql .= "  ,'".$info[ref_no]."' ";
    $strSql .= "  ,'".$info[s_license]."' ";
    $strSql .= "  ,'".$info[s_province]."' ";
    $strSql .= "  ,'".$info[s_name]."' ";
    $strSql .= "  ,'".$info[s_address]."' ";
    $strSql .= "  ,'".$info[s_tax_no]."' ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= ") ";
    $arr = array(
        array("query" => "$strSql")
    );
    $reslut = $db->insert_for_upadte($arr);
    $id = mysql_insert_id();
//////////// List
    while (
    list($key,$s_list_code) = each($_POST['s_list_code'])
    and list($key,$s_list_name) = each($_POST['s_list_name'])
    and list($key,$s_list_detail) = each($_POST['s_list_detail'])
    and list($key,$s_list_amount) = each($_POST['s_list_amount'])
    and list($key,$s_list_price) = each($_POST['s_list_price'])
    ) {
      $strSql = "";
      $strSql .= "INSERT ";
      $strSql .= "INTO ";
      $strSql .= "  tb_report_quotation_list ( ";
      $strSql .= "    i_report_quotation ";
      $strSql .= "    ,s_list_code ";
      $strSql .= "    ,s_list_name ";
      $strSql .= "    ,s_list_detail ";
      $strSql .= "    ,s_list_amount ";
      $strSql .= "    ,s_list_price ";
      $strSql .= "  ) ";
      $strSql .= "VALUES( ";
      $strSql .= "  '$id' ";
      $strSql .= "  ,'".$s_list_code."' ";
      $strSql .= "  ,'".$s_list_name."' ";
      $strSql .= "  ,'".$s_list_detail."' ";
      $strSql .= "  ,'".$s_list_amount."' ";
      $strSql .= "  ,'".$s_list_price."' ";
      $strSql .= ") ";
      $arr = array(
          array("query" => "$strSql")
      );
      $reslut = $db->insert_for_upadte($arr);
    }
    return $id;
  }

  function add($db,$info) {
    $util = new Utility();
    $ref_no = $info[s_po_spare_ref];

    $strSql = " select * ";
    $strSql .= " FROM tb_report_receive  WHERE ref_id = '".$info[ref_id]."' ";
    $_dataTable = $db->Search_Data_FormatJson($strSql);

    if ($_dataTable[0][id] > 0) {
      $strSql = "";
      $strSql .= "update tb_report_receive ";
      $strSql .= "set  ";
      $strSql .= "s_no = '$info[s_no]' ";
      $strSql .= ",s_color = '$info[s_color]' ";
      $strSql .= ",s_fuel = '$info[s_fuel]' ";
      $strSql .= ",s_distance = '$info[s_distance]' ";
      $strSql .= ",s_remark = '$info[s_remark]' ";
      $strSql .= ",d_update = ".$db->Sysdate(TRUE)." ";
      $strSql .= ",s_update_by = '$_SESSION[username]' ";
      $strSql .= "where ref_id = '$info[ref_id]' ";
      $arr = array(
          array("query" => "$strSql")
      );
      $reslut = $db->insert_for_upadte($arr);
    } else {
      $strSql = "";
      $strSql .= "INSERT ";
      $strSql .= "INTO ";
      $strSql .= "  tb_report_receive ( ";
      $strSql .= "    ref_id ";
      $strSql .= "    ,s_no ";
      $strSql .= "    ,s_color ";
      $strSql .= "    ,s_fuel ";
      $strSql .= "    ,s_distance ";
      $strSql .= "    ,s_remark ";
      $strSql .= "    ,d_create ";
      $strSql .= "    ,d_update ";
      $strSql .= "    ,s_create_by ";
      $strSql .= "    ,s_update_by ";
      $strSql .= "  ) ";
      $strSql .= "VALUES( ";
      $strSql .= "  '$info[ref_id]' ";
      $strSql .= "  ,'$info[s_no]' ";
      $strSql .= "  ,'$info[s_color]' ";
      $strSql .= "  ,'$info[s_fuel]' ";
      $strSql .= "  ,'$info[s_distance]' ";
      $strSql .= "  ,'$info[s_remark]' ";
      $strSql .= "  ,".$db->Sysdate(TRUE)." ";
      $strSql .= "  ,".$db->Sysdate(TRUE)." ";
      $strSql .= "  ,'$_SESSION[username]' ";
      $strSql .= "  ,'$_SESSION[username]' ";
      $strSql .= ") ";
      $arr = array(
          array("query" => "$strSql")
      );
      $reslut = $db->insert_for_upadte($arr);
    }

    mysql_query("DELETE FROM tb_report_accessories WHERE ref_id='$info[ref_id]' ");
    $strSql = " select * ";
    $strSql .= " FROM 	tb_car_accessories  order by id  ";
    $car_accessories = $db->Search_Data_FormatJson($strSql);
    foreach ($car_accessories as $data) {
      $i_accessories_val = "i_accessories_".$data[id];
      $i_accessories = $info[$i_accessories_val];
      if ($i_accessories > 0) {
        $i_status = 1;
      } else {
        $i_status = 0;
      }
      $i_status = $i_accessories;

      $strSql = "";
      $strSql .= "INSERT ";
      $strSql .= "INTO ";
      $strSql .= "  tb_report_accessories ( ";
      $strSql .= "    ref_id ";
      $strSql .= "    ,i_accessories ";
      $strSql .= "    ,i_status ";
      $strSql .= "    ,d_create ";
      $strSql .= "    ,d_update ";
      $strSql .= "    ,s_create_by ";
      $strSql .= "    ,s_update_by ";
      $strSql .= "  ) ";
      $strSql .= "VALUES( ";
      $strSql .= "  '$info[ref_id]' ";
      $strSql .= "  ,'$data[id]' ";
      $strSql .= "  ,'$i_status' ";
      $strSql .= "  ,".$db->Sysdate(TRUE)." ";
      $strSql .= " ,".$db->Sysdate(TRUE)." ";
      $strSql .= "  ,'$_SESSION[username]' ";
      $strSql .= "  ,'$_SESSION[username]' ";
      $strSql .= ") ";
      $arr = array(
          array("query" => "$strSql")
      );
      $reslut = $db->insert_for_upadte($arr);
    }

    mysql_query("DELETE FROM tb_report_lighting WHERE ref_id='$info[ref_id]' ");
    $strSql = " select * ";
    $strSql .= " FROM 	tb_car_lighting  order by id  ";
    $car_lighting = $db->Search_Data_FormatJson($strSql);
    foreach ($car_lighting as $data) {
      $i_lighting_val = "i_lighting_".$data[id];
      $i_lighting = $info[$i_lighting_val];
      if ($i_lighting > 0) {
        $i_status = 1;
      } else {
        $i_status = 0;
      }
      $i_status = $i_lighting;
      $strSql = "";
      $strSql .= "INSERT ";
      $strSql .= "INTO ";
      $strSql .= "  tb_report_lighting ( ";
      $strSql .= "    ref_id ";
      $strSql .= "    ,i_lighting ";
      $strSql .= "    ,i_status ";
      $strSql .= "    ,d_create ";
      $strSql .= "    ,d_update ";
      $strSql .= "    ,s_create_by ";
      $strSql .= "    ,s_update_by ";
      $strSql .= "  ) ";
      $strSql .= "VALUES( ";
      $strSql .= "  '$info[ref_id]' ";
      $strSql .= "  ,'$data[id]' ";
      $strSql .= "  ,'$i_status' ";
      $strSql .= "  ,".$db->Sysdate(TRUE)." ";
      $strSql .= " ,".$db->Sysdate(TRUE)." ";
      $strSql .= "  ,'$_SESSION[username]' ";
      $strSql .= "  ,'$_SESSION[username]' ";
      $strSql .= ") ";
      $arr = array(
          array("query" => "$strSql")
      );
      $reslut = $db->insert_for_upadte($arr);
    }

    return $reslut;
  }

  function addWithholding($db,$info) {
    $util = new Utility();
    $s_detail = json_encode($info);
    $strSql = " select * ";
    $strSql .= " FROM tb_report_withholding  WHERE ref_id = '".$info[id]."' ";
    $_dataTable = $db->Search_Data_FormatJson($strSql);
    //if ($_dataTable[0][id] > 0) {
//      $strSql = "";
//      $strSql .= "update tb_report_withholding ";
//      $strSql .= "set  ";
//      $strSql .= "s_detail = '".$s_detail."' ";
//      $strSql .= ",d_update = ".$db->Sysdate(TRUE)." ";
//      $strSql .= ",s_update_by = '$_SESSION[username]' ";
//      $strSql .= "where ref_id = '$info[id]' ";
//      $arr = array(
//          array("query" => "$strSql")
//      );
//      $reslut = $db->insert_for_upadte($arr);
    //} else {
    $strSql = "";
    $strSql .= "INSERT ";
    $strSql .= "INTO ";
    $strSql .= "  tb_report_withholding ( ";
    $strSql .= "    ref_id ";
    $strSql .= "    ,d_date ";
    $strSql .= "    ,s_name ";
    $strSql .= "    ,s_address ";
    $strSql .= "    ,s_code ";
    $strSql .= "    ,s_identi ";
    $strSql .= "    ,s_tax ";
    $strSql .= "    ,s_tax1 ";
    $strSql .= "    ,s_tax2 ";
    $strSql .= "    ,s_tax3 ";
    $strSql .= "    ,s_tax4 ";
    $strSql .= "    ,s_tax411 ";
    $strSql .= "    ,s_tax412 ";
    $strSql .= "    ,s_tax413 ";
    $strSql .= "    ,s_tax414 ";
    $strSql .= "    ,s_per414 ";
    $strSql .= "    ,s_tax421 ";
    $strSql .= "    ,s_tax422 ";
    $strSql .= "    ,s_tax423 ";
    $strSql .= "    ,s_tax424 ";
    $strSql .= "    ,s_tax425 ";
    $strSql .= "    ,s_tax5 ";
    $strSql .= "    ,s_tax6 ";
    $strSql .= "    ,s_tax7 ";
    $strSql .= "    ,s_tax8 ";
    $strSql .= "    ,d_create ";
    $strSql .= "    ,d_update ";
    $strSql .= "    ,s_create_by ";
    $strSql .= "    ,s_update_by ";
    $strSql .= "  ) ";
    $strSql .= "VALUES( ";
    $strSql .= "  '$info[id]' ";
    $strSql .= "  ,'".date('Y-m-d')."' ";
    $strSql .= "  ,'".$info[s_name]."' ";
    $strSql .= "  ,'".$info[s_address]."' ";
    $strSql .= "  ,'".$info[s_code]."' ";
    $strSql .= "  ,'".$info[s_identi]."' ";
    $strSql .= "  ,'".$info[s_tax]."' ";
    $strSql .= "  ,'".$info[s_tax1]."' ";
    $strSql .= "  ,'".$info[s_tax2]."' ";
    $strSql .= "  ,'".$info[s_tax3]."' ";
    $strSql .= "  ,'".$info[s_tax4]."' ";
    $strSql .= "  ,'".$info[s_tax411]."' ";
    $strSql .= "  ,'".$info[s_tax412]."' ";
    $strSql .= "  ,'".$info[s_tax413]."' ";
    $strSql .= "  ,'".$info[s_tax414]."' ";
    $strSql .= "  ,'".$info[s_per414]."' ";
    $strSql .= "  ,'".$info[s_tax421]."' ";
    $strSql .= "  ,'".$info[s_tax422]."' ";
    $strSql .= "  ,'".$info[s_tax423]."' ";
    $strSql .= "  ,'".$info[s_tax424]."' ";
    $strSql .= "  ,'".$info[s_tax425]."' ";
    $strSql .= "  ,'".$info[s_tax5]."' ";
    $strSql .= "  ,'".$info[s_tax6]."' ";
    $strSql .= "  ,'".$info[s_tax7]."' ";
    $strSql .= "  ,'".$info[s_tax8]."' ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= ") ";
    $arr = array(
        array("query" => "$strSql")
    );
    $reslut = $db->insert_for_upadte($arr);

    //}
    return mysql_insert_id();
  }

  function addInvoice($db,$info) {
    $util = new Utility();
    $strSql = "";
    $strSql .= "INSERT ";
    $strSql .= "INTO ";
    $strSql .= "  tb_report_invoice ( ";
    $strSql .= "    ref_id ";
    $strSql .= "    ,s_no ";
    $strSql .= "    ,i_amount ";
    $strSql .= "    ,s_no_bill ";
    $strSql .= "    ,ref_no ";
    $strSql .= "    ,s_license ";
    $strSql .= "    ,s_province ";
    $strSql .= "    ,s_name ";
    $strSql .= "    ,s_address ";
    $strSql .= "    ,s_tax_no ";
    $strSql .= "    ,d_create ";
    $strSql .= "    ,d_update ";
    $strSql .= "    ,s_create_by ";
    $strSql .= "    ,s_update_by ";
    $strSql .= "  ) ";
    $strSql .= "VALUES( ";
    $strSql .= "  '$info[id]' ";
    $strSql .= "  ,'".$info[s_no]."' ";
    $strSql .= "  ,'".$info[i_amount]."' ";
    $strSql .= "  ,'".$info[s_no_bill]."' ";
    $strSql .= "  ,'".$info[ref_no]."' ";
    $strSql .= "  ,'".$info[s_license]."' ";
    $strSql .= "  ,'".$info[s_province]."' ";
    $strSql .= "  ,'".$info[s_name]."' ";
    $strSql .= "  ,'".$info[s_address]."' ";
    $strSql .= "  ,'".$info[s_tax_no]."' ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= ") ";
    $arr = array(
        array("query" => "$strSql")
    );
    $reslut = $db->insert_for_upadte($arr);
    $id = mysql_insert_id();
//////////// List
    while (
    list($key,$s_list_code) = each($_POST['s_list_code'])
    and list($key,$s_list_name) = each($_POST['s_list_name'])
    and list($key,$s_list_detail) = each($_POST['s_list_detail'])
    and list($key,$s_list_amount) = each($_POST['s_list_amount'])
    and list($key,$s_list_price) = each($_POST['s_list_price'])
    ) {
      $strSql = "";
      $strSql .= "INSERT ";
      $strSql .= "INTO ";
      $strSql .= "  tb_report_invoice_list ( ";
      $strSql .= "    i_report_invoice ";
      $strSql .= "    ,s_list_code ";
      $strSql .= "    ,s_list_name ";
      $strSql .= "    ,s_list_detail ";
      $strSql .= "    ,s_list_amount ";
      $strSql .= "    ,s_list_price ";
      $strSql .= "  ) ";
      $strSql .= "VALUES( ";
      $strSql .= "  '$id' ";
      $strSql .= "  ,'".$s_list_code."' ";
      $strSql .= "  ,'".$s_list_name."' ";
      $strSql .= "  ,'".$s_list_detail."' ";
      $strSql .= "  ,'".$s_list_amount."' ";
      $strSql .= "  ,'".$s_list_price."' ";
      $strSql .= ") ";
      $arr = array(
          array("query" => "$strSql")
      );
      $reslut = $db->insert_for_upadte($arr);
    }
    return $id;
  }

  function addReceipt($db,$info) {
    $util = new Utility();
    $strSql = "";
    $strSql .= "INSERT ";
    $strSql .= "INTO ";
    $strSql .= "  tb_report_receipt ( ";
    $strSql .= "    ref_id ";
    $strSql .= "    ,s_no ";
    $strSql .= "    ,s_no_bill ";
    $strSql .= "    ,ref_no ";
    $strSql .= "    ,s_license ";
    $strSql .= "    ,s_province ";
    $strSql .= "    ,s_name ";
    $strSql .= "    ,s_address ";
    $strSql .= "    ,s_tax_no ";
    $strSql .= "    ,d_create ";
    $strSql .= "    ,d_update ";
    $strSql .= "    ,s_create_by ";
    $strSql .= "    ,s_update_by ";
    $strSql .= "  ) ";
    $strSql .= "VALUES( ";
    $strSql .= "  '$info[id]' ";
    $strSql .= "  ,'".$info[s_no]."' ";
    $strSql .= "  ,'".$info[s_no_bill]."' ";
    $strSql .= "  ,'".$info[ref_no]."' ";
    $strSql .= "  ,'".$info[s_license]."' ";
    $strSql .= "  ,'".$info[s_province]."' ";
    $strSql .= "  ,'".$info[s_name]."' ";
    $strSql .= "  ,'".$info[s_address]."' ";
    $strSql .= "  ,'".$info[s_tax_no]."' ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= ") ";
    $arr = array(
        array("query" => "$strSql")
    );
    $reslut = $db->insert_for_upadte($arr);
    $id = mysql_insert_id();
//////////// List
    while (
    list($key,$s_list_code) = each($_POST['s_list_code'])
    and list($key,$s_list_name) = each($_POST['s_list_name'])
    and list($key,$s_list_detail) = each($_POST['s_list_detail'])
    and list($key,$s_list_amount) = each($_POST['s_list_amount'])
    and list($key,$s_list_price) = each($_POST['s_list_price'])
    ) {
      $strSql = "";
      $strSql .= "INSERT ";
      $strSql .= "INTO ";
      $strSql .= "  tb_report_receipt_list ( ";
      $strSql .= "    i_invoice_report ";
      $strSql .= "    ,s_list_code ";
      $strSql .= "    ,s_list_name ";
      $strSql .= "    ,s_list_detail ";
      $strSql .= "    ,s_list_amount ";
      $strSql .= "    ,s_list_price ";
      $strSql .= "  ) ";
      $strSql .= "VALUES( ";
      $strSql .= "  '$id' ";
      $strSql .= "  ,'".$s_list_code."' ";
      $strSql .= "  ,'".$s_list_name."' ";
      $strSql .= "  ,'".$s_list_detail."' ";
      $strSql .= "  ,'".$s_list_amount."' ";
      $strSql .= "  ,'".$s_list_price."' ";
      $strSql .= ") ";
      $arr = array(
          array("query" => "$strSql")
      );
      $reslut = $db->insert_for_upadte($arr);
    }
    return $id;
  }

  
  function addBill($db,$info) {
    $util = new Utility();
    $strSql = "";
    $strSql .= "INSERT ";
    $strSql .= "INTO ";
    $strSql .= "  tb_report_bill ( ";
    $strSql .= "    s_code_by ";
    $strSql .= "    ,s_code_buy ";
    $strSql .= "    ,d_create ";
    $strSql .= "    ,d_update ";
    $strSql .= "    ,s_create_by ";
    $strSql .= "    ,s_update_by ";
    $strSql .= "  ) ";
    $strSql .= "VALUES( ";
    $strSql .= "  '".$info[s_code_by]."' ";
    $strSql .= "  ,'".$info[s_code_buy]."' ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,".$db->Sysdate(TRUE)." ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= "  ,'$_SESSION[username]' ";
    $strSql .= ") ";
    $arr = array(
        array("query" => "$strSql")
    );
    $reslut = $db->insert_for_upadte($arr);
    $id = mysql_insert_id();
//////////// List
    while (
    list($key,$i_invoice) = each($_POST['id'])
    and list($key,$s_no_claim) = each($_POST['s_no_claim'])
    and list($key,$s_ins) = each($_POST['s_ins'])
    and list($key,$s_remark) = each($_POST['s_remark'])
    ) {
      $strSql = "";
      $strSql .= "INSERT ";
      $strSql .= "INTO ";
      $strSql .= "  tb_report_bill_list ( ";
      $strSql .= "    i_report_bill ";
      $strSql .= "    ,i_invoice ";
      $strSql .= "    ,s_no_claim ";
      $strSql .= "    ,s_ins ";
      $strSql .= "    ,s_remark ";
      $strSql .= "  ) ";
      $strSql .= "VALUES( ";
      $strSql .= "  '$id' ";
      $strSql .= "  ,'".$i_invoice."' ";
      $strSql .= "  ,'".$s_no_claim."' ";
      $strSql .= "  ,'".$s_ins."' ";
      $strSql .= "  ,'".$s_remark."' ";
      $strSql .= ") ";
      $arr = array(
          array("query" => "$strSql")
      );
      $reslut = $db->insert_for_upadte($arr);
    }
    return $id;
  }
  function getInsurance($seq) {
    $db = new ConnectDB();
    $strSql = " select i_ins_comp from tb_customer_car where ref_no =".$seq;
    $_data = $db->Search_Data_FormatJson($strSql);
    $db->close_conn();
    $db = new ConnectDB();
    $strSql = " select s_name_display from tb_insurance_comp where i_ins_comp =".$_data[0][i_ins_comp];
    $_data = $db->Search_Data_FormatJson($strSql);
    $db->close_conn();
    
    
    return $_data[0]['s_name_display'];
  }

///////////////////// End Class
}
