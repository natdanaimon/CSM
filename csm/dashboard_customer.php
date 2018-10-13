<?php
@session_start();
error_reporting(E_ERROR | E_PARSE);
include './common/Permission.php';
include './common/FunctionCheckActive.php';
//include './controller/dashboardCSController.php';
//include './service/dashboardCSService.php';
require_once('./common/ConnectDB.php');
ACTIVEPAGES(0);
date_default_timezone_set("Asia/Bangkok");
include './common/Utility.php';
$util = new Utility();
include './service/repair/createService.php';
$service = new createService();

$db = new ConnectDB();

$db = new ConnectDB();
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


$strSql = "";
$strSql .= " SELECT ";
$strSql .= " * ";
$strSql .= " FROM tb_print_record  ";
$strSql .= " WHERE i_cust_car =".$_GET[id];
$_record = $db->Search_Data_FormatJson($strSql);
if ($_record[0][i_receive] == NULL) {
  $chk_no = 1;
  $strSql = "";
  $strSql .= "INSERT ";
  $strSql .= "INTO ";
  $strSql .= "  tb_print_record ( ";
  $strSql .= "    i_receive ";
  $strSql .= "    ,i_cust_car ";
  $strSql .= "  ) ";
  $strSql .= "VALUES( ";
  $strSql .= "  '$chk_no' ";
  $strSql .= "  ,'$_GET[id]' ";
  $strSql .= ") ";
  $arr = array(
      array("query" => "$strSql")
  );
  $reslut = $db->insert_for_upadte($arr);
}
else {
  $chk_no = $_record[0][i_receive] + 1;
  $strSql = "";
  $strSql .= "update tb_print_record ";
  $strSql .= "set  ";
  $strSql .= "i_receive = '$chk_no' ";
  $strSql .= "where i_cust_car = '".$_GET[id]."' ";
  $arr = array(
      array("query" => "$strSql")
  );
  $reslut = $db->insert_for_upadte($arr);
}

$s_run_no = "CHK-".$chk_no;
//$s_run_no = "";


$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " list.i_repair_item,list.s_remark ";
$strSql .= " ,item.s_repair_name ";
$strSql .= " FROM tb_list_repair list ";
$strSql .= " LEFT JOIN tb_repair_item item ON list.i_repair_item = item.i_repair_item ";
$strSql .= " WHERE list.ref_no =".$_data[0][ref_no];
$list_repair = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " list.i_repair_item,list.s_remark ";
$strSql .= " ,item.s_repair_name ";
$strSql .= " FROM tb_check_repair list ";
$strSql .= " LEFT JOIN tb_repair_item item ON list.i_repair_item = item.i_repair_item ";
$strSql .= " WHERE list.ref_no =".$_data[0][ref_no];
$check_repair = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " *";
$strSql .= " FROM tb_check_repair_other list ";
$strSql .= " WHERE list.ref_no =".$_data[0][ref_no];
$check_repair_other = $db->Search_Data_FormatJson($strSql);
$db->close_conn();


$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " *";
$strSql .= " FROM tb_list_repair_other list ";
$strSql .= " WHERE list.ref_no =".$_data[0][ref_no];
$list_repair_other = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " * ";
$strSql .= " FROM tb_car_accessories  ";
$list_access = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " * ";
$strSql .= " FROM tb_car_lighting  ";
$list_lighting = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

$strSql = " select * ";
$strSql .= " FROM tb_report_receive   WHERE ref_id = '".$_GET[id]."' ";
$receive = $db->Search_Data_FormatJson($strSql);

$s_no = $receive[0][s_no];
$s_color = $receive[0][s_color];
$s_fuel = $receive[0][s_fuel];
$s_distance = $receive[0][s_distance];
$s_remark = $receive[0][s_remark];


$strSql = " select * ";
$strSql .= " FROM tb_comment   WHERE ref_no = '".$_data[0][ref_no]."' order by d_create desc ";
$comment = $db->Search_Data_FormatJson($strSql);
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
    <link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
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
      <?php // include './templated/header.php';  ?>
      <!-- END HEADER -->
      <!-- BEGIN HEADER & CONTENT DIVIDER -->
      <div class="clearfix"> </div>
      <!-- END HEADER & CONTENT DIVIDER -->
      <!-- BEGIN CONTAINER -->
      <div class="page-container" style="margin-top: 0px;">
        <!-- BEGIN SIDEBAR -->

        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->

        <!-- BEGIN CONTENT BODY -->
        <div class="page-content" style="padding: 0px;">
          <!-- BEGIN PAGE HEADER-->
          <!-- BEGIN THEME PANEL -->
          <?php //include './templated/theme_panel.php';  ?>
          <!-- END THEME PANEL -->
          <!-- BEGIN PAGE BAR -->

          <!-- END PAGE BAR -->

          <!-- END PAGE HEADER-->
          <div class="row" style="margin-left: 0px; margin-right: 0px;">

            <!-- ****************************  -->                            
            <!-- ****************************  --> 
            <?php
            $thaimonth = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
            ?>
            <!-- ****************************  -->                            
            <!-- ****************************  -->  
            <table width="100%">
              <tr>
                <td width="50%" valign="top">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="text-danger"><i class="fa fa-edit"></i> ข้อมูลตรวจสภาพก่อนนำซ่อม</h1>
                    <div class="portlet box green">
                      <div class="portlet-title">
                        <div class="caption">
                          <i class="fa fa-user"></i> <?=$_SESSION[tt_detail_create1]?></div>
                        <div class="tools">
                        </div>
                      </div>
                      <div class="portlet-body form">
                        <div class="portlet light bordered">
                          <div class="portlet-body form">
                            <table width="100%">
                              <tr>
                                <td widht="50%" valign="top">
                                  <span class="caption-subject bold uppercase text-success"> รายละเอียดลูกค้า</span>
                                  <table width="100%">
                                    <tr>
                                      <td width="100">REF.NO.</td>
                                      <td><?php echo $_data[0][ref_no];?></td>
                                    </tr>
                                    <tr>
                                      <td>ชื่อ-นามสกุล </td>
                                      <td>คุณ<?php echo $_data[0][s_firstname];?> <?php echo $_data[0][s_lastname];?></td>
                                    </tr>
                                    <tr>
                                      <td>ที่อยุ่</td>
                                      <td><?php echo $_data[0][s_address];?></td>
                                    </tr>
                                    <tr>
                                      <td>เบอร์ติดต่อ</td>
                                      <td>
                                        <?php echo $_data[0][s_phone_1];?> <?php echo $_data[0][s_phone_2];?>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td valign="top">
                                  <span class="caption-subject bold uppercase text-success"> รายละเอียดรถยนต์</span>
                                  <table width="100%">
                                    <tr>
                                      <td width="100">ยี่ห้อ/รุ่น</td>
                                      <td colspan="2"><?php echo $_data[0][s_brand_name];?> <?php echo $_data[0][s_gen_name];?></td>
                                      <td>ปี <?php echo $_data[0][i_year];?></td>
                                    </tr>
                                    <tr>
                                      <td>ทะเบียน</td>
                                      <td colspan="2"><?php echo $_data[0][s_license];?></td>
                                      <td>สี <?=$s_color;?></td>
                                    </tr>
                                    <tr>
                                      <td>ประกันภัย</td>
                                      <td colspan="3"><?php echo $_data[0][s_name_display];?></td>
                                    </tr>
                                    <tr>
                                      <td>ปริมาณน้ำมัน</td>
                                      <td><?=$s_fuel;?></td>
                                      <td>กม.วันที่เข้าจอด</td>
                                      <td><?=$s_distance;?></td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- ================================================================================ -->
                    <div class="portlet box green">
                      <div class="portlet-title">
                        <div class="caption">
                          <i class="fa fa-car"></i> ข้อมูลตรวจสภาพรถก่อนนำซ่อม</div>
                        <div class="tools">
                        </div>
                      </div>
                      <div class="portlet-body form">
                        <div class="portlet light bordered">
                          <div class="portlet-body form">
                            <table width="100%"  style="min-height: 50px;">
                              <tr>
                                <td widht="100%" valign="top">
                                  <span class="caption-subject bold uppercase text-success"> รายการตรวจสอบความเสียหาย ณ วันที่นำรถเข้าจอดซ่อม</span>

                                  <table width="100%">
                                    <?php
                                    $count = 0;
                                    foreach ($check_repair as $data) {
                                      ?>
                                      <?php
                                      if ($count == 0) {
                                        ?>
                                        <tr>
                                          <?php
                                        }
                                        ?>
                                        <td><?=$data[s_repair_name];?> <?=$data[s_remark];?></td>
                                        <?php
                                        $count++;
                                        if (($count % 2) == 0) {
                                          ?>
                                        </tr>
                                        <?php
                                      }
                                      ?>
                                    <?php }?>
                                    <?php
                                    for ($i = 1; $i <= 13; $i++) {
                                      $s_txt_x = 's_txt_'.$i;
                                      $s_txt_ok = $check_repair_other[0][$s_txt_x];
                                      if ($s_txt_ok != '') {

                                        if ($count == 0) {
                                          ?>
                                          <tr>
                                            <?php
                                          }
                                          ?>
                                          <td width="50%"><?=$s_txt_ok;?></td>
                                          <?php
                                          $count++;
                                          if (($count % 2) == 0) {
                                            ?>
                                          </tr>
                                          <?php
                                        }
                                      }
                                    }
                                    ?>
                                  </table>

                                </td>
                              </tr>
                            </table>
                            <table width="100%">
                              <tr>
                                <td widht="50%" valign="top">
                                  <span class="caption-subject bold uppercase text-success"> อุปกรณ์ไฟฟ้าพื้นฐานและระบบไฟส่องสว่าง</span>
                                  <table width="100%" cellpadding="0">
                                    <?php
                                    foreach ($list_lighting as $data) {
                                      $strSql = " select * ";
                                      $strSql .= " FROM tb_report_lighting   WHERE i_lighting = '".$data[id]."' and ref_id = '".$_GET[id]."'  ";
                                      $_lighting = $db->Search_Data_FormatJson($strSql);
                                      $chk_lighting = $_lighting[0][i_status];
                                      if ($chk_lighting == 1) {
                                        $chkbox = 'ปกติ';
                                      }
                                      elseif ($chk_lighting == 2) {
                                        $chkbox = 'ผิดปกติ';
                                      }
                                      else {
                                        $chkbox = "ไม่มี";
                                      }
                                      ?>
                                      <tr>
                                        <td width="60" align="center"><?=$chkbox;?></td>
                                        <td>
                                          <?=$data[s_name];?>
                                        </td>
                                      </tr>
                                      <?php
                                    }
                                    ?>
                                  </table>
                                  หมายเหตุ : <?=$s_remark;?>
                                </td>
                                <td valign="top">
                                  <span class="caption-subject bold uppercase text-success"> อุปกรณ์เครื่องมือประจำรถ</span>
                                  <table width="100%" cellpadding="0">
                                    <?php
                                    foreach ($list_access as $data) {
                                      $strSql = " select * ";
                                      $strSql .= " FROM tb_report_accessories   WHERE i_accessories = '".$data[id]."' and ref_id = '".$_GET[id]."'  ";
                                      $_accessories = $db->Search_Data_FormatJson($strSql);
                                      $chk_accessories = $_accessories[0][i_status];
                                      if ($chk_accessories == 1) {
                                        $chkbox = 'มี';
                                      }
                                      elseif ($chk_accessories == 2) {
                                        $chkbox = 'ไม่มี';
                                      }
                                      else {
                                        $chkbox = "-";
                                      }
                                      ?>
                                      <tr>
                                        <td width="60" align="center"><?=$chkbox;?></td>
                                        <td>
                                          <?=$data[s_name];?>
                                        </td>
                                      </tr>
                                      <?php
                                    }
                                    ?>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            <span class="caption-subject bold uppercase text-danger">**หากรายการไหนที่เว้นไว้หมายความว่าไม่ได้ตรวจสอบก่อนจอดซ่อม</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- ================================================================================ -->
                    <div class="portlet box green">
                      <div class="portlet-title">
                        <div class="caption">
                          <i class="fa fa-car"></i> ข้อมูลตรวจสภาพรถก่อนนำซ่อม</div>
                        <div class="tools">
                        </div>
                      </div>
                      <div class="portlet-body form">
                        <div class="portlet light bordered">
                          <div class="portlet-body form">
                            <table width="100%" style="min-height: 50px;">
                              <tr>
                                <td widht="100%" valign="top">
                                  <span class="caption-subject bold uppercase text-success"> รายการซ่อม</span>

                                  <table width="100%">
                                    <?php
                                    $count = 0;
                                    foreach ($list_repair as $data) {
                                      ?>
                                      <?php
                                      if ($count == 0) {
                                        ?>
                                        <tr>
                                          <?php
                                        }
                                        ?>
                                        <td><?=$data[s_repair_name];?> <?=$data[s_remark];?></td>
                                        <?php
                                        $count++;
                                        if (($count % 2) == 0) {
                                          ?>
                                        </tr>
                                        <?php
                                      }
                                      ?>
                                    <?php }?>
                                    <?php
                                    for ($i = 1; $i <= 13; $i++) {
                                      $s_txt_x = 's_txt_'.$i;
                                      $s_txt_ok = $list_repair_other[0][$s_txt_x];
                                      if ($s_txt_ok != '') {

                                        if ($count == 0) {
                                          ?>
                                          <tr>
                                            <?php
                                          }
                                          ?>
                                          <td width="50%"><?=$s_txt_ok;?></td>
                                          <?php
                                          $count++;
                                          if (($count % 2) == 0) {
                                            ?>
                                          </tr>
                                          <?php
                                        }
                                      }
                                    }
                                    ?>
                                  </table>

                                </td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- ================================================================================ -->

                  </div>
                </td>
                <td width="50%" valign="top">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <br />
                    <div align="center" style="padding: 20px;">
                      <font style="font-size:70px;"><?=date('d');?> <?=$thaimonth[date('m') - 1];?> <?=date('Y') + 543;?></font>
                      <br />
                      <br />
                      <font style="font-size:50px;">เวลา <?=date('H:i:s');?> น.</font>
                    </div>
                    <!-- ================================================================================ -->
                    <div class="portlet box green">
                      <div class="portlet-title">
                        <div class="caption">
                          <i class="fa fa-car"></i> ข้อมูลตรวจสภาพรถก่อนนำซ่อม</div>
                        <div class="tools">
                        </div>
                      </div>
                      <div class="portlet-body form">
                        <div class="portlet light bordered">
                          <div class="portlet-body form">
                            <table width="100%"  style="">
                              <tr>
                                <td width="30%" valign="top" style="border:2px solid #32c5d2;padding: 5px;height: 150px;"> </td>
                                <td width="5%"></td>
                                <td width="30%" valign="top" style="border:2px solid #32c5d2;padding: 5px;"> </td>
                                <td width="5%"></td>
                                <td width="30%" valign="top" style="border:2px solid #32c5d2;padding: 5px;"> </td>
                              </tr>
                              <tr>
                                <td style="height: 20px;"></td>
                              </tr>
                              <tr>
                                <td width="30%" valign="top" style="border:2px solid #32c5d2;padding: 5px;height: 150px;"> </td>
                                <td width="5%"></td>
                                <td width="30%" valign="top" style="border:2px solid #32c5d2;padding: 5px;"> </td>
                                <td width="5%"></td>
                                <td width="30%" valign="top" style="border:2px solid #32c5d2;padding: 5px;"> </td>
                              </tr>
                            </table>
                            <span class="caption-subject bold uppercase text-danger">**หากรูปภาพที่แสดงไม่ครบตามรายการสามารถขอดูเพิ่มเติมได้ที่เจ้าหน้าที่ที่บริการท่านอยู่</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- ================================================================================ -->
                    <div class="portlet box green">
                      <div class="portlet-title">
                        <div class="caption">
                          <i class="fa fa-car"></i> บันทึกข้อความ</div>
                        <div class="tools">
                        </div>
                      </div>
                      <div class="portlet-body form">
                        <div class="portlet light bordered">
                          <div class="portlet-body form">
                            <table width="100%"  style="min-height: 90px;">
                              <tr>
                                <td widht="100%" valign="top">
                                  
                                  <?php
                                  if ($comment) {
                                    ?>      
                                    <div class="row">
                                      <div class="col-md-12">
                                        <u><strong>บันทึกข้อความ</strong></u>
                                        <?php
                                        foreach ($comment as $data) {
                                          ?>
                                          <div class="col-md-12" >
                                            <?=$data['d_create'];?> :: 
                                            <?=$data['s_comment'];?>
                                            <br />
                                          </div>
                                        <?php }?>	
                                      </div>
                                    </div>     
                                  <?php }?>
                                </td>
                              </tr>
                            </table>
                           
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              
            </table>                 
            <!-- =========================================================================================== -->
            <div align="center">
              <h4 class="caption-subject bold uppercase text-danger">
                ความเสียหายดังต่อไปนี้ทางอู่จะไม่รับผิดชอบ คือ ความเสียหายนอกเหนือจากงานซ่อม, ความเสียหายของแบตเตอรี่ เครื่องยนต์ แอร์ วิทยุ อุปกรณ์ไฟฟ้าต่าง ๆ ซึ่งไม่เกี่ยวกับการซ่อมในใบเคลมหรือใบเสนอราคา
              </h4>
              <h3 class="caption-subject bold uppercase">
                 ลูกค้ายอมรับเงื่อนไขการนำรถเข้าซ่อม และตรวจสอบความถูกต้องของข้อมูลแล้วจึงแจ้งให้เจ้าหน้าทีสั่งพิมพ์ เมื่อจัดพิมพ์แล้วข้อมูลตรวจสภาพก่อนนำซ่อมจะไม่สามารถแก้ไขได้
              </h3>
            </div>
            <hr  />
            <table  align="center">
              <tr>
                <td  align="center">
                  <img src="status_style/image003.png" style="    height: 110px;"  align="center" />
                </td>
              </tr>
            </table>
            

          </div>



        </div>
        <!-- END CONTENT BODY -->

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
    <script src="../assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <!--<script src="../assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>-->
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
    <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->


    <script src="js/common/notify.js" type="text/javascript"></script>
    <link href="css/notify.css" rel="stylesheet" type="text/css" />
    <!--<script src="js/action/cs_dashboard.js" type="text/javascript"></script>-->



    <script>
      $(document).ready(function () {
//                chart_03();
//                chart_01();
        //unloading();


        setInterval(function () {
          console.log(111)
        }, 30000);
      });
    </script>




  </body>

</html>