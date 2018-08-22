<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
include './common/ConnectDB.php';
$db = new ConnectDB();
include './common/Utility.php';
$util = new Utility();
include './service/repair/createService.php';
$service = new createService();
ACTIVEPAGES(10,1);
if ($_GET[func] != NULL) {
  $tt_header = ($_GET[func] == "add" ? $_SESSION[add_info] : $_SESSION[edit_info]);
}
if ($_GET[id] == NULL) {
  //echo header("Location: re_check.php");
  //echo header("Location: queue_all.php");
}

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

$i_cust_car = $_GET[id];
$strSql = " select * ";
$strSql .= " FROM tb_report_invoice   WHERE ref_id = '".$_GET[id]."' ";
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
$arr[customer] = $db->Search_Data_FormatJson($strSql);
$s_title_th = getRowDisplay($arr[customer][0][i_title],'i_title','s_title_th','tb_title',$db);
$province = getRowDisplay($arr[customer][0][i_province],'i_province','s_name_th','tb_provinces',$db);
$amphure = getRowDisplay($arr[customer][0][i_amphure],'i_amphure','s_name_th','tb_amphures',$db);
$district = getRowDisplay($arr[customer][0][i_district],'i_district','s_name_th','tb_districts',$db);
$zipcode = getRowDisplay($arr[customer][0][i_district],'i_district','i_zipcode','tb_districts',$db);
$s_pay_type = getRowDisplay($arr[customer][0][s_pay_type],'s_pay_type','s_detail','tb_pay',$db);
$i_ins_type = getRowDisplay($arr[customer][0][i_ins_type],'i_ins_type','s_name','tb_insurance_type',$db);
$i_dmg = getRowDisplay($arr[customer][0][i_dmg],'i_dmg','s_dmg_th','tb_damage',$db);
$s_status = getRowDisplay($arr[customer][0][s_status],'s_status','s_detail_th','tb_status',$db);
$_GET[func] = "addQuatation";
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
                  <a href="report_invoice.php?id=<?=$i_cust_car;?>">ใบเสนอราคา</a>
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
                <input type="hidden" id="func" name="func" value="<?=$_GET[func]?>"/>
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
                  <!-- END STEP1-->
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
                              <div class="col-md-8">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group form-md-line-input has-success">
                                      <input type="text" class="form-control bold" id="s_no_bill" name="s_no_bill" value="<?=$s_no;?>" >
                                      <label for="s_no_bill">รหัสผู้ออกบิล </label>          
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group form-md-line-input has-success">
                                      <input type="numner" class="form-control bold" id="i_amount" name="i_amount"  >
                                      <label for="s_no_bill">**กรอกในกรณีรถประกัน จำนวนเงิน </label>          
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group form-md-line-input has-success">
                                      <input onkeyup="check_refno(this.value);" type="text" class="form-control bold" id="ref_no" name="ref_no" value="<?=$arr[customer][0][ref_no];?>" >
                                      <label for="ref_no">Ref no. </label>          
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-success">
                                      <input type="text" class="form-control bold" id="s_license" name="s_license" value="<?=$arr[customer][0][s_license];?>" >
                                      <label for="s_license">หมายเลขทะเบียนรถ</label>          
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-success">
                                      <input type="text" class="form-control bold" id="s_province" name="s_province" value="" >
                                      <label for="s_province">จังหวัด</label>          
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <h3>ลูกค้าทั่วไป</h3>
                                </div>
                                <div class="row">
                                  <div class="col-md-10">
                                    <div class="form-group form-md-line-input has-success">
                                      <input type="text" class="form-control bold" id="s_name" name="s_name" value="" >
                                      <label for="s_name">ชื่อ-นามสกุล หรือชื่อบริษัท </label>          
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-10">
                                    <div class="form-group form-md-line-input has-success">
                                      <input type="text" class="form-control bold" id="s_address" name="s_address" value="" >
                                      <label for="s_address">ที่อยุ่ </label>          
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-10">
                                    <div class="form-group form-md-line-input has-success">
                                      <input type="text" class="form-control bold" id="s_tax_no" name="s_tax_no" value="" >
                                      <label for="s_tax_no">เลขที่ประจำตัวผู้เสียภาษีหรือเลขบัตรประชาชน</label>          
                                    </div>
                                  </div>
                                </div>
                                <hr />
                                <div class="row">
                                  <h3>ข้อมูลสินค้า-บริการ</h3>
                                </div>
                                <div class="row">
                                  กรอกรหัส-รายละเอียด-จำนวน-ราคา <br />
                                  <table class="table">
                                    <tr>
                                      <td width="100">รหัส</td>
                                      <td>สินค้าหรือบริการ</td>
                                      <td>รายละเอียด</td>
                                      <td width="100">จำนวน</td>
                                      <td width="100">ราคาต่อหน่วย</td>
                                    </tr>
<?php
for ($i = 1; $i <= 6; $i++) {
  ?>
                                      <tr>
                                        <td><input type="text" name="s_list_code[]" id="s_list_code<?=$i;?>" class="form-control bold" /></td>
                                        <td><input type="text" name="s_list_name[]" id="s_list_name<?=$i;?>" class="form-control bold" /></td>
                                        <td><input type="text" name="s_list_detail[]" id="s_list_detail<?=$i;?>" class="form-control bold" /></td>
                                        <td><input type="text" name="s_list_amount[]" id="s_list_amount<?=$i;?>" class="form-control bold" /></td>
                                        <td><input type="text" name="s_list_price[]" id="s_list_price<?=$i;?>" class="form-control bold" /></td>
                                      </tr>
<?php }?>
                                  </table>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="row">
                                  <h3>ข้อมูล Ref no</h3>
                                </div>
                                <table class="table">
                                  <tr>
                                    <td>ประเภท</td>
                                    <td id="td_pay_type"><?=$s_pay_type;?></td>
                                  </tr>
                                  <tr>
                                    <td>ประกันภัย</td>
                                    <td id="td_ins_comp"><?=getInsuranceDisplay($arr[customer][0][i_ins_comp],$db);?></td>
                                  </tr>
                                  <tr>
                                    <td>รหัสผู้ซื้อ</td>
                                    <td  id="td_ref_nox"><?=$arr[customer][0][ref_no];?></td>
                                  </tr>
                                  <tr>
                                    <td>ทะเบียนรถ</td>
                                    <td id="td_license"><?=$arr[customer][0][s_license];?></td>
                                  </tr>
                                  <tr>
                                    <td>ยี่ห้อ</td>
                                    <td id="td_band"><?=$service->getBrand($arr[customer][0][s_brand_code]);?></td>
                                  </tr>
                                  <tr>
                                    <td>รุ่น</td>
                                    <td id="td_gen"><?=$service->getGeneration($arr[customer][0][s_gen_code]);?></td>
                                  </tr>
                                  <tr>
                                    <td>ชื่อ ลูกค้า</td>
                                    <td  id="td_name"><?=$arr[customer][0][s_firstname];?> <?=$arr[customer][0][s_lastname];?></td>
                                  </tr>
                                </table>
                              </div>
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
                        <button type="submit"  class="btn blue" ><i class="fa fa-save"></i> <?=$_SESSION[rp_btn_save]?></button>
                        <?php
                        if ($s_no) {
                          ?>
                          <a href="report/receive.php?id=<?=$_GET[id];?>" target="_blank"><button type="button"  class="btn green" ><i class="fa fa-print"></i> <?=$_SESSION[rp_btn_print]?></button></a>
  <?php
}
?>
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
    <script src="js/action/search/popup.js" type="text/javascript"></script>
    <script src="js/common/closeStep.js" type="text/javascript"></script>
    <script>
                                        var keyEdit = "<?=$i_cust_car?>";
    </script>
    <script>
      function check_refno(ref) {
        $.ajax({
          type: 'POST',
          url: 'controller/report/createController.php',
          data: {ref: ref, func: "getDetail"},
          success: function (data) {

              var obj = JSON.parse(data);
              $('#td_pay_type').html(obj.td_pay_type);
              $('#td_ins_comp').html(obj.td_ins_comp);
              $('#td_license').html(obj.td_license);
              $('#td_band').html(obj.td_band);
              $('#td_gen').html(obj.td_gen);
              $('#td_name').html(obj.td_name);
              $('#s_name').val(obj.td_name);
              $('#s_address').val(obj.s_address);
              $('#s_license').val(obj.td_license);
              $('#s_tax_no').val(obj.s_tax_no);
              console.log(obj);


          },
          error: function (data) {
          }
        });
      }
      $(document).ready(function () {
        function save_report() {
          $('#form-action').submit(function (e) {
            e.preventDefault();
            console.log($(this).serialize());
            var formData = new FormData($(this)[0]);
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
                  var url_blank = 'report/quotation.php?id=' + res[2];
                  window.open(url_blank, '_blank');
                  location.replace('report_quotation_list.php');
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
                  //setTimeout(reloadTime, 1000);
                });
              },
              error: function (data) {
              }
            });
          });
        }
        save_report();
        if (keyEdit == "") {
          unloading();
        }

      });
    </script>
  </body>
</html>