<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
include './common/ConnectDB.php';
$db = new ConnectDB();
ACTIVEPAGES(999,0);
if ($_GET[func] != NULL) {
  $tt_header = ($_GET[func] == "add" ? $_SESSION[add_info] : $_SESSION[edit_info]);
}
if ($_GET[id] == NULL) {
  //echo header("Location: re_check.php");
  echo header("Location: queue_all.php");
}
$i_cust_car = $_GET[id];

$strSql = " select * ";
$strSql .= " FROM tb_report_withholding   WHERE ref_id = '".$_GET[id]."' ";
$report = $db->Search_Data_FormatJson($strSql);

$strSql = "";
$strSql .= " SELECT ";
$strSql .= " car.* ";
$strSql .= " ,cus.s_firstname , cus.s_lastname , cus.s_address ,cus.s_phone_1 , cus.s_phone_2";
$strSql .= " ,ins.s_name_display ";
$strSql .= " ,brand.s_brand_name ";
$strSql .= " ,gen.s_gen_name ";
$strSql .= " FROM tb_customer_car car ";
$strSql .= " LEFT JOIN tb_customer cus ON car.i_customer = cus.i_customer ";
$strSql .= " LEFT JOIN tb_insurance_comp ins ON car.i_ins_comp = ins.i_ins_comp ";
$strSql .= " LEFT JOIN tb_car_brand brand ON car.s_brand_code = brand.s_brand_code ";
$strSql .= " LEFT JOIN tb_car_generation gen ON car.s_gen_code = gen.s_gen_code ";
$strSql .= " WHERE car.i_cust_car =".$_GET[id];
$_data = $db->Search_Data_FormatJson($strSql);


$_GET[func] = "addWithholding";
$disableElement = 'disabled="disable"';
?>
<!DOCTYPE html>
<html lang="en">
  <!-- BEGIN HEAD -->
  <head>
    <meta charset="utf-8" />
    <title><?=$_SESSION[title]?></title>
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
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <!--<link href="../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />-->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_spare" />
    <link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <!-- BEGIS SELECT 2 SCRIPTS -->
    <link href="css/select2.min.css" rel="stylesheet" />
    <!-- END SELECT 2 SCRIPTS -->
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
                  <span>ออกรายงาน</span>
                  <i class="fa fa-circle" style="color:  #00FF00;"></i>
                </li>
                <li>
                  <a href="report_withholding.php?id=<?=$i_cust_car;?>">ออกใบกำกับภาษี ณ ที่จ่าย</a>

                </li>
              </ul>
            </div>
            <!-- END PAGE BAR -->
            <div class="row">
              <br/>

            </div>
            <!------------ CONTENT ------------>
            <div class="row">
              <form enctype="multipart/form-data" name="form-action" id="form-action" method="post">
                <input type="hidden" id="func" name="func" value="addWithholding"/>
                <input type="hidden" id="id" name="id" value="<?=$_GET[id]?>"/>
                <input type="hidden" id="i_customer" name="i_customer" value=""/>
                <div class="col-md-12">
                  <div class="row" id="div-refno" style="display:none">
                    <div class="col-md-7">
                      <div class="form-group form-md-line-input has-success" >
                        <input type="text" class="form-control bold required" id="ref_car_info" name="ref_car_info" readonly="readonly" >
                        <label for="form_control_1"><?=$_SESSION[lb_re_refCarInfo]?><span class="required"></span></label>          
                      </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                      <div class="form-group form-md-line-input has-success" >
                        <input type="text" class="form-control bold required" id="ref_no" name="ref_no" readonly="readonly" >
                        <label for="form_control_1"><?=$_SESSION[lb_re_refNo]?> <span class="required"></span></label>          
                      </div>
                    </div> 
                  </div>
                  <!-- BEGIN STEP1-->
                  <div class="portlet box green">
                    <div class="portlet-title" onclick="closeStep(1)" style="cursor: pointer;">
                      <div class="caption">
                        <i class="fa fa-user"></i> <?=$_SESSION[tt_detail_create1]?></div>
                      <div class="tools">
                        <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                        <!--<a href="javascript:closeStep(1);" class="fa fa-angle-down" style="color: white;text-decoration:none;"> </a>-->
                      </div>
                    </div>
                    <div class="portlet-body form" id="step1" style="display: none;">
                      <div class="portlet light bordered">
                        <div class="portlet-body form">
                          <div class="form-body">
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group form-md-line-input has-success">
                                  <select class="form-control edited bold" id="i_title" name="i_title" style="color:black;font-weight:bold;"  <?=$disableElement?>    >
                                    <option value="-1"></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[lb_setCus_title]?> <span class="required">*</span></label>          
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="s_firstname" name="s_firstname" <?=$disableElement?>>
                                  <label for="form_control_1"><?=$_SESSION[lb_setCus_fname]?> <span class="required">*</span></label>          
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="s_lastname"  name="s_lastname" <?=$disableElement?>>
                                  <label  for="form_control_1"><?=$_SESSION[lb_setCus_lname]?> <span class="required">*</span>
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
                                  <input type="text" class="form-control bold" id="s_phone_1" name="s_phone_1" <?=$disableElement?>>
                                  <label for="form_control_1"><?=$_SESSION[lb_setCus_phone1]?> <span class="required">*</span>
                                    <span id="class_val_phone" class="" >
                                      <i id="icon_val_phone" class=""></i>
                                      <span id="lb_val_phone"></span>
                                    </span>
                                  </label>          
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="s_phone_2" name="s_phone_2" <?=$disableElement?>>
                                  <label for="form_control_1"><?=$_SESSION[lb_setCus_phone2]?> <span class="required"></span>
                                    <span id="class_val_phone" class="" >
                                      <i id="icon_val_phone" class=""></i>
                                      <span id="lb_val_phone"></span>
                                    </span>
                                  </label>          
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group form-md-line-input has-success" >
                                  <input type="text" class="form-control bold" id="s_email" name="s_email" <?=$disableElement?>>
                                  <label for="form_control_1"><?=$_SESSION[lb_setCus_email]?> <span class="required"></span>
                                    <span id="class_val_secu" class="" >
                                      <i id="icon_val_secu" class=""></i>
                                      <span id="lb_val_secu"></span>
                                    </span>
                                  </label>          
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="s_line" name="s_line" <?=$disableElement?>>
                                  <label for="form_control_1"><?=$_SESSION[lb_setCus_line]?> <span class="required"></span>
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
                                  <input type="text" class="form-control bold" id="s_address" name="s_address" <?=$disableElement?>>
                                  <label for="form_control_1"><?=$_SESSION[lb_setCus_address]?> <span class="required">*</span>
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
                                  <select class="form-control edited bold" id="i_province" name="i_province"  <?=$disableElement?>
                                          onchange="getDDLAmphure();"
                                          style="color:black;font-weight:bold;">
                                    <option value=""><?=$_SESSION[lb_please_select]?></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[province]?> <span class="required">*</span></label>          
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group form-md-line-input has-success">
                                  <select class="form-control edited bold" id="i_amphure" name="i_amphure"  <?=$disableElement?>
                                          onchange="getDDLDistrict()"
                                          style="color:black;font-weight:bold;">
                                    <option value=""><?=$_SESSION[lb_please_select]?></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[amphure]?> <span class="required">*</span></label>          
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group form-md-line-input has-success">
                                  <select class="form-control edited bold" id="i_district" name="i_district" <?=$disableElement?>
                                          onchange="getDDLZipcode()"
                                          style="color:black;font-weight:bold;">
                                    <option value=""><?=$_SESSION[lb_please_select]?></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[district]?> <span class="required">*</span></label>          
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group form-md-line-input has-success">
                                  <select class="form-control edited bold" id="i_zipcode" name="i_zipcode" <?=$disableElement?> 
                                          style="color:black;font-weight:bold;">
                                    <option value=""><?=$_SESSION[lb_please_select]?></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[zipcode]?> <span class="required">*</span></label>          
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
                                  <select class="form-control edited bold" id="i_ins_comp" name="i_ins_comp" <?=$disableElement?>>
                                    <!--<option value="-1"></option>-->
                                  </select>
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
                                  <input type="text" class="form-control" readonly name="d_inbound" id="d_inbound" value="<?=date("d-m-Y")?>"  <?=$disableElement?>>
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
                                  <input type="text" class="form-control" readonly name="d_outbound_confirm" id="d_outbound_confirm" value="<?=date("d-m-Y")?>"  <?=$disableElement?>>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12"> 
                                <div class="form-group form-md-line-input has-success" >
                                  <div class="md-radio-inline" <?=$disableElement?>>
                                    <div id="insurance_type"></div>
                                  </div>
                                  <input type="hidden" id="i_ins_type" name="i_ins_type" />
                                </div>
                              </div>
                            </div>
                            <div class="row" >
                              <div class="col-md-4">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold required" id="s_type_capital" name="s_type_capital" <?=$disableElement?>>
                                  <label for="form_control_1"><?=$_SESSION[lb_re_type_capital]?> <span class="required"></span></label>          
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
                                  <input type="text" class="form-control" readonly name="d_ins_exp" id="d_ins_exp" value="<?=date("d-m-Y")?>"  <?=$disableElement?>>
                                </div>
                              </div>
                              <div class="col-md-3">
                              </div> 
                            </div>
                            <div class="row" >
                              <div class="col-md-4">
                                <div class="form-group form-md-line-input has-success" >
                                  <select class="form-control edited bold" id="s_pay_type" name="s_pay_type" style="color:black;font-weight:bold;"   <?=$disableElement?>>
                                    <option value="-1"></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[lb_re_paytype]?> <span class="required">*</span></label>          
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
                                  <select class="form-control edited bold" id="i_year" name="i_year" <?=$disableElement?>>
                                    <option value=""><?=$_SESSION[lb_please_select]?></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[lb_setYear_year]?></label>
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group form-md-line-input has-success" >
                                  <select class="form-control edited bold" id="s_brand_code" name="s_brand_code" onchange="getDDLGenSelect()" <?=$disableElement?>>
                                    <option value=""><?=$_SESSION[lb_please_select]?></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[lb_setBrand_code]?></label>
                                </div>
                              </div>
                              <div class="col-md-3"></div> 
                            </div>			
                            <div class="row" >
                              <div class="col-md-4">
                                <div class="form-group form-md-line-input has-success" >
                                  <select class="form-control edited bold" id="s_gen_code" name="s_gen_code" <?=$disableElement?>>
                                    <option value=""><?=$_SESSION[lb_please_select]?></option>
                                  </select>
                                  <label for="form_control_1"><?=$_SESSION[lb_setGen_code]?></label>
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold required" id="s_license" name="s_license"  <?=$disableElement?>>
                                  <label for="form_control_1"><?=$_SESSION[lb_re_carlicense]?> <span class="required">*</span></label>          
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
                  <!-- BEGIN STEP5 General -->
                  <div class="portlet box green">
                    <div class="portlet-title" onclick="closeStep(5)" style="cursor: pointer;">
                      <div class="caption">
                        <i class="fa fa-clock-o"></i> ประวัติ</div>
                      <div class="tools">
                        <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                      </div>
                    </div>
                    <div class="portlet-body form" id="step5" style="display: block;">
                      <!-- BEGIN FORM-->
                      <table class="table">
                        <tr>
                          <td>เลขที่</td>
                          <td>วันที่สร้าง</td>
                          <td>ปริ้น</td>
                        </tr>
                        <?php
                        foreach ($report as $data) {
                          ?>
                          <tr>
                            <td><?=$data[id];?></td>
                            <td><?=$data[d_create];?></td>
                            <td><a target="_blank" href="report/withholding.php?id=<?=$data[id];?>">ปริ้น</a></td>
                          </tr>
                          <?php
                        }
                        ?>
                      </table>
                      <!-- END FORM-->
                    </div>
                  </div>
                  <!-- END STEP5-->
                  <!-- BEGIN STEP2 General -->
                  <div class="portlet box green">
                    <div class="portlet-title" onclick="closeStep(2)" style="cursor: pointer;">
                      <div class="caption">
                        <i class="fa fa-shopping-cart"></i> กรอกข้อมูลลูกค้า</div>
                      <div class="tools">
                        <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                      </div>
                    </div>
                    <div class="portlet-body form" id="step2" style="display: block;">
                      <!-- BEGIN FORM-->
                      <div class="portlet light bordered">
                        <div class="portlet-body form">
                          <div class="form-body">
                            <!-- Recieve -->
                            <div class="row">
                              <table width="100%" celpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td align="letf">
                                    <font style="font-size: 15px;">
                                    <strong>ชื่อ ที่อยู่ ของผู้ถูกหักภาษี ณ ที่จ่าย </strong><br />
                                    Name and Address of Recipient	
                                    </font>
                                  </td>
                                  <td width="140"></td>
                                  <td width="70"></td>
                                  <td width="70"></td>
                                  <td width="140"></td>
                                </tr>
                                <tr>
                                  <td rowspan="3" valign="top" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;padding: 5px;">
                                    <div class=" has-success">
                                      <input type="text" class="form-control bold" id="s_name" name="s_name" value="<?=$_data[0][s_firstname];?> <?=$_data[0][s_lastname];?>" >
                                    </div>
                                    <div class=" has-success">
                                      <textarea rows="4" class="form-control bold" id="s_address" name="s_address"><?=$_data[0][s_address];?></textarea>
                                    </div>
                                  </td>
                                  <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;padding: 2px;"   align="right">
                                    <strong style="font-size: 15px;">
                                      รหัสผู้ขาย :
                                    </strong>
                                  </td>
                                  <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
                                    <div class=" has-success">
                                      <input type="text" class="form-control bold" id="s_code" name="s_code" value="" >      
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;padding: 2px;"   align="right">
                                    <strong style="font-size: 15px;">
                                      เลขประจำตัวประชาชน :
                                    </strong>
                                  </td>
                                  <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
                                    <div class=" has-success">
                                      <input type="text" class="form-control bold" id="s_identi" name="s_identi" value="" >      
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;padding: 2px;"   align="right">
                                    <strong style="font-size: 15px;">
                                      เลขประจำตัวผู้เสียภาษีอากร :</strong><br />
                                    ของผู้ถูกหักภาษี ณ ที่จ่าย  
                                  </td>
                                  <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
                                    <div class=" has-success">
                                      <input type="text" class="form-control bold" id="s_tax" name="s_tax" value="" >      
                                    </div>
                                  </td>
                                </tr>


                                <tr>
                                  <td style="border:1px solid #000;border-right:1px solid #000;" colspan="5">
                                    <table class="table" cellpadding="1" border="0" cellspacing="1" >
                                      <tr>
                                        <td></td>
                                        <td colspan="4">ประเภท</td>
                                        <td style="width: 110px;">จำนวนเงิน</td>
                                        <td style="width: 110px;"></td>
                                      </tr>
                                      <tr>
                                        <td width="10">1.</td>
                                        <td colspan="4">
                                          เงินเดือน ค่าจ้าง เบี้ยเลี้ยง โบนัส ฯลฯ ตามมาตรา 40 (1)
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax1" name="s_tax1" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td>2.</td>
                                        <td colspan="4">
                                          ค่าธรรมเนียม ค่านายหน้า ฯลฯ ตามมาตรา 40 (2)
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax2" name="s_tax2" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td>3.</td>
                                        <td colspan="4">
                                          ค่าแห่งลิขสิทธิ์ ฯลฯ ตามมาตรา 40 (3)
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax3" name="s_tax3" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td valign="top">4.</td>
                                        <td>(ก)</td>
                                        <td  colspan="3">ค่าดอกเบี้ย ฯลฯ ตามมาตรา 40 (4) (ก)</td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax4" name="s_tax4" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td>(ข)</td>
                                        <td colspan="3">เงินปันผล เงินส่วนแบ่งกำไร ฯลฯ ตามมาตรา 40</td>
                                        <td></td>
                                        <td>อัตราร้อยละ</td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td valign="top">(1)</td>
                                        <td colspan="2">
                                          กรณีผู้ได้รับเงินปันผลได้รับเครดิต โดยจ่ายจาก กำไรสุทธิ<br />
                                          ของกิจการที่ต้องเสียภาษีเงินได้นิติบุคคล ในอัตราดังนี้
                                        </td>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>(1.1)</td>
                                        <td>อัตราร้อยละ 30 ของกำไรสุทธิ</td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax411" name="s_tax411" value="" >      
                                          </div>
                                        </td>
                                        <td>
                                          30%
                                        </td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>(1.2)</td>
                                        <td>อัตราร้อยละ 25 ของกำไรสุทธิ</td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax412" name="s_tax412" value="" >      
                                          </div>
                                        </td>
                                        <td>
                                          25%
                                        </td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>(1.3)</td>
                                        <td>อัตราร้อยละ 20 ของกำไรสุทธิ</td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax413" name="s_tax413" value="" >      
                                          </div>
                                        </td>
                                        <td>20%</td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>(1.4)</td>
                                        <td>อัตราอื่นๆ (ระบุ)..............ของกำไรสุทธิ</td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax414" name="s_tax414" value="" >      
                                          </div>
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_per414" name="s_per414" value="" >      
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td valign="top">(2)</td>
                                        <td colspan="2">
                                          กรณีผู้ได้รับเงินปันผลได้รับเครดิตภาษีเนื่องจากจ่ายจาก
                                        </td>
                                        <td></td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>(2.1)</td>
                                        <td>กำไรสุทธิของกิจการที่ได้รับยกเว้นภาษีเงินได้นิติบุคคล</td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax421" name="s_tax421" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td  valign="top">(2.2)</td>
                                        <td>
                                          เงินปันผลหรือเงินส่วนแบ่งกำไรที่ได้รับยกเว้นไม่ต้อง<br />
                                          นำมารวมคำนวณเป็นรายได้เพื่อเสียภาษีเงินได้นิติบุคคล
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax422" name="s_tax422" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td valign="top">(2.3)</td>
                                        <td>
                                          กำไรสุทธิส่วนที่ได้หักผลขาดทุนสุทธิยกมาไม่เกิน 5 ปี<br />
                                          ก่อนรอบระยะเวลาบัญชีปีปัจจุบัน
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax423" name="s_tax423" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>(2.4)</td>
                                        <td>กำไรที่รับรู้ทางบัญชีโดยวิธีส่วนได้เสีย</td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax424" name="s_tax424" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>(2.5)</td>
                                        <td>อื่นๆ (ระบุ).....................................................</td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax425" name="s_tax425" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td  valign="top">5.</td>
                                        <td colspan="4">
                                          การจ่ายเงินได้ที่ต้องหักภาษี ณ ที่จ่าย ตามคำสั่งกรมสรรพากรที่ออก <br />
                                          ตามมาตรา 3 เตรส เช่น รางวัล ส่วนลดหรือประโยชน์ใดๆ เนื่องจากการ<br />
                                          ส่งเสริมการขาย รางวัลในการประกวด การแข่งขัน การชิงโชค ค่าแสดง<br />
                                          ของนักแสดงสาธารณะ ค่าจ้างทำของ ค่าโฆษณา ค่าเช่า ค่าขนส่ง<br />
                                          ค่าบริการ ค่าเบี้ยประกันวินาศภัย ฯลฯ
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax5" name="s_tax5" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td  valign="top">6.</td>
                                        <td colspan="4">
                                          เงินได้จากวิชาชีพอิสระ
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax6" name="s_tax6" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td  valign="top">7.</td>
                                        <td colspan="4">
                                          เงินได้จากการรับเหมา
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax7" name="s_tax7" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td>8.</td>
                                        <td colspan="4">
                                          เงินได้อื่นๆ นอกจากที่ระบุไว้ในประเภทที่ 1 ถึงประเภทที่ 7
                                        </td>
                                        <td>
                                          <div class=" has-success">
                                            <input type="number" class="form-control bold" id="s_tax8" name="s_tax8" value="" >      
                                          </div>
                                        </td>
                                        <td></td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>

                              </table>

                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- END FORM-->
                    </div>
                  </div>
                  <!-- END STEP2-->
                  <!-- END EXAMPLE TABLE PORTLET-->
                </div>
                <div class="col-md-4" style="display: none;">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="col-md-12" style="display: none;">
                    <div class="portlet light bordered">
                      <div class="portlet-title">
                        <div class="caption font-green">
                          <i class="fa fa-gears font-green"></i>
                          <span class="caption-subject bold uppercase"> <?=$_SESSION[label_status]?></span>
                        </div>
                      </div>
                      <div class="portlet-body form">
                        <div class="form-body">
                          <div class="form-group form-md-line-input has-success " style="margin-bottom: 0px !important;">
                            <select class="form-control edited bold" id="status" name="status" disabled="true"  style="color:black;font-weight:bold;" >
                              <option value="-1"></option>
                            </select>
                            <label for="form_control_1"><?=$_SESSION[label_status]?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
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
                <div class="row">
                  <div class="col-md-12">
                    <div class="portlet-body form">
                      <div class="form-actions noborder">
                        <a href="queue_all.php"> <button type="button" class="btn default"><?=$_SESSION[btn_cancel]?></button></a>
                        <button type="button" onclick="save_reportAdd();"  class="btn blue" ><i class="fa fa-save"></i> บันทึกข้อมูล</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" style="font-size: 12px; color: red;">
                  <div class="col-md-12">
                    <div class="portlet-body form">
                      <div class="col-md-6" align="left">
                        <span><?=$_SESSION[lb_create]?> : <span id="lb_create"></span></span>
                      </div>
                      <div class="col-md-6" align="right">
                        <span><?=$_SESSION[lb_edit]?> : <span id="lb_edit"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <script>
              function save_reportAdd() {

                //$('#form-action').submit(function (e) {
                //e.preventDefault();
                console.log($('#form-action').serialize());
                var formData = new FormData($('#form-action')[0]);
                $.ajax({
                  type: 'POST',
                  url: 'controller/report/createController.php',
                  data: formData,
                  cache: false,
                  contentType: false,
                  processData: false,
                  beforeSend: function () {
                    $('#se-pre-con').fadeIn(100);
                  },
                  success: function (data) {
                    var res = data.split(",");
                    if (res[0] == "0000") {
                      var errCode = "Code (" + res[0] + ") : " + res[1];
                      $.notify(errCode, "success");
                      //location.replace('report/withholding.php?id='+res[2]);
                      //var url_blank = 'report/withholding.php?id='+res[2];
                      //window.open(url_blank, '_blank');
                      //$('#btn_report_page').trigger('click');
                      //window.location.href = $('#btn_report_page').attr('href');
                    } else {
                      var errCode = "Code (" + res[0] + ") : " + res[1];
                      $.notify(errCode, "error");
                      //fix
                      $('#se-pre-con').delay(100).fadeOut();
                      return;
                    }

                    notification();
                    $('#form-action').each(function () {
                      setTimeout(reloadTime, 1000);
                    });
                  },
                  error: function (data) {

                  }
                });
                //});
              }
            </script>
            <!------------ CONTENT ------------>
            <a href="report/receive.php?id=<?=$_GET[id];?>" target="_blank" id="btn_report_page"></a>
          </div>
          <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
      </div>
      <!-- END CONTAINER -->
      <span class="badge bg-primary"></span>
      <?php include './commonModal.php';?>
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
    <link href="css/custom.css" rel="stylesheet" type="text/css" />
    <link href="outbound/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" />
    <script src="outbound/lightbox/js/lightbox.js" type="text/javascript"></script>
    <!--<link href="css/custom_select2.css" rel="stylesheet" />-->
    <script src="js/action/po/po_spareForm.js?v=<?=JS_VERSION;?>" type="text/javascript"></script>
    <script src="js/action/search/popup.js" type="text/javascript"></script>
    <script src="js/common/closeStep.js" type="text/javascript"></script>
    <script>
              var keyEdit = "<?=$i_cust_car?>";
    </script>
    <script>
      $(document).ready(function () {

        getDDLStatus();
        //save_report();
        if (keyEdit == "") {
          unloading();
        }
      });
    </script>



  </body>
</html>