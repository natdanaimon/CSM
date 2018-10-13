<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
include './common/ConnectDB.php';
include './common/Utility.php';
$util = new Utility();
include './service/repair/createService.php';
$service = new createService();
ACTIVEPAGES(999,0);
$disableElement = 'disabled="disable"';
if ($_GET[id] < 1) {
  echo header("Location: queue_all.php");
}
$db = new ConnectDB();
function getInsuranceDisplay($seq,$db) {
  $strSql = " select s_name_display from tb_insurance_comp where i_ins_comp =".$seq;
  $_data = $db->Search_Data_FormatJson($strSql);
  return $_data[0]['s_name_display'];
}
function getRowDisplay($val,$col,$res,$tb,$db) {
  $strSql = " select $res from $tb where $col ='".$val."'";
  $_data = $db->Search_Data_FormatJson($strSql);
  return $_data[0][$res];
}
$strSql = " select * from tb_customer_car where ref_no =".$_GET[id];
$arr[customer] = $db->Search_Data_FormatJson($strSql);
if ($arr[customer][0][i_deliver]) {
  $chkbox_deliver = ' checked="checked" ';
}
if ($arr[customer][0][d_deliver] == '0000-00-00') {
  $d_deliver = $util->DateSql2d_dmm_yyyy($arr[customer][0][d_sendcar]);
}
else {
  $d_deliver = $util->DateSql2d_dmm_yyyy($arr[customer][0][d_deliver]);
}
if ($arr[customer][0][d_carin] == '0000-00-00') {
  $d_carin = $util->DateSql2d_dmm_yyyy($arr[customer][0][d_inbound]);
}
else {
  $d_carin = $util->DateSql2d_dmm_yyyy($arr[customer][0][d_carin]);
}



$t_deliver = $arr[customer][0][t_deliver];
$ref_car_info = $arr[customer][0][s_license]." : ".$arr[customer][0][i_year]." : ".$service->getBrand($arr[customer][0][s_brand_code])." : ".$service->getGeneration($arr[customer][0][s_gen_code]);

$strSql = " select * from tb_customer where i_customer =".$arr[customer][0][i_customer];
$arr[custom] = $db->Search_Data_FormatJson($strSql);


$s_title_th = getRowDisplay($arr[custom][0][i_title],'i_title','s_title_th','tb_title',$db);
$province = getRowDisplay($arr[custom][0][i_province],'i_province','s_name_th','tb_provinces',$db);
$amphure = getRowDisplay($arr[custom][0][i_amphure],'i_amphure','s_name_th','tb_amphures',$db);
$district = getRowDisplay($arr[custom][0][i_district],'i_district','s_name_th','tb_districts',$db);
$zipcode = getRowDisplay($arr[custom][0][i_district],'i_district','i_zipcode','tb_districts',$db);
$s_pay_type = getRowDisplay($arr[customer][0][s_pay_type],'s_pay_type','s_detail','tb_pay',$db);
$i_ins_type = getRowDisplay($arr[customer][0][i_ins_type],'i_ins_type','s_name','tb_insurance_type',$db);
$i_dmg = getRowDisplay($arr[customer][0][i_dmg],'i_dmg','s_dmg_th','tb_damage',$db);
$s_status = getRowDisplay($arr[customer][0][s_status],'s_status','s_detail_th','tb_status',$db);




$strSql = "";
$strSql .= " SELECT ";
$strSql .= " list.i_repair_item,list.s_remark ";
$strSql .= " ,item.s_repair_name ";
$strSql .= " FROM tb_check_repair list ";
$strSql .= " LEFT JOIN tb_repair_item item ON list.i_repair_item = item.i_repair_item ";
$strSql .= " WHERE list.ref_no =".$arr[customer][0][ref_no];
$check_repair = $db->Search_Data_FormatJson($strSql);


$strSql = "";
$strSql .= " SELECT ";
$strSql .= " *";
$strSql .= " FROM tb_check_repair_other list ";
$strSql .= " WHERE list.ref_no =".$arr[customer][0][ref_no];
$check_repair_other = $db->Search_Data_FormatJson($strSql);


$strSql = "";
$strSql .= " SELECT ";
$strSql .= " list.i_repair_item,list.s_remark ";
$strSql .= " ,item.s_repair_name ";
$strSql .= " FROM tb_list_repair list ";
$strSql .= " LEFT JOIN tb_repair_item item ON list.i_repair_item = item.i_repair_item ";
$strSql .= " WHERE list.ref_no =".$arr[customer][0][ref_no];
$list_repair = $db->Search_Data_FormatJson($strSql);
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " *";
$strSql .= " FROM tb_list_repair_other list ";
$strSql .= " WHERE list.ref_no =".$arr[customer][0][ref_no];
$list_repair_other = $db->Search_Data_FormatJson($strSql);
?>
<!DOCTYPE html>
<html lang="en">
  <!-- BEGIN HEAD -->
  <head>
    <meta charset="utf-8" />
    <title><?=$_SESSION[title]." : ".$_GET[id]." : ".$s_status?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="<?=$_SESSION[title_content]?>"    name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <!--<link href="../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />-->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
  <!-- END HEAD -->
  <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <div class="page-wrapper">
      <!-- BEGIN HEADER -->
      <?php include './templated/header.php';?>
      <!-- END HEADER -->
      <!-- BEGIN HEADER & CONTENT DIVIDER -->
      <div class="clearfix"> </div>
      <!-- END HEADER & CONTENT DIVIDER -->
      <!-- BEGIN CONTAINER -->
      <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
          <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <?php include './templated/menu.php';?>   
            <!-- END SIDEBAR MENU -->
          </div>
          <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
          <!-- BEGIN CONTENT BODY -->
          <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <?php include './templated/theme_panel.php';?>
            <!-- END THEME PANEL -->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
              <ul class="page-breadcrumb">
                <li>
                  <span>รายละเอียด</span>
                  <i class="fa fa-circle" style="color:  #00FF00;"></i>
                </li>
                <li>
                  <a href="queue_all.php"><?=$_SESSION[queue_all]?></a>
                </li>
              </ul>

            </div>
            <!-- END PAGE BAR -->
            <div class="row">
              <br/>
            </div>
            <!------------ CONTENT R5-3 ------------>
            <div class="row">
              <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                  <div class="portlet-title">
                    <div class="caption font-dark">
                      <i class="fa fa-eye font-dark"></i>
                      <span class="caption-subject bold uppercase">รายละเอียด Ref.No. <?=$_GET[id];?> สถานะ <?=$s_status;?></span>
                    </div>
                    <div class="actions">

                    </div>
                  </div>
                  <div class="portlet-body">
                    <div class="table-toolbar" style="display: none;">

                    </div>
                    <div class="row">
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <ul class="nav nav-tabs tabs-left">
                          <li class="active">
                            <a href="#tab_1" data-toggle="tab" aria-expanded="true"> 1 รถ/ลูกค้า</a>
                          </li>
                          <li class="">
                            <a href="#tab_2" data-toggle="tab" aria-expanded="false"> 2 ตรวจสภาพ/ซ่อม</a>
                          </li>
                          <li class="">
                            <a href="#tab_3" data-toggle="tab" aria-expanded="false"> 3 จัดคิวงาน</a>
                          </li>
                          <li class="">
                            <a href="#tab_4" data-toggle="tab" aria-expanded="false"> 4 สั่งซื้อ</a>
                          </li>
                          <li class="">
                            <a href="#tab_5" data-toggle="tab" aria-expanded="false"> 5 บันทึกข้อความ</a>
                          </li>
                          <li class="">
                            <a href="#tab_6" data-toggle="tab" aria-expanded="false"> 6 ต้นทุน-กำไร</a>
                          </li>

                        </ul>
                      </div>
                      <div class="col-md-9 col-sm-9 col-xs-9">
                        <div class="tab-content">
                          <div class="tab-pane active in" id="tab_1">
                            <div class="col-md-12">
                              <form method="post" id="action-deliver" style="display:none;">
                                <input type="hidden" name="func" id="func" value="saveDeliver"/>
                                <input type="hidden" name="ref_no" id="ref_no" value="<?=$_GET[id];?>"/>
                                <div class="row" id="div-refno">
                                  <div class="col-md-3">
                                    <label for="d_deliver" style="color: #36c6d3;">วันที่ลูกค้ารับรถ <span class="required" style="color: red;">*</span></label> 
                                    <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?=date("d-m-Y")?>"  style="width: 100% !important;">
                                      <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                          <i class="fa fa-calendar"></i>
                                        </button>
                                      </span>

                                      <input readonly="readonly"  value="<?=$d_deliver;?>" type="text" class="form-control bold" id="d_deliver" name="d_deliver">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-success" >
                                      <input type="time" class="form-control bold required" id="t_deliver"  name="t_deliver" value="<?=$t_deliver;?>" >
                                      <label for="form_control_1">เวลาที่ลูกค้ารับรถ </label>          
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-success" >
                                      <div class="col-md-12 col-sm-12" style="padding-top: 10px;display:inline-flex;">
                                        <span class=" md-checkbox has-success">  
                                          <input <?=$chkbox_deliver;?> type="checkbox" id="i_deliver" name="i_deliver" class="md-check" value="1">
                                          <label for="i_deliver">    
                                            <span class="inc"></span>    
                                            <span class="check"></span>    
                                            <span class="box"></span> แจ้งภายหลัง</label>

                                        </span>
                                      </div>      
                                    </div>
                                  </div>

                                  <div class="col-md-3">
                                    <div class="portlet-body form">
                                      <div class="form-actions noborder">
                                        <button id="btn_update_deliver" type="button"   class="btn blue" >บันทึกข้อมูล</button>
                                      </div>
                                    </div>
                                  </div> 
                                </div>
                              </form>
                              <hr  style="display:none;"/>
                              <form method="post" id="action-carin">
                                <input type="hidden" name="func"  value="saveCarin"/>
                                <input type="hidden" name="ref_no"  value="<?=$_GET[id];?>"/>
                              <div class="row" id="div-refnoa">
                                  <div class="col-md-3">
                                    <label for="d_deliver" style="color: #36c6d3;">วันที่เข้าซ่อม <span class="required" style="color: red;">*</span></label> 
                                    <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?=date("d-m-Y")?>"  style="width: 100% !important;">
                                      <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                          <i class="fa fa-calendar"></i>
                                        </button>
                                      </span>
                                      <input readonly="readonly"  value="<?=$d_carin;?>" type="text" class="form-control bold" id="d_carin" name="d_carin">
                                    </div>
                                  </div>
                                  

                                  <div class="col-md-3">
                                    <div class="portlet-body form">
                                      <div class="form-actions noborder">
                                        <button id="btn_update_carin" type="button"  class="btn blue" >บันทึกข้อมูล</button>
                                      </div>
                                    </div>
                                  </div> 
                                </div>
                              </form>

                              <div class="row" id="div-refno">
                                <div class="col-md-9">
                                  <div class="form-group form-md-line-input has-success" >
                                    <input type="text" class="form-control bold required" id="ref_car_info" name="ref_car_info" readonly="readonly" value="<?=$ref_car_info;?>" >
                                    <label for="form_control_1"><?=$_SESSION[lb_re_refCarInfo]?></label>          
                                  </div>
                                </div>

                                <div class="col-md-3">
                                  <div class="form-group form-md-line-input has-success" >
                                    <input type="text" class="form-control bold required" id="s_queue_ref"  name="s_queue_ref" readonly="readonly"  value="<?=$_GET[id]?>" >
                                    <label for="form_control_1"><?=$_SESSION[lb_re_refNo]?> </label>          
                                  </div>
                                </div> 
                              </div>
                              <!-- BEGIN STEP1-->
                              <div class="portlet box green">
                                <div class="portlet-title" onclick="closeStep(1)" style="cursor: pointer;">
                                  <div class="caption">
                                    <i class="fa fa-user"></i> <?=$_SESSION[tt_detail_create1]?></div>
                                  <div class="tools">

                                  </div>
                                </div>
                                <div class="portlet-body form" id="step1" style="display: nonea;">
                                  <div class="portlet light bordered">
                                    <div class="portlet-body form">
                                      <div class="form-body">
                                        <div class="row">
                                          <div class="col-md-2">
                                            <div class="form-group form-md-line-input has-success">
                                              <input type="text" class="form-control bold required" id="s_title_th" name="s_title_th" readonly="readonly" value="<?=$s_title_th;?>" >
                                              <label for="form_control_1"><?=$_SESSION[lb_setCus_title]?> </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-5">
                                            <div class="form-group form-md-line-input has-success">
                                              <input value="<?=$arr[custom][0][s_firstname];?>" type="text" class="form-control bold" id="s_firstname" name="s_firstname" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setCus_fname]?> </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-5">
                                            <div class="form-group form-md-line-input has-success">
                                              <input value="<?=$arr[custom][0][s_lastname];?>" type="text" class="form-control bold" id="s_lastname"  name="s_lastname" <?=$disableElement?>>
                                              <label  for="form_control_1"><?=$_SESSION[lb_setCus_lname]?> 
                                                <span id="class_val_username" class="" >
                                                  <i id="icon_val_username" class=""></i>
                                                  <span id="lb_val_username"></span>
                                                </span>
                                              </label>          
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-3">
                                            <div class="form-group form-md-line-input has-success">
                                              <input value="<?=$arr[custom][0][s_phone_1];?>" type="text" class="form-control bold" id="s_phone_1" name="s_phone_1" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setCus_phone1]?> 
                                                <span id="class_val_phone" class="" >
                                                  <i id="icon_val_phone" class=""></i>
                                                  <span id="lb_val_phone"></span>
                                                </span>
                                              </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="form-group form-md-line-input has-success">
                                              <input value="<?=$arr[custom][0][s_phone_2];?>" type="text" class="form-control bold" id="s_phone_2" name="s_phone_2" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setCus_phone2]?> 
                                                <span id="class_val_phone" class="" >
                                                  <i id="icon_val_phone" class=""></i>
                                                  <span id="lb_val_phone"></span>
                                                </span>
                                              </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="form-group form-md-line-input has-success" >
                                              <input value="<?=$arr[custom][0][s_email];?>" type="text" class="form-control bold" id="s_email" name="s_email" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setCus_email]?> 
                                                <span id="class_val_secu" class="" >
                                                  <i id="icon_val_secu" class=""></i>
                                                  <span id="lb_val_secu"></span>
                                                </span>
                                              </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="form-group form-md-line-input has-success">
                                              <input value="<?=$arr[custom][0][s_line];?>" type="text" class="form-control bold" id="s_line" name="s_line" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setCus_line]?> 
                                                <span id="class_val_phone" class="" >
                                                  <i id="icon_val_phone" class=""></i>
                                                  <span id="lb_val_phone"></span>
                                                </span>
                                              </label>          
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group form-md-line-input has-success">
                                              <input value="<?=$arr[custom][0][s_address];?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setCus_address]?> 
                                                <span id="class_val_phone" class="" >
                                                  <i id="icon_val_phone" class=""></i>
                                                  <span id="lb_val_phone"></span>
                                                </span>
                                              </label>          
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group form-md-line-input has-success">
                                              <input value="<?=$province;?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[province]?> </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group form-md-line-input has-success">

                                              <input value="<?=$amphure;?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[amphure]?> </label>          
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group form-md-line-input has-success">

                                              <input value="<?=$district;?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[district]?> </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group form-md-line-input has-success">

                                              <input value="<?=$zipcode;?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[zipcode]?> </label>          
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row" id="div-refno" style="display:none">
                                          <div class="col-md-3">
                                          </div>
                                          <div class="col-md-5"></div>
                                          <div class="col-md-4"></div> 
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-success" style="height: 80px">

                                              <input value="<?=getInsuranceDisplay($arr[customer][0][i_ins_comp],$db);?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_re_insurance_comp]?></label>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <label for="form_control_1" style="color: #36c6d3;"><?=$_SESSION[lb_re_dinbound]?> <span class="required" style="color: red;">*</span></label> 
                                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?=date("d-m-Y")?>"  style="width: 100% !important;">
                                              <span class="input-group-btn">
                                                <button class="btn default" type="button" <?=$disableElement?>>
                                                  <i class="fa fa-calendar"></i>
                                                </button>
                                              </span>

                                              <input value="<?=$util->DateSql2d_dmm_yyyy($arr[customer][0][d_inbound]);?>" type="text" class="form-control bold" <?=$disableElement?>>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <label for="form_control_1" style="color: #36c6d3;"><?=$_SESSION[lb_re_doutbound_confirm]?> <span class="required" style="color: red;">*</span></label> 
                                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?=date("d-m-Y")?>"  style="width: 100% !important;">
                                              <span class="input-group-btn">
                                                <button class="btn default" type="button" <?=$disableElement?>>
                                                  <i class="fa fa-calendar"></i>
                                                </button>
                                              </span>

                                              <input value="<?=$util->DateSql2d_dmm_yyyy($arr[customer][0][d_sendcar]);?>" type="text" class="form-control bold" <?=$disableElement?>>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12"> 
                                            <div class="form-group form-md-line-input has-success" >
                                              <div class="md-radio-inline" <?=$disableElement?>>
                                                <div id="insurance_type"></div>
                                              </div>

                                              <input value="<?=$i_ins_type;?>" type="text" class="form-control bold" <?=$disableElement?>>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-success">

                                              <input value="<?=$arr[customer][0][s_type_capital];?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_re_type_capital]?> </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-5">
                                            <label for="form_control_1" style="color: #36c6d3;"><?=$_SESSION[lb_re_dexp]?> <span class="required" style="color: red;">*</span></label> 
                                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?=date("d-m-Y")?>"  style="width: 100% !important;">
                                              <span class="input-group-btn">
                                                <button class="btn default" type="button" <?=$disableElement?>>
                                                  <i class="fa fa-calendar"></i>
                                                </button>
                                              </span>

                                              <input value="<?=$util->DateSql2d_dmm_yyyy($arr[customer][0][d_ins_exp]);?>" type="text" class="form-control bold" <?=$disableElement?>>
                                            </div>

                                          </div>
                                          <div class="col-md-3">
                                          </div> 
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-success" >
                                              <input value="<?=$s_pay_type;?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_re_paytype]?> </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-3">
                                          </div> 
                                          <div class="col-md-4">
                                          </div> 
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-success" >

                                              <input value="<?=$arr[customer][0][i_year];?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setYear_year]?></label>
                                            </div>
                                          </div>
                                          <div class="col-md-5">
                                            <div class="form-group form-md-line-input has-success" >

                                              <input value="<?=$service->getBrand($arr[customer][0][s_brand_code]);?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setBrand_code]?></label>
                                            </div>
                                          </div>
                                          <div class="col-md-3"></div> 
                                        </div>			
                                        <div class="row" >
                                          <div class="col-md-4">
                                            <div class="form-group form-md-line-input has-success" >
                                              <input value="<?=$service->getGeneration($arr[customer][0][s_gen_code]);?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_setGen_code]?></label>
                                            </div>
                                          </div>
                                          <div class="col-md-5">
                                            <div class="form-group form-md-line-input has-success">

                                              <input value="<?=$arr[customer][0][s_license];?>" type="text" class="form-control bold" <?=$disableElement?>>
                                              <label for="form_control_1"><?=$_SESSION[lb_re_carlicense]?> </label>          
                                            </div>
                                          </div>
                                          <div class="col-md-3">
                                          </div> 
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- END STEP1-->
                              <!-- START STEP3-->

                              <!-- END STEP3-->
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab_2">

                            <div class="portlet box green">
                              <div class="portlet-title">
                                <div class="caption">
                                  <i class="fa fa-car"></i> <?=$_SESSION[tt_detail_create2]?></div>
                                <div class="tools">


                                </div>
                              </div>
                              <div class="portlet-body form" id="step2" style="display: block;">
                                <div class="portlet light bordered">
                                  <div class="portlet-body form">
                                    <div class="form-body">
                                      <?php
                                      if ($check_repair != NULL) {
                                        ?>
                                        <div class="row">
                                          <div class="col-md-3"><b><?=$_SESSION[lb_repair_list]?></b></div>
                                          <div class="col-md-3"><b><?=$_SESSION[lb_repair_remark]?></b></div>
                                          <div class="col-md-3"><b><?=$_SESSION[lb_repair_list]?></b></div>
                                          <div class="col-md-3"><b><?=$_SESSION[lb_repair_remark]?></b></div>
                                        </div>
                                        <div id="">
                                          <div class="row">
                                            <?php
                                            $ii = 1;
                                            foreach ($check_repair as $dataC) {
                                              ?>
                                              <div class="col-md-3"><?=$ii.". ".$dataC[s_repair_name];?></div>
                                              <div class="col-md-3">
                                                <?php
                                                if ($dataC[s_remark]) {
                                                  echo $dataC[s_remark];
                                                }
                                                else {
                                                  echo '-';
                                                }
                                                ?>
                                              </div>
                                              <?php
                                              $ii++;
                                            }
                                            ?>
                                          </div>
                                        </div>
                                        <br/><br/>
                                      <?php }?>
                                      <div class="row">
                                        <div class="col-md-12"><b><?=$_SESSION[other]?></b></div>
                                      </div>
                                      <?php
                                      if ($check_repair_other != NULL) {
                                        ?>
                                        <div class="row">
                                          <div class="col-md-6"><b><?=$_SESSION[lb_repair_list]?></b></div>

                                          <div class="col-md-6"><b><?=$_SESSION[lb_repair_list]?></b></div>


                                        </div>
                                        <div id="">
                                          <div class="row">
                                            <?php
                                            $ii = 1;
                                            foreach ($check_repair_other as $dataC) {
                                              for ($i = 1; $i <= 13; $i++) {
                                                $txt_no = 's_txt_'.$i;
                                                $txt_sub = 'i_repair_subitem'.$i;
                                                ?>

                                                <div class="col-md-6">
                                                  <?php
                                                  if ($dataC[$txt_no]) {
                                                    echo $ii.". ".$dataC[$txt_no];
                                                    $ii++;
                                                  }
                                                  else {
                                                    
                                                  }
                                                  ?>
                                                </div>
                                                <?php
                                              }
                                            }
                                            ?>
                                          </div>
                                        </div>
                                        <br/><br/>
                                      <?php }?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <hr />
                            <div class="portlet box green">
                              <div class="portlet-title"  >
                                <div class="caption">
                                  <i class="fa fa-car"></i> <?=$_SESSION[tt_repair_list]?></div>
                                <div class="tools">


                                </div>
                              </div>
                              <div class="portlet-body form" id="step3" style="display: block;">
                                <div class="portlet light bordered">
                                  <div class="portlet-body form">
                                    <div class="form-body">

                                      <div class="row" >
                                        <div class="col-md-4">
                                          <div class="form-group form-md-line-input has-success">

                                            <input value="<?=$i_dmg;?>" class="form-control bold required" <?=$disableElement?> >
                                            <label for="form_control_1"><?=$_SESSION[lb_re_dmg]?> </label>          
                                          </div>
                                        </div>

                                        <div class="col-md-4">
                                          <label for="form_control_1" style="color: #36c6d3;"><?=$_SESSION[lb_re_sendcar]?> <span class="required" style="color: red;">*</span></label> 
                                          <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?=date("d-m-Y")?>"   style="width: 100% !important;">
                                            <span class="input-group-btn">
                                              <button class="btn default" type="button" <?=$disableView?>>
                                                <i class="fa fa-calendar"></i>
                                              </button>
                                            </span>
                                            <input type="text" class="form-control" value="<?=$util->DateSql2d_dmm_yyyy($arr[customer][0][d_sendcar]);?>" <?=$disableElement?>>
                                          </div>
                                        </div>

                                        <div class="col-md-4">
                                          <div class="form-group form-md-line-input has-success">
                                            <input value="<?=$arr[customer][0][i_emcs];?>" class="form-control bold required" <?=$disableElement?> >
                                            <label for="form_control_1"><?=$_SESSION[lb_re_emcs]?> </label>          
                                          </div>
                                        </div>

                                      </div>
                                      <hr />

                                      <?php
                                      if ($list_repair != NULL) {
                                        ?>
                                        <div class="row">
                                          <div class="col-md-3"><b><?=$_SESSION[lb_repair_list]?></b></div>
                                          <div class="col-md-3"><b><?=$_SESSION[lb_repair_remark]?></b></div>
                                          <div class="col-md-3"><b><?=$_SESSION[lb_repair_list]?></b></div>
                                          <div class="col-md-3"><b><?=$_SESSION[lb_repair_remark]?></b></div>
                                        </div>
                                        <div id="">
                                          <div class="row">
                                            <?php
                                            $ii = 1;
                                            foreach ($list_repair as $dataC) {
                                              ?>
                                              <div class="col-md-3"><?=$ii.". ".$dataC[s_repair_name];?></div>
                                              <div class="col-md-3">
                                                <?php
                                                if ($dataC[s_remark]) {
                                                  echo $dataC[s_remark];
                                                }
                                                else {
                                                  echo '-';
                                                }
                                                ?>
                                              </div>
                                              <?php
                                              $ii++;
                                            }
                                            ?>
                                          </div>
                                        </div>
                                        <br/><br/>
                                      <?php }?>
                                      <div class="row">
                                        <div class="col-md-12"><b><?=$_SESSION[other]?></b></div>
                                      </div>
                                      <?php
                                      if ($list_repair_other != NULL) {
                                        ?>
                                        <div class="row">
                                          <div class="col-md-6"><b><?=$_SESSION[lb_repair_list]?></b></div>

                                          <div class="col-md-6"><b><?=$_SESSION[lb_repair_list]?></b></div>


                                        </div>
                                        <div id="">
                                          <div class="row">
                                            <?php
                                            $ii = 1;
                                            foreach ($list_repair_other as $dataC) {
                                              for ($i = 1; $i <= 13; $i++) {
                                                $txt_no = 's_txt_'.$i;
                                                $txt_sub = 'i_repair_subitem'.$i;
                                                ?>

                                                <div class="col-md-6">
                                                  <?php
                                                  if ($dataC[$txt_no]) {
                                                    echo $ii.". ".$dataC[$txt_no];
                                                    $ii++;
                                                  }
                                                  else {
                                                    
                                                  }
                                                  ?>
                                                </div>
                                                <?php
                                              }
                                            }
                                            ?>
                                          </div>
                                        </div>
                                        <br/><br/>
                                      <?php }?>


                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>



                          </div>
                          <div class="tab-pane fade" id="tab_3">
                            <?php
                            $db = new ConnectDB();
                            $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
                            $strSql .= " from   tb_department b , tb_status s  ";
                            $strSql .= " where    b.s_status =  s.s_status ";
                            $strSql .= " and    s.s_type   =  'ACTIVE' ";
                            $strSql .= " order by b.i_index  ";
                            $_data = $db->Search_Data_FormatJson($strSql);
                            $db->close_conn();
                            ?>

                            <?php
                            $i = 0;
                            foreach ($_data as $data) {
                              ?>
                              <div class="portlet box green" id="main_querytabt<?=$data[i_dept]?>">
                                <div class="portlet-title" onclick="closeStep(<?=$data[i_dept]?>)" style="cursor: pointer;">
                                  <div class="caption">
                                    <i class="fa fa-clock-o"></i> <?=$data[s_dept_th]?></div>
                                  <div class="tools">
                                    <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                                  </div>
                                </div>
                                <?php
                                if ($i == 0) {
                                  $none_aa = "a";
                                }
                                else {
                                  $none_aa = "a";
                                }
                                ?>
                                <div class="portlet-body form" id="step<?=$data[i_dept]?>" style="display: none<?=$none_aa;?>;">
                                  <div class="portlet light bordered">

                                    <table class="table table-striped table-bordered table-hover table-checkable order-column dt-responsive" id="datatable">
                                      <thead>
                                        <tr>
                                          <th  class="all">  เริ่ม </th>
                                          <th  class="all">  กำหนดเสร็จ </th>
                                          <th class="all"> ระดับ </th>
                                          <th class="all">STAFF</th>
                                          <th  class="all" style="width: 150px">  สถานะ </th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        $db = new ConnectDB();
                                        $strSql = "select d.*,q.ref_no , c.s_license, dmg.s_dmg_th, bc.s_brand_name, cg.s_gen_name ";
                                        //$strSql = "select d.*,q.ref_no , c.s_license, dmg.s_dmg_th, bc.s_brand_name ";
                                        $strSql .= " from   tb_queue_dept d  ";
                                        $strSql .= " LEFT JOIN  tb_queue q ON  d.i_queue = q.i_queue";
                                        $strSql .= " LEFT JOIN  tb_customer_car c ON  c.ref_no = q.ref_no";
                                        $strSql .= " LEFT JOIN  tb_damage dmg ON  c.i_dmg = dmg.i_dmg";
                                        $strSql .= " LEFT JOIN  tb_car_brand bc ON  c.s_brand_code = bc.s_brand_code";
                                        $strSql .= " LEFT JOIN  tb_car_generation cg ON  c.s_gen_code = cg.s_gen_code";
                                        $strSql .= " where  d.i_dept_date > 0";
                                        $strSql .= " and    d.i_dept = '".$data[i_dept]."' ";
                                        $strSql .= " and    c.ref_no = '".$_GET[id]."' ";
                                        $_datalv2 = $db->Search_Data_FormatJson($strSql);
                                        $db->close_conn();
                                        ?>
                                        <?php
                                        $iqq = 0;
                                        foreach ($_datalv2 as $datalv2) {
                                          ?>
                                          <tr>
                                            <td><?=$datalv2['d_start'];?> (+<?=$datalv2['i_dept_date'];?>)</td>
                                            <td><?=$datalv2['d_end'];?></td>
                                            <td><?=$datalv2['s_dmg_th'];?></td>
                                            <td>
                                              <?php
                                              $db = new ConnectDB();
                                              $strSql = "select s.*,e.s_firstname , e.s_lastname";
                                              $strSql .= " from   tb_queue_dept_staff s  ";
                                              $strSql .= " LEFT JOIN  tb_employee e ON  e.i_emp = s.i_staff";
                                              $strSql .= " where  s.i_queue_dept = '".$datalv2[i_queue_dept]."'";
                                              $_datalv3 = $db->Search_Data_FormatJson($strSql);
                                              $db->close_conn();
                                              ?>
                                              <?php
                                              $sss = 1;
                                              foreach ($_datalv3 as $datalv3) {
                                                ?>
                                                <?=$datalv3[s_firstname];?> <?=$datalv3[s_lastname];?> <br />
                                                <?php
                                                $sss++;
                                              }
                                              ?>
                                            </td>
                                            <td>
                                              <?php
                                              if ($datalv2['i_status'] == 1) {
                                                $txt_status = "สำเร็จ";
                                                $btn_style = "success";
                                              }
                                              else {
                                                $txt_status = "กำลังดำเนินการ";
                                                $btn_style = "warning";
                                              }
                                              ?>
                                              <label class="text-<?=$btn_style;?> "><?=$txt_status;?></label>
                                            </td>
                                          </tr>
                                          <?php
                                          $iqq++;
                                        }
                                        ?>
                                      </tbody>
                                    </table>
                                    <?php
                                    if ($iqq < 1) {
                                      ?>
                                      <script>
                                        $('#main_querytabt<?=$data[i_dept]?>').hide();
                                      </script>
                                      <?php
                                    }
                                    ?>

                                  </div>

                                </div>

                              </div>
                              <?php
                              $i++;
                            }
                            ?> 
                          </div>
                          <div class="tab-pane fade" id="tab_4">
                            <?php
                            $strSql = " select list.* ";
                            $strSql .= " FROM tb_po_spare_list list  WHERE ref_id = '".$arr[customer][0][i_cust_car]."' ";
                            $_dataTable = $db->Search_Data_FormatJson($strSql);
                            ?>
                            <div class="portlet box green">
                              <div class="portlet-title" onclick="closeStep(3)" style="cursor: pointer;">
                                <div class="caption">
                                  <i class="fa fa-clock-o"></i> <?=$_SESSION[tb_po_history]?> อะไหล่</div>
                                <div class="tools">
                                  <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                                </div>
                              </div>
                              <div class="portlet-body form" id="step3" style="display: block;">
                                <!-- BEGIN FORM-->
                                <div class="portlet light bordered">
                                  <div class="portlet-body form">
                                    <div class="form-body">
                                      <?php
                                      if ($_dataTable == NULL) {
                                        ?>
                                        <div align="center"><h3>ยังไม่มีข้อมูลการสั่งซื้อ</h3></div>
                                        <?php
                                      }
                                      else {
                                        ?>
                                        <table width="100%" cellpadding="5" cellspacing="10">
                                          <tr style="height: 35px; background-color: #32c5d2; color: #ffffff; font-weight: bold;">
                                            <td align="center" width="100"><?=$_SESSION[tb_po_no]?></td>
                                            <td align="center" width="100"><?=$_SESSION[tb_po_orderdate]?></td>
                                            <td align="center" width="100"><?=$_SESSION[tb_po_receivedate]?></td>
                                            <td align="center" ><?=$_SESSION[po_dd_store]?></td>
                                            <td align="center" width="100"><?=$_SESSION[tb_po_withdrawdate]?></td>
                                            <td align="center"><?=$_SESSION[tb_po_shop]?></td>
                                            <td align="center" width="100"><?=$_SESSION[purchase_code]?></td>
                                            <td><?=$_SESSION[purchase_name]?></td>
                                            <td align="right" width="100"><?=$_SESSION[tb_po_payby]?></td>
                                            <td align="right" width="100"><?=$_SESSION[tb_po_amount]?></td>
                                            <td align="right" width="100"><?=$_SESSION[tb_po_price]?></td>
                                            <td width="10"></td>
                                          </tr>
                                          <tbody id="tbody_order">
                                            <?php
                                            if ($_dataTable == NULL) {
                                              ?>
                                              <tr>
                                                <td colspan="11" style="border-bottom: 1px solid #cccccc;" align="center">
                                                  ยังไม่มีรายการสั่งซื้อ
                                                </td>
                                              </tr>
                                              <?php
                                            }
                                            else {
                                              $no = 1;
                                              $i = 0;
                                              foreach ($_dataTable as $key => $value) {
                                                $strSql = " select s_firstname,s_lastname ";
                                                $strSql .= " FROM tb_employee   WHERE i_emp = '".$_dataTable[$key]['i_receive']."' ";
                                                $employee = $db->Search_Data_FormatJson($strSql);
                                                $full_emp = $employee[0][s_firstname]." ".$employee[0][s_lastname];

                                                $strSql = " select s_firstname,s_lastname ";
                                                $strSql .= " FROM tb_employee   WHERE i_emp = '".$_dataTable[$key]['i_withdraw']."' ";
                                                $employee = $db->Search_Data_FormatJson($strSql);
                                                $full_withdraw = $employee[0][s_firstname]." ".$employee[0][s_lastname];


                                                $strSql = " select s_comp_th ";
                                                $strSql .= " FROM tb_partner_comp   WHERE i_part_comp = '".$_dataTable[$key]['i_shop']."' ";
                                                $comp = $db->Search_Data_FormatJson($strSql);
                                                $full_comp = $comp[0][s_comp_th];
                                                ?>
                                                <tr id="tr_order_<?=$i;?>" style="height: 30px;">
                                                  <td align="center">
                                                    <?php
                                                    if ($_dataTable[$key]['i_receive'] == 0) {
                                                      ?>

                                                      <?=$_dataTable[$key]['s_no'];?>

                                                      <?php
                                                    }
                                                    else {
                                                      ?>
                                                      <?=$_dataTable[$key]['s_no'];?>
                                                      <?php
                                                    }
                                                    ?>

                                                  </td>
                                                  <td align="center">
                                                    <?=$_dataTable[$key]['d_order'];?>
                                                  </td>
                                                  <td align="center">
                                                    <?php
                                                    if ($_dataTable[$key]['i_receive'] == 0) {
                                                      ?>
                                                      -
                                                      <?php
                                                    }
                                                    else {
                                                      echo $_dataTable[$key]['d_receive'];
                                                    }
                                                    ?>
                                                    <br />
                                                    <?php
                                                    if ($_dataTable[$key]['i_receive'] == 0) {
                                                      echo "";
                                                    }
                                                    else {
                                                      echo $full_emp;
                                                    }
                                                    ?>
                                                  </td>
                                                  <td align="center">
                                                    <?=$_dataTable[$key]['s_store'];?>
                                                  </td>
                                                  <td align="center">
                                                    <?php
                                                    if ($_dataTable[$key]['i_receive'] > 0) {
                                                      if ($_dataTable[$key]['i_withdraw'] == 0) {
                                                        ?>
                                                        -
                                                        <?php
                                                      }
                                                      else {
                                                        echo $_dataTable[$key]['d_withdraw'];
                                                        echo "<br />";
                                                        echo $full_withdraw;
                                                      }
                                                    }
                                                    else {
                                                      echo "-";
                                                    }
                                                    ?>
                                                  </td>
                                                  <td align="center">
                                                    <?php
                                                    if ($_dataTable[$key]['i_shop'] == 0) {
                                                      echo "-";
                                                    }
                                                    else {
                                                      echo $full_comp;
                                                    }
                                                    ?>
                                                  </td>
                                                  <td align="center">
                                                    <?=$_dataTable[$key]['s_code'];?>
                                                  </td>
                                                  <td align="left">
                                                    <?=$_dataTable[$key]['s_name'];?>
                                                  </td>
                                                  <td align="right">
                                                    <?php
                                                    if ($_dataTable[$key]['i_pay'] == 2) {
                                                      echo "เครดิต";
                                                    }
                                                    else {
                                                      echo "เงินสด";
                                                    }
                                                    ?>
                                                  </td>
                                                  <td align="right">
                                                    <?=$_dataTable[$key]['i_amount'];?>
                                                  </td>
                                                  <td align="right">
                                                    <?=$_dataTable[$key]['i_price'];?>
                                                  </td>
                                                  <td></td>
                                                </tr>
                                                <tr>
                                                  <td colspan="11" style="border-bottom: 1px solid #cccccc;"></td>
                                                </tr>
                                                <?php
                                                $no++;
                                                $i++;
                                                $total_summm += $_dataTable[$key]['i_price'];
                                              }
                                            }
                                            ?>
                                          </tbody>
                                          <tr style="display: nones;">
                                            <td colspan="10" align="right">
                                              <strong>รวมเป็นเงินทั้งสิ้น</strong>
                                            </td>
                                            <td align="right">
                                              <span id="sum_total_order"><?=$total_summm;?></span>
                                            </td>
                                            <td></td>
                                          </tr>
                                        </table>
                                      <?php }?>
                                    </div>
                                  </div>
                                </div>
                                <!-- END FORM-->
                              </div>
                            </div>  

                            <hr />
                            <?php
                            $strSql = " select list.* ";
                            $strSql .= " FROM tb_po_color_list list  WHERE ref_id = '".$arr[customer][0][i_cust_car]."' ";
                            $_dataTable = $db->Search_Data_FormatJson($strSql);
                            ?>
                            <div class="portlet box green">
                              <div class="portlet-title" onclick="closeStep(3)" style="cursor: pointer;">
                                <div class="caption">
                                  <i class="fa fa-clock-o"></i> <?=$_SESSION[tb_po_history]?> สี</div>
                                <div class="tools">
                                  <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                                </div>
                              </div>
                              <div class="portlet-body form" id="step3" style="display: block;">
                                <!-- BEGIN FORM-->
                                <div class="portlet light bordered">
                                  <div class="portlet-body form">
                                    <div class="form-body">
                                      <?php
                                      if ($_dataTable == NULL) {
                                        ?>
                                        <div align="center"><h3>ยังไม่มีข้อมูลการสั่งซื้อ</h3></div>
                                        <?php
                                      }
                                      else {
                                        ?>
                                        <table width="100%" cellpadding="5" cellspacing="10">
                                          <tr style="height: 35px; background-color: #32c5d2; color: #ffffff; font-weight: bold;">
                                            <td align="center" width="100"><?=$_SESSION[tb_po_no]?></td>
                                            <td align="center" width="100"><?=$_SESSION[tb_po_orderdate]?></td>
                                            <td align="center" width="100"><?=$_SESSION[tb_po_receivedate]?></td>
                                            <td align="center" ><?=$_SESSION[po_dd_store]?></td>
                                            <td align="center" width="100"><?=$_SESSION[tb_po_withdrawdate]?></td>
                                            <td align="center"><?=$_SESSION[tb_po_shop]?></td>
                                            <td align="center" width="100"><?=$_SESSION[tb_po_code]?></td>
                                            <td><?=$_SESSION[purchase_name]?></td>
                                            <td align="right" width="100"><?=$_SESSION[tb_po_payby]?></td>
                                            <td align="right" width="100"><?=$_SESSION[tb_po_amount]?></td>
                                            <td align="right" width="100"><?=$_SESSION[tb_po_price]?></td>
                                            <td width="10"></td>
                                          </tr>
                                          <tbody id="tbody_order">
                                            <?php
                                            if ($_dataTable == NULL) {
                                              ?>
                                              <tr>
                                                <td colspan="11" style="border-bottom: 1px solid #cccccc;" align="center">
                                                  ยังไม่มีรายการสั่งซื้อ
                                                </td>
                                              </tr>
                                              <?php
                                            }
                                            else {
                                              $no = 1;
                                              $i = 0;
                                              foreach ($_dataTable as $key => $value) {
                                                $strSql = " select s_firstname,s_lastname ";
                                                $strSql .= " FROM tb_employee   WHERE i_emp = '".$_dataTable[$key]['i_receive']."' ";
                                                $employee = $db->Search_Data_FormatJson($strSql);
                                                $full_emp = $employee[0][s_firstname]." ".$employee[0][s_lastname];

                                                $strSql = " select s_firstname,s_lastname ";
                                                $strSql .= " FROM tb_employee   WHERE i_emp = '".$_dataTable[$key]['i_withdraw']."' ";
                                                $employee = $db->Search_Data_FormatJson($strSql);
                                                $full_withdraw = $employee[0][s_firstname]." ".$employee[0][s_lastname];


                                                $strSql = " select s_comp_th ";
                                                $strSql .= " FROM tb_partner_comp   WHERE i_part_comp = '".$_dataTable[$key]['i_shop']."' ";
                                                $comp = $db->Search_Data_FormatJson($strSql);
                                                $full_comp = $comp[0][s_comp_th];
                                                ?>
                                                <tr id="tr_order_<?=$i;?>" style="height: 30px;">
                                                  <td align="center">
                                                    <?php
                                                    if ($_dataTable[$key]['i_receive'] == 0) {
                                                      ?>

                                                      <?=$_dataTable[$key]['s_no'];?>

                                                      <?php
                                                    }
                                                    else {
                                                      ?>
                                                      <?=$_dataTable[$key]['s_no'];?>
                                                      <?php
                                                    }
                                                    ?>

                                                  </td>
                                                  <td align="center">
                                                    <?=$_dataTable[$key]['d_order'];?>
                                                  </td>
                                                  <td align="center">
                                                    <?php
                                                    if ($_dataTable[$key]['i_receive'] == 0) {
                                                      ?>
                                                      <a href="#div_receive<?=time();?>" onclick="func_recieve('<?=$_dataTable[$key]['s_no'];?>');"><?=$_SESSION[tb_po_receive]?></a>
                                                      <?php
                                                    }
                                                    else {
                                                      echo $_dataTable[$key]['d_receive'];
                                                    }
                                                    ?>
                                                    <br />
                                                    <?php
                                                    if ($_dataTable[$key]['i_receive'] == 0) {
                                                      echo "";
                                                    }
                                                    else {
                                                      echo $full_emp;
                                                    }
                                                    ?>
                                                  </td>
                                                  <td align="center">
                                                    <?=$_dataTable[$key]['s_store'];?>
                                                  </td>
                                                  <td align="center">
                                                    <?php
                                                    if ($_dataTable[$key]['i_receive'] > 0) {
                                                      if ($_dataTable[$key]['i_withdraw'] == 0) {
                                                        ?>
                                                        -
                                                        <?php
                                                      }
                                                      else {
                                                        echo $_dataTable[$key]['d_withdraw'];
                                                        echo "<br />";
                                                        echo $full_withdraw;
                                                      }
                                                    }
                                                    else {
                                                      echo "-";
                                                    }
                                                    ?>
                                                  </td>
                                                  <td align="center">
                                                    <?php
                                                    if ($_dataTable[$key]['i_shop'] == 0) {
                                                      echo "-";
                                                    }
                                                    else {
                                                      echo $full_comp;
                                                    }
                                                    ?>
                                                  </td>
                                                  <td align="center">
                                                    <?=$_dataTable[$key]['s_code'];?>
                                                  </td>
                                                  <td align="left">
                                                    <?=$_dataTable[$key]['s_name'];?>
                                                  </td>
                                                  <td align="right">
                                                    <?php
                                                    if ($_dataTable[$key]['i_pay'] == 2) {
                                                      echo "เครดิต";
                                                    }
                                                    else {
                                                      echo "เงินสด";
                                                    }
                                                    ?>
                                                  </td>
                                                  <td align="right">
                                                    <?=$_dataTable[$key]['i_amount'];?>
                                                  </td>
                                                  <td align="right">
                                                    <?=$_dataTable[$key]['i_price'];?>
                                                  </td>
                                                  <td></td>
                                                </tr>
                                                <tr>
                                                  <td colspan="11" style="border-bottom: 1px solid #cccccc;"></td>
                                                </tr>
                                                <?php
                                                $no++;
                                                $i++;
                                                $total_summm += $_dataTable[$key]['i_price'];
                                              }
                                            }
                                            ?>
                                          </tbody>
                                          <tr style="display: nones;">
                                            <td colspan="10" align="right">
                                              <strong>รวมเป็นเงินทั้งสิ้น</strong>
                                            </td>
                                            <td align="right">
                                              <span id="sum_total_order"><?=$total_summm;?></span>
                                            </td>
                                            <td></td>
                                          </tr>
                                        </table>
                                      <?php }?>
                                    </div>
                                  </div>
                                </div>
                                <!-- END FORM-->
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab_5">
                            <!-- BEGIN COMMENT PORTLET-->
                            <div class="col-md-12">
                              <div class="portlet light bordered">
                                <div class="portlet-title">
                                  <div class="caption font-green">
                                    <i class="fa  fa-commenting-o font-green"></i>
                                    <span class="caption-subject bold uppercase"> <?=$_SESSION[label_comment]?></span>
                                  </div>
                                </div>
                                <div class="portlet-body form">
                                  <div class="form-body">
                                    <div class="form-group form-md-line-input has-success " style="margin-bottom: 0px !important;">
                                      <div class="row">
                                        <div class="col-md-7">
                                          <input type="text" class="form-control bold required" id="s_comment" name="s_comment" >

                                        </div>
                                        <div class="col-md-5">
                                          <a href="javascript:addComment();"> <button type="button" class="btn blue"><?=$_SESSION[btn_addComment]?></button></a>
                                        </div>
                                      </div>
                                    </div>
                                    <br/>
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column dt-responsive" id="datatable-comment">
                                      <thead>
                                        <tr>
                                          <th style="width: 15px" class="no-sort">

                                          </th>

                                          <th  class="all">  <?=$_SESSION[tb_co_comment]?> </th>

                                      </thead>
                                      <tbody id="">

                                      </tbody>
                                    </table> 
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- END COMMENT PORTLET-->
                          </div>   
                          <div class="tab-pane fade" id="tab_6">
                            <!-- BEGIN COMMENT PORTLET-->
                            <div class="col-md-12">
                              <div class="portlet light bordered">
                                <div class="portlet-title">
                                  <div class="caption font-green">
                                    <i class="fa  fa-money font-green"></i>
                                    <span class="caption-subject bold uppercase"> ต้นทุน-กำไร</span>
                                  </div>
                                </div>
                                <div class="portlet-body form">
                                  <div class="form-body">

                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- END COMMENT PORTLET-->
                          </div>   
                          
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
              </div>
            </div>
            <!------------ CONTENT ------------>
          </div>
          <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->

      </div>
      <!-- END CONTAINER -->








      <!-- BEGIN FOOTER -->
      <?php include './templated/footer.php';?>
      <!-- END FOOTER -->
    </div>
    <!-- BEGIN QUICK NAV -->
    <?php include './templated/quick_nav.php';?>
    <!-- END QUICK NAV -->



    <!-- BEGIN CORE PLUGINS -->
    <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>


    <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

    <script src="../assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="js/common/markPattern.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
    <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script src="js/common/select2.min.js"></script>
    <script src="js/common/notify.js" type="text/javascript"></script>
    <link href="css/notify.css" rel="stylesheet" type="text/css" />

    <script src="js/common/notify.js" type="text/javascript"></script>
    <script src="js/common/utility.js" type="text/javascript"></script>
    <link href="css/custom.css" rel="stylesheet" type="text/css" />
    <link href="css/notify.css" rel="stylesheet" type="text/css" />
    <link href="outbound/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" />
    <script src="outbound/lightbox/js/lightbox.js" type="text/javascript"></script>
    <script src="js/action/queue/queue_all.js" type="text/javascript"></script>
    <script>
                                                        $(document).ready(function () {
                                                          initialDataTableComment(true);
                                                          unloading();

                                                        });

                                                        $('#btn_update_deliver').click(function () {
                                                          var dataForm = $('#action-deliver').serialize();
                                                          console.log(dataForm);
                                                          //*
                                                          $.post("controller/queue/createController.php", dataForm, function (data) {
                                                            var res = data.split(",");
                                                            if (res[0] == "0000") {
                                                              var errCode = "Code (" + res[0] + ") : " + res[1];
                                                              $.notify(errCode, "success");
                                                            } else {
                                                              var errCode = "Code (" + res[0] + ") : " + res[1];
                                                              $.notify(errCode, "error");
                                                              return;
                                                            }
                                                          });
                                                          //*/
                                                        });
                                                        
                                                        $('#btn_update_carin').click(function () {
                                                          var dataForm = $('#action-carin').serialize();
                                                          console.log(dataForm);
                                                          //*
                                                          $.post("controller/queue/createController.php", dataForm, function (data) {
                                                            var res = data.split(",");
                                                            if (res[0] == "0000") {
                                                              var errCode = "Code (" + res[0] + ") : " + res[1];
                                                              $.notify(errCode, "success");
                                                            } else {
                                                              var errCode = "Code (" + res[0] + ") : " + res[1];
                                                              $.notify(errCode, "error");
                                                              return;
                                                            }
                                                          });
                                                          //*/
                                                        });
    </script>
  </body>

</html>