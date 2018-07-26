<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
include './common/ConnectDB.php';
$db = new ConnectDB();
$i_cust_car = $_GET[id];



$po_other[0][d_other_receive] = date('d-m-Y');
$po_other[0][d_other_order] = date('d-m-Y');


$strSql = " select list.* ";
$strSql .= " FROM tb_po_other_list list  WHERE ref_id = '" . $_GET[id] . "' ";
$_dataTable = $db->Search_Data_FormatJson($strSql);

$strSql = "select * from tb_partner_comp where s_status = 'A' order by i_part_comp asc ";
$DDLPartnercomp = $db->Search_Data_FormatJson($strSql);

$strSql = "select * from tb_employee where s_status = 'A' order by i_emp asc ";
$DDLEmployee = $db->Search_Data_FormatJson($strSql);

ACTIVEPAGES(4, 4);
if ($_GET[func] != NULL) {
  $tt_header = ($_GET[func] == "add" ? $_SESSION[add_info] : $_SESSION[edit_info]);
}
if ($_GET[id] == NULL) {
  //echo header("Location: re_check.php");
  echo header("Location: queue_all.php");
}
$_GET[func] = "add";
$disableElement = 'disabled="disable"';
?>
<!DOCTYPE html>
<html lang="en">
  <!-- BEGIN HEAD -->
  <head>
    <meta charset="utf-8" />
    <title><?= $_SESSION[title] ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="<?= $_SESSION[title_content] ?>"    name="description" />
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
    <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_other" />
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
      <?php include './templated/header.php'; ?>
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
            <?php include './templated/menu.php'; ?>   
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
            <?php include './templated/theme_panel.php'; ?>
            <!-- END THEME PANEL -->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
              <ul class="page-breadcrumb">
                <li>
                  <span><?= $_SESSION[po] ?></span>
                  <i class="fa fa-circle" style="color:  #00FF00;"></i>
                </li>
                <li>
                  <a href="po_other.php"><?= $_SESSION[po_create_other] ?></a>
                  <i class="fa fa-circle" style="color:  #00FF00;"></i>
                </li>
                <li>
                  <?= $tt_header ?>
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
                <input type="hidden" id="func" name="func" value="<?= $_GET[func] ?>"/>
                <input type="hidden" id="id" name="id" value="<?= $_GET[id] ?>"/>
                <input type="hidden" id="i_customer" name="i_customer" value=""/>
                <div class="col-md-12">
                  <div class="row" id="div-refno" style="display:none">
                    <div class="col-md-7">
                      <div class="form-group form-md-line-input has-success" >
                        <input type="text" class="form-control bold required" id="ref_car_info" name="ref_car_info" readonly="readonly" >
                        <label for="form_control_1"><?= $_SESSION[lb_re_refCarInfo] ?><span class="required"></span></label>          
                      </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                      <div class="form-group form-md-line-input has-success" >
                        <input type="text" class="form-control bold required" id="ref_no" name="ref_no" readonly="readonly" >
                        <label for="form_control_1"><?= $_SESSION[lb_re_refNo] ?> <span class="required"></span></label>          
                      </div>
                    </div> 
                  </div>
                  <!-- BEGIN STEP1-->
                  <div class="portlet box green">
                    <div class="portlet-title" onclick="closeStep(1)" style="cursor: pointer;">
                      <div class="caption">
                        <i class="fa fa-user"></i> <?= $_SESSION[tt_detail_create1] ?></div>
                      <div class="tools">
                        <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                        <!--<a href="javascript:closeStep(1);" class="fa fa-angle-down" style="color: white;text-decoration:none;"> </a>-->
                      </div>
                    </div>
                    <div class="portlet-body form" id="step1" style="display: none;">
                      <div class="portlet light bordered">
                        <!--                                                <div class="portlet-title">
                                                                            <div class="caption font-green inline">
                                                                                <span class="caption-subject bold uppercase"> <?= $_SESSION[1] ?></span>
                                                                                <a data-toggle="modal" href="#searchCust"> 
                                                                                    <button type="button" class="btn btn-success">
                                                                                        <i class="fa fa-search"></i>
                        <?= $_SESSION[btn_searchCustomer] ?>
                                                                                    </button>
                                                                                </a>
                                                                            </div>
                                                                        </div>-->
                        <div class="portlet-body form">
                          <div class="form-body">
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group form-md-line-input has-success">
                                  <select class="form-control edited bold" id="i_title" name="i_title" style="color:black;font-weight:bold;"  <?= $disableElement ?>    >
                                    <option value="-1"></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[lb_setCus_title] ?> <span class="required">*</span></label>          
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="s_firstname" name="s_firstname" <?= $disableElement ?>>
                                  <label for="form_control_1"><?= $_SESSION[lb_setCus_fname] ?> <span class="required">*</span></label>          
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="s_lastname"  name="s_lastname" <?= $disableElement ?>>
                                  <label  for="form_control_1"><?= $_SESSION[lb_setCus_lname] ?> <span class="required">*</span>
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
                                  <input type="text" class="form-control bold" id="s_phone_1" name="s_phone_1" <?= $disableElement ?>>
                                  <label for="form_control_1"><?= $_SESSION[lb_setCus_phone1] ?> <span class="required">*</span>
                                    <span id="class_val_phone" class="" >
                                      <i id="icon_val_phone" class=""></i>
                                      <span id="lb_val_phone"></span>
                                    </span>
                                  </label>          
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="s_phone_2" name="s_phone_2" <?= $disableElement ?>>
                                  <label for="form_control_1"><?= $_SESSION[lb_setCus_phone2] ?> <span class="required"></span>
                                    <span id="class_val_phone" class="" >
                                      <i id="icon_val_phone" class=""></i>
                                      <span id="lb_val_phone"></span>
                                    </span>
                                  </label>          
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group form-md-line-input has-success" >
                                  <input type="text" class="form-control bold" id="s_email" name="s_email" <?= $disableElement ?>>
                                  <label for="form_control_1"><?= $_SESSION[lb_setCus_email] ?> <span class="required"></span>
                                    <span id="class_val_secu" class="" >
                                      <i id="icon_val_secu" class=""></i>
                                      <span id="lb_val_secu"></span>
                                    </span>
                                  </label>          
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="s_line" name="s_line" <?= $disableElement ?>>
                                  <label for="form_control_1"><?= $_SESSION[lb_setCus_line] ?> <span class="required"></span>
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
                                  <input type="text" class="form-control bold" id="s_address" name="s_address" <?= $disableElement ?>>
                                  <label for="form_control_1"><?= $_SESSION[lb_setCus_address] ?> <span class="required">*</span>
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
                                  <select class="form-control edited bold" id="i_province" name="i_province"  <?= $disableElement ?>
                                          onchange="getDDLAmphure();"
                                          style="color:black;font-weight:bold;">
                                    <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[province] ?> <span class="required">*</span></label>          
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group form-md-line-input has-success">
                                  <select class="form-control edited bold" id="i_amphure" name="i_amphure"  <?= $disableElement ?>
                                          onchange="getDDLDistrict()"
                                          style="color:black;font-weight:bold;">
                                    <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[amphure] ?> <span class="required">*</span></label>          
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group form-md-line-input has-success">
                                  <select class="form-control edited bold" id="i_district" name="i_district" <?= $disableElement ?>
                                          onchange="getDDLZipcode()"
                                          style="color:black;font-weight:bold;">
                                    <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[district] ?> <span class="required">*</span></label>          
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group form-md-line-input has-success">
                                  <select class="form-control edited bold" id="i_zipcode" name="i_zipcode" <?= $disableElement ?> 
                                          style="color:black;font-weight:bold;">
                                    <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[zipcode] ?> <span class="required">*</span></label>          
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
                                  <select class="form-control edited bold" id="i_ins_comp" name="i_ins_comp" <?= $disableElement ?>>
                                    <!--<option value="-1"></option>-->
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[lb_re_insurance_comp] ?></label>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <label for="form_control_1" style="color: #36c6d3;"><?= $_SESSION[lb_re_dinbound] ?> <span class="required" style="color: red;">*</span></label> 
                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                  <span class="input-group-btn">
                                    <button class="btn default" type="button" <?= $disableElement ?>>
                                      <i class="fa fa-calendar"></i>
                                    </button>
                                  </span>
                                  <input type="text" class="form-control" readonly name="d_inbound" id="d_inbound" value="<?= date("d-m-Y") ?>"  <?= $disableElement ?>>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <label for="form_control_1" style="color: #36c6d3;"><?= $_SESSION[lb_re_doutbound_confirm] ?> <span class="required" style="color: red;">*</span></label> 
                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                  <span class="input-group-btn">
                                    <button class="btn default" type="button" <?= $disableElement ?>>
                                      <i class="fa fa-calendar"></i>
                                    </button>
                                  </span>
                                  <input type="text" class="form-control" readonly name="d_outbound_confirm" id="d_outbound_confirm" value="<?= date("d-m-Y") ?>"  <?= $disableElement ?>>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12"> 
                                <div class="form-group form-md-line-input has-success" >
                                  <div class="md-radio-inline" <?= $disableElement ?>>
                                    <div id="insurance_type"></div>
                                  </div>
                                  <input type="hidden" id="i_ins_type" name="i_ins_type" />
                                </div>
                              </div>
                            </div>
                            <div class="row" >
                              <div class="col-md-4">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold required" id="s_type_capital" name="s_type_capital" <?= $disableElement ?>>
                                  <label for="form_control_1"><?= $_SESSION[lb_re_type_capital] ?> <span class="required"></span></label>          
                                </div>
                              </div>
                              <div class="col-md-5">
                                <label for="form_control_1" style="color: #36c6d3;"><?= $_SESSION[lb_re_dexp] ?> <span class="required" style="color: red;">*</span></label> 
                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                  <span class="input-group-btn">
                                    <button class="btn default" type="button" <?= $disableElement ?>>
                                      <i class="fa fa-calendar"></i>
                                    </button>
                                  </span>
                                  <input type="text" class="form-control" readonly name="d_ins_exp" id="d_ins_exp" value="<?= date("d-m-Y") ?>"  <?= $disableElement ?>>
                                </div>
                              </div>
                              <div class="col-md-3">
                              </div> 
                            </div>
                            <div class="row" >
                              <div class="col-md-4">
                                <div class="form-group form-md-line-input has-success" >
                                  <select class="form-control edited bold" id="s_pay_type" name="s_pay_type" style="color:black;font-weight:bold;"   <?= $disableElement ?>>
                                    <option value="-1"></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[lb_re_paytype] ?> <span class="required">*</span></label>          
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
                                  <select class="form-control edited bold" id="i_year" name="i_year" <?= $disableElement ?>>
                                    <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[lb_setYear_year] ?></label>
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group form-md-line-input has-success" >
                                  <select class="form-control edited bold" id="s_brand_code" name="s_brand_code" onchange="getDDLGenSelect()" <?= $disableElement ?>>
                                    <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[lb_setBrand_code] ?></label>
                                </div>
                              </div>
                              <div class="col-md-3"></div> 
                            </div>			
                            <div class="row" >
                              <div class="col-md-4">
                                <div class="form-group form-md-line-input has-success" >
                                  <select class="form-control edited bold" id="s_gen_code" name="s_gen_code" <?= $disableElement ?>>
                                    <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                  </select>
                                  <label for="form_control_1"><?= $_SESSION[lb_setGen_code] ?></label>
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold required" id="s_license" name="s_license"  <?= $disableElement ?>>
                                  <label for="form_control_1"><?= $_SESSION[lb_re_carlicense] ?> <span class="required">*</span></label>          
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
                  <!-- BEGIN STEP2-->
                  <div class="portlet box green" id="div_receive<?= time(); ?>">
                    <div class="portlet-title" onclick="closeStep(2)" style="cursor: pointer;">
                      <div class="caption">
                        <i class="fa fa-shopping-cart"></i> <?= $_SESSION[po_create_other] ?></div>
                      <div class="tools">
                        <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                      </div>
                    </div>
                    <div class="portlet-body form" id="step2" style="display: block;">
                      <!-- BEGIN FORM-->
                      <div class="portlet light bordered">
                        <div class="portlet-body form">
                          <div class="form-body">
                            <div class="row" style="display: none;">
                              <div class="col-md-6">
                              </div>
                              <div class="col-md-6">
                                <div class="form-group form-md-line-input has-success">
                                  <input type="text" class="form-control bold" id="ref_id"  name="ref_id" value="<?= $_GET['id']; ?>">
                                  <label  for="form_control_1"><?= $_SESSION[tb_po_refno] ?> <span class="required">*</span>
                                  </label>          
                                </div>
                              </div>
                            </div>

                            <div class="row" id="div_withdraw<?= time(); ?>">
                              <!-- Order -->
                                <div class="col-md-12">
                                  <div class="row">
                                    <div class="col-md-3">
                                      <label for="d_order" style="color: #36c6d3;"><?= $_SESSION[tb_po_orderdate] ?> <span class="required" style="color: red;">*</span></label> 
                                      <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                        <span class="input-group-btn">
                                          <button class="btn default" type="button" <?= $disableView ?>>
                                            <i class="fa fa-calendar"></i>
                                          </button>
                                        </span>
                                        <input type="text" class="form-control" readonly name="d_order" id="d_order" value="<?= $po_other[0][d_other_order] ?>" >
                                      </div>
                                    </div>
                                    <div class="col-md-7">
                                      <div class="form-group form-md-line-input has-success">
                                        <select class="form-control edited bold" id="i_shop" name="i_shop"  style="color:black;font-weight:bold;">
                                          <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                          <?php
                                          foreach ($DDLPartnercomp as $data) {
                                            ?>
                                            <option value="<?= $data[i_part_comp]; ?>"><?= $data[s_comp_th]; ?></option>
                                            <?php
                                          }
                                          ?>
                                        </select>
                                        <label for="form_control_1"><?= $_SESSION[tb_po_shop] ?> <span class="required">*</span></label>          
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="row">
                                    <div class="col-md-3">
                                      <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control bold" id="s_code" name="s_code" >
                                        <label for="form_control_1"><?= $_SESSION[purchase_code] ?> <span class="required">*</span></label>          
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control bold" id="s_name" name="s_name" >
                                        <label for="form_control_1"><?= $_SESSION[purchase_name] ?> <span class="required">*</span></label>          
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control bold" id="i_amount" name="i_amount" >
                                        <label for="form_control_1"><?= $_SESSION[tb_po_amount] ?> <span class="required">*</span></label>          
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="portlet-body form">
                                        <div class="form-actions noborder">
                                          <button id="btn_add_order" type="button"  class="btn blue" ><?= $_SESSION[btn_add_order] ?></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  
                                </div>
                                <!-- Order -->

                            </div>

                            <hr />
                            <!-- Receive -->
                            <div class="row">
                              <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="d_receive" style="color: #36c6d3;"><?= $_SESSION[tb_po_receivedate] ?> <span class="required" style="color: red;">*</span></label> 
                                  <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                    <span class="input-group-btn">
                                      <button class="btn default" type="button" >
                                        <i class="fa fa-calendar"></i>
                                      </button>
                                    </span>
                                    <input type="text" class="form-control" readonly name="d_receive" id="d_receive" value="<?= $po_other[0][d_other_order] ?>"  <?= $disableView ?>>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group form-md-line-input has-success">
                                    <input type="text" class="form-control bold" id="s_no" name="s_no" >
                                    <label for="form_control_1"><?= $_SESSION[tb_po_no] ?> <span class="required">*</span></label>          
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-md-line-input has-success">
                                    <input type="number" class="form-control bold" id="i_price" name="i_price" >
                                    <label for="form_control_1"><?= $_SESSION[purchase_price] ?> <span class="required">*</span></label>          
                                  </div>
                                </div>
                              </div>
                              <div class="row">

                                
                                <div class="col-md-3">
                                  <div class="form-group form-md-line-input has-success" style="padding-top: 0px;">

                                    <input type="hidden" id="i_pay" name="i_pay" value="1"/>
                                    <label for="form_control_1"><?= $_SESSION[tb_po_payby] ?> <span class="required">*</span></label>          
                                    <div class="md-radio-inline" disabled="disable">
                                      <div id="insurance_type">
                                        <div class="md-radio">
                                          <input type="radio" id="i_pay1" onchange="setRadio_pay('1')" value="1" name="i_pay1" class="md-radiobtn" checked="checked">
                                          <label for="i_pay1"><span></span><span class="check"></span><span class="box"></span> เงินสด </label>
                                        </div>
                                        <div class="md-radio">
                                          <input type="radio" id="i_pay2" onchange="setRadio_pay('2')" value="2" name="i_pay1" class="md-radiobtn">
                                          <label for="i_pay2"><span></span><span class="check"></span><span class="box"></span> เครดิต </label>
                                        </div>



                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group form-md-line-input has-success">
                                    <select class="form-control edited bold" id="i_receive" name="i_receive" style="color:black;font-weight:bold;">
                                      <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                      <?php
                                      foreach ($DDLEmployee as $data) {
                                        ?>
                                        <option value="<?= $data[i_emp]; ?>"><?= $data[s_firstname]; ?> <?= $data[s_lastname]; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                    <label for="form_control_1"><?= $_SESSION[tb_po_receiveby] ?> <span class="required">*</span></label>          
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-md-line-input has-success">
                                    <input type="text" class="form-control bold" id="s_store" name="s_store" >
                                    <label for="s_store"><?= $_SESSION[po_dd_store] ?> <span class="required">*</span></label>          
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="portlet-body form">
                                    <div class="form-actions noborder">
                                      <button id="btn_recieve" type="button"  class="btn green" ><?= $_SESSION[btn_recieve_order] ?></button>

                                    </div>
                                  </div>
                                </div>

                              </div>
                              
                              
                            </div>
                            </div>

                            <hr />
                            <!--  withdraw -->
                            <div class="row">
                              <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="d_withdraw" style="color: #36c6d3;"><?= $_SESSION[tb_po_withdrawdate] ?> <span class="required" style="color: red;">*</span></label> 
                                  <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                    <span class="input-group-btn">
                                      <button class="btn default" type="button" >
                                        <i class="fa fa-calendar"></i>
                                      </button>
                                    </span>
                                    <input type="text" class="form-control" readonly name="d_withdraw" id="d_withdraw" value="<?= $po_other[0][d_other_order] ?>"  <?= $disableView ?>>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group form-md-line-input has-success">
                                    <input type="text" class="form-control bold" id="s_no_w" name="s_no_w" >
                                    <label for="s_no_w"><?= $_SESSION[tb_po_no] ?> <span class="required">*</span></label>          
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-md-line-input has-success">
                                    <select class="form-control edited bold" id="i_withdraw" name="i_withdraw" style="color:black;font-weight:bold;">
                                      <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                      <?php
                                      foreach ($DDLEmployee as $data) {
                                        ?>
                                        <option value="<?= $data[i_emp]; ?>"><?= $data[s_firstname]; ?> <?= $data[s_lastname]; ?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                    <label for="form_control_1"><?= $_SESSION[tb_po_withdrawby] ?> <span class="required">*</span></label>          
                                  </div>
                                </div>
                                
                                <div class="col-md-2">
                                  <div class="portlet-body form">
                                    <div class="form-actions noborder">
                                      <button id="btn_withdraw" type="button"  class="btn red" ><?= $_SESSION[btn_po_withdraw] ?></button>

                                    </div>
                                  </div>
                                </div>


                              </div>
                             

                               
                            </div>
                            </div>

                          </div>
                        </div>
                      </div>
                      <!-- END FORM-->
                    </div>
                  </div>
                  <!-- END STEP2-->
                  <!-- START STEP3-->
                  <div class="portlet box green">
                    <div class="portlet-title" onclick="closeStep(3)" style="cursor: pointer;">
                      <div class="caption">
                        <i class="fa fa-clock-o"></i> <?= $_SESSION[tb_po_history] ?></div>
                      <div class="tools">
                        <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                      </div>
                    </div>
                    <div class="portlet-body form" id="step3" style="display: block;">
                      <!-- BEGIN FORM-->
                      <div class="portlet light bordered">
                        <div class="portlet-body form">
                          <div class="form-body">
                            <div class="row" style="display: none">
                              <div class="col-md-12" align="right">
                                <div class="portlet-body form">
                                  <button onclick="add_row_order();" type="button"  class="btn blue" ><?= $_SESSION[btn_add] ?></button>
                                </div>
                              </div>
                            </div>
                            <hr  style="display: none"/>
                            <table width="100%" cellpadding="5" cellspacing="10">
                              <tr style="height: 35px; background-color: #32c5d2; color: #ffffff; font-weight: bold;">
                                <td align="center" width="100"><?= $_SESSION[tb_po_no] ?></td>
                                <td align="center" width="100"><?= $_SESSION[tb_po_orderdate] ?></td>
                                <td align="center" width="100"><?= $_SESSION[tb_po_receivedate] ?></td>
                                <td align="center" ><?= $_SESSION[po_dd_store] ?></td>
                                <td align="center" width="100"><?= $_SESSION[tb_po_withdrawdate] ?></td>
                                <td align="center"><?= $_SESSION[tb_po_shop] ?></td>
                                <td align="center" width="100"><?= $_SESSION[purchase_code] ?></td>
                                <td><?= $_SESSION[purchase_name] ?></td>
                                <td align="right" width="100"><?= $_SESSION[tb_po_payby] ?></td>
                                <td align="right" width="100"><?= $_SESSION[tb_po_amount] ?></td>
                                <td align="right" width="100"><?= $_SESSION[tb_po_price] ?></td>
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
                                } else {
                                  $no = 1;
                                  $i = 0;
                                  foreach ($_dataTable as $key => $value) {
                                    $strSql = " select s_firstname,s_lastname ";
                                    $strSql .= " FROM tb_employee   WHERE i_emp = '" . $_dataTable[$key]['i_receive'] . "' ";
                                    $employee = $db->Search_Data_FormatJson($strSql);
                                    $full_emp = $employee[0][s_firstname] . " " . $employee[0][s_lastname];

                                    $strSql = " select s_firstname,s_lastname ";
                                    $strSql .= " FROM tb_employee   WHERE i_emp = '" . $_dataTable[$key]['i_withdraw'] . "' ";
                                    $employee = $db->Search_Data_FormatJson($strSql);
                                    $full_withdraw = $employee[0][s_firstname] . " " . $employee[0][s_lastname];


                                    $strSql = " select s_comp_th ";
                                    $strSql .= " FROM tb_partner_comp   WHERE i_part_comp = '" . $_dataTable[$key]['i_shop'] . "' ";
                                    $comp = $db->Search_Data_FormatJson($strSql);
                                    $full_comp = $comp[0][s_comp_th];
                                    ?>
                                    <tr id="tr_order_<?= $i; ?>" style="height: 30px;">
                                      <td align="center">
                                        <?php
                                        if ($_dataTable[$key]['i_receive'] == 0) {
                                          ?>

                                          <?= $_dataTable[$key]['s_no']; ?>

                                          <?php
                                        } else {
                                          ?>
                                          <?= $_dataTable[$key]['s_no']; ?>
                                          <?php
                                        }
                                        ?>

                                      </td>
                                      <td align="center">
                                        <?= $_dataTable[$key]['d_order']; ?>
                                      </td>
                                      <td align="center">
                                        <?php
                                        if ($_dataTable[$key]['i_receive'] == 0) {
                                          ?>
                                          <a href="#div_receive<?= time(); ?>" onclick="func_recieve('<?= $_dataTable[$key]['s_no']; ?>');"><?= $_SESSION[tb_po_receive] ?></a>
                                          <?php
                                        } else {
                                          echo $_dataTable[$key]['d_receive'];
                                        }
                                        ?>
                                        <br />
                                        <?php
                                        if ($_dataTable[$key]['i_receive'] == 0) {
                                          echo "";
                                        } else {
                                          echo $full_emp;
                                        }
                                        ?>
                                      </td>
                                      <td align="center">
                                        <?= $_dataTable[$key]['s_store']; ?>
                                      </td>
                                      <td align="center">
                                        <?php
                                        if ($_dataTable[$key]['i_receive'] > 0) {
                                          if ($_dataTable[$key]['i_withdraw'] == 0) {
                                            ?>
                                            <a href="#div_withdraw<?= time(); ?>" onclick="func_withdraw('<?= $_dataTable[$key]['s_no']; ?>');"><?= $_SESSION[tb_po_withdraw] ?></a>
                                            <?php
                                          } else {
                                            echo $_dataTable[$key]['d_withdraw'];
                                            echo "<br />";
                                            echo $full_withdraw;
                                          }
                                        } else {
                                          echo "-";
                                        }
                                        ?>
                                      </td>
                                      <td align="center">
                                        <?php
                                        if ($_dataTable[$key]['i_shop'] == 0) {
                                          echo "-";
                                        } else {
                                          echo $full_comp;
                                        }
                                        ?>
                                      </td>
                                      <td align="center">
                                        <?= $_dataTable[$key]['s_code']; ?>
                                      </td>
                                      <td align="left">
                                        <?= $_dataTable[$key]['s_name']; ?>
                                      </td>
                                      <td align="right">
                                        <?php
                                        if ($_dataTable[$key]['i_pay'] == 2) {
                                          echo "เครดิต";
                                        } else {
                                          echo "เงินสด";
                                        }
                                        ?>
                                      </td>
                                      <td align="right">
                                        <?= $_dataTable[$key]['i_amount']; ?>
                                      </td>
                                      <td align="right">
                                        <?= $_dataTable[$key]['i_price']; ?>
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
                                <td colspan="9" align="right">
                                  <strong>รวมเป็นเงินทั้งสิ้น</strong>
                                </td>
                                <td align="right">
                                  <span id="sum_total_order"><?= $total_summm; ?></span>
                                </td>
                                <td></td>
                              </tr>
                            </table>
                            <input type="hidden" name="last_no" id="last_no" value="<?= $i; ?>"/>
                          </div>
                        </div>
                      </div>
                      <!-- END FORM-->
                    </div>
                  </div>
                  <!-- END STEP3-->
                  <!-- END EXAMPLE TABLE PORTLET-->
                </div>
                <div class="col-md-4" style="display:none">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="col-md-12" style="display: none;">
                    <div class="portlet light bordered">
                      <div class="portlet-title">
                        <div class="caption font-green">
                          <i class="fa fa-gears font-green"></i>
                          <span class="caption-subject bold uppercase"> <?= $_SESSION[label_status] ?></span>
                        </div>
                      </div>
                      <div class="portlet-body form">
                        <div class="form-body">
                          <div class="form-group form-md-line-input has-success " style="margin-bottom: 0px !important;">
                            <select class="form-control edited bold" id="status" name="status" disabled="true"  style="color:black;font-weight:bold;" >
                              <option value="-1"></option>
                            </select>
                            <label for="form_control_1"><?= $_SESSION[label_status] ?></label>
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
                          <span class="caption-subject bold uppercase"> <?= $_SESSION[label_comment] ?></span>
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
                                <a href="javascript:addComment();"> <button type="button" class="btn blue"><?= $_SESSION[btn_addComment] ?></button></a>
                              </div>
                            </div>
                          </div>
                          <br/>
                          <table class="table table-striped table-bordered table-hover table-checkable order-column dt-responsive" id="datatable-comment">
                            <thead>
                              <tr>
                                <th style="width: 15px" class="no-sort">
                                </th>
                                <th  class="all">  <?= $_SESSION[tb_co_comment] ?> </th>
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
                        <a href="re_check.php"> <button type="button" class="btn default"><?= $_SESSION[btn_cancel] ?></button></a>
                        <button type="submit"  class="btn blue" ><?= $_SESSION[btn_submit] ?></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" style="font-size: 12px; color: red;">
                  <div class="col-md-12">
                    <div class="portlet-body form">
                      <div class="col-md-6" align="left">
                        <span><?= $_SESSION[lb_create] ?> : <span id="lb_create"></span></span>
                      </div>
                      <div class="col-md-6" align="right">
                        <span><?= $_SESSION[lb_edit] ?> : <span id="lb_edit"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!------------ CONTENT ------------>
          </div>
          <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
      </div>
      <!-- END CONTAINER -->
      <span class="badge bg-primary"></span>
      <?php include './commonModal.php'; ?>
      <!-- BEGIN FOOTER -->
      <?php include './templated/footer.php'; ?>
      <!-- END FOOTER -->
    </div>
    <!-- BEGIN QUICK NAV -->
    <?php include './templated/quick_nav.php'; ?>
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
    <script src="js/action/po/po_otherForm.js?v=<?= JS_VERSION; ?>" type="text/javascript"></script>
    <script src="js/action/search/popup.js" type="text/javascript"></script>
    <script src="js/common/closeStep.js" type="text/javascript"></script>
    <script>
                                      var keyEdit = "<?= $i_cust_car ?>";
    </script>
    <script>
      $(document).ready(function () {
        //getDDLPartnercomp();
        //getDDLEmployee();
        getDDLStatus();
        save();
        if (keyEdit == "") {
          unloading();
        }
      });
    </script>
    <script>
      function add_row_order() {
        var last_no = parseInt($('#last_no').val()) + 1;
        $('#last_no').val(last_no);
        var tr_txt = '<tr id="tr_order_' + last_no + '">                                                       			<td align="center">                                                       				<a onclick="func_remove_tr(' + last_no + ');"><i class="fa fa-times"></i>                                                       			</td>                                                       			                                                        			<td>                                                       				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-right: 10px;">                                                                     <input type="text" class="form-control bold" id="s_po_other_code_' + last_no + '" name="s_po_other_code[]" >                                                                                                                                          </div>                                                       			</td><td>                                                       				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-right: 0px;">                                                                     <input type="text" class="form-control bold" id="s_po_other_order_' + last_no + '" name="s_po_other_order[]" >                                                                                                                                          </div>                                                       			</td>                                                       			<td>                                                       				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">                                                                     <input type="number" class="form-control bold cal_tr" onkeyup="func_cal_tr(' + last_no + ')"  onblur="func_cal_tr(' + last_no + ')" data-row="' + last_no + '" id="i_other_amount_' + last_no + '" name="i_other_amount[]" >                                                                                                                                          </div>                                                       			</td><td>                                                       				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">                                                                     <input type="number" class="form-control bold cal_tr" onkeyup="func_cal_tr(' + last_no + ')" onblur="func_cal_tr(' + last_no + ')"  data-row="' + last_no + '" id="i_other_price_' + last_no + '" name="i_other_price[]" >                                                                                                                                          </div>                                                       			</td>                                                       			                                                       			                                                       			<td></td>                                                       		</tr>                                                       		<tr>                                                       			<td colspan="6" style="border-bottom: 1px solid #cccccc;"></td>                                                       		</tr>';

        $('#tbody_order').append(tr_txt);
      }

      $('.remove_tr').click(function () {
        var row = $(this).attr('data-row');
        func_remove_tr(row);
      });

      function func_remove_tr(row) {
        $('#tr_order_' + row).closest('tr').remove();
        sum_total();
      }

      $('.cal_tr').keyup(function () {
        var row = $(this).attr('data-row');
        func_cal_tr(row);
      });
      $('.cal_tr').blur(function () {
        var row = $(this).attr('data-row');
        func_cal_tr(row);
      });
      function func_cal_tr(row) {
        var price = parseInt($('#i_other_price_' + row).val());
        var amount = parseInt($('#i_other_amount_' + row).val());
        var sum = price * amount;
        $('#total_' + row).html(sum);
        $('#total_txt_' + row).val(sum);
        sum_total();
      }
      function sum_total() {
        var last_no = $('#last_no').val();
        var total = 0;

        $(".quantity").each(function () {
          if (!isNaN(this.value) && this.value.length != 0) {
            total += parseFloat(this.value);
          }
        });

        $('#sum_total_order').html();
      }
    </script>

    <script>
      $('#btn_add_order').click(function () {
        var d_order = $('#d_order').val();
        var i_shop = $('#i_shop').val();
        var s_code = $('#s_code').val();
        var s_name = $('#s_name').val();
        var i_amount = $('#i_amount').val();
        var ref_id = $('#ref_id').val();
        var func = "addOrder";
        //alert(func)
        $.ajax({
          type: 'POST',
          url: 'controller/po/createControllerOther.php',
          data: {
            d_order: d_order
            , i_shop: i_shop
            , s_code: s_code
            , s_name: s_name
            , i_amount: i_amount
            , ref_id: ref_id
            , func: func
          },
          /*cache: false,
           contentType: false,
           processData: false,*/
          beforeSend: function () {
            $('#se-pre-con').fadeIn(100);
          },
          success: function (data) {
            var res = data.split(",");
            if (res[0] == "0000") {
              var errCode = "Code (" + res[0] + ") : " + res[1];
              $.notify(errCode, "success");
            } else {
              var errCode = "Code (" + res[0] + ") : " + res[1];
              $.notify(errCode, "error");
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
      });

      $('#btn_recieve').click(function () {
        var d_receive = $('#d_receive').val();
        var s_no = $('#s_no').val();
        var i_price = $('#i_price').val();
        var i_pay = $('#i_pay').val();
        var s_store = $('#s_store').val();
        var i_receive = $('#i_receive').val();
        var ref_id = $('#ref_id').val();
        var func = "recieveOrder";
        $.ajax({
          type: 'POST',
          url: 'controller/po/createControllerOther.php',
          data: {
            d_receive: d_receive
            , s_no: s_no
            , i_price: i_price
            , i_pay: i_pay
            , s_store: s_store
            , i_receive: i_receive
            , ref_id: ref_id
            , func: func
          },
          /*cache: false,
           contentType: false,
           processData: false,*/
          beforeSend: function () {
            $('#se-pre-con').fadeIn(100);
          },
          success: function (data) {
            var res = data.split(",");
            if (res[0] == "0000") {
              var errCode = "Code (" + res[0] + ") : " + res[1];
              $.notify(errCode, "success");
            } else {
              var errCode = "Code (" + res[0] + ") : " + res[1];
              $.notify(errCode, "error");
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

      });

      $('#btn_withdraw').click(function () {
        var d_withdraw = $('#d_withdraw').val();
        var s_no = $('#s_no_w').val();
        var i_withdraw = $('#i_withdraw').val();
        var ref_id = $('#ref_id').val();
        var func = "withdrawOrder";
        $.ajax({
          type: 'POST',
          url: 'controller/po/createControllerOther.php',
          data: {
            d_withdraw: d_withdraw
            , s_no: s_no
            , i_withdraw: i_withdraw
            , ref_id: ref_id
            , func: func
          },
          /*cache: false,
           contentType: false,
           processData: false,*/
          beforeSend: function () {
            $('#se-pre-con').fadeIn(100);
          },
          success: function (data) {
            var res = data.split(",");
            if (res[0] == "0000") {
              var errCode = "Code (" + res[0] + ") : " + res[1];
              $.notify(errCode, "success");
            } else {
              var errCode = "Code (" + res[0] + ") : " + res[1];
              $.notify(errCode, "error");
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

      });

      function func_recieve(s_no) {
        $('#s_no').val(s_no);
        $('#i_price').focus();
        $("#i_pay1").attr('checked', 'checked');
      }

      function func_withdraw(s_no) {
        $('#s_no_w').val(s_no);
        $('#i_withdraw').focus();
      }

      function setRadio_pay(pay) {
        $('#i_pay').val(pay);
      }
      $('#s_no_w').val('');
      $('#s_no').val('');
    </script>
  </body>
</html>