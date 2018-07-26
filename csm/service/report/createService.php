<?php

@session_start();

class createService {

  function add($db, $info) {
    $util = new Utility();
    $ref_no = $info[s_po_spare_ref];

    $strSql = " select * ";
    $strSql .= " FROM tb_report_receive  WHERE ref_id = '" . $info[ref_id] . "' ";
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
      $strSql .= ",d_update = " . $db->Sysdate(TRUE) . " ";
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
      $strSql .= "  ," . $db->Sysdate(TRUE) . " ";
      $strSql .= "  ," . $db->Sysdate(TRUE) . " ";
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
    foreach($car_accessories as $data){
      $i_accessories_val = "i_accessories_".$data[id];
      $i_accessories = $info[$i_accessories_val];
      if($i_accessories > 0){
        $i_status = 1;
      }else{
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
      $strSql .= "  ," . $db->Sysdate(TRUE) . " ";
      $strSql .= " ," . $db->Sysdate(TRUE) . " ";
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
    foreach($car_lighting as $data){
      $i_lighting_val = "i_lighting_".$data[id];
      $i_lighting = $info[$i_lighting_val];
      if($i_lighting > 0){
        $i_status = 1;
      }else{
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
      $strSql .= "  ," . $db->Sysdate(TRUE) . " ";
      $strSql .= " ," . $db->Sysdate(TRUE) . " ";
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

///////////////////// End Class
}
