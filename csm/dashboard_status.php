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

function getInsuranceDisplay($seq, $db) {
  $strSql = " select s_name_display from tb_insurance_comp where i_ins_comp =" . $seq;
  $_data = $db->Search_Data_FormatJson($strSql);
  return $_data[0]['s_name_display'];
}

function getRowDisplay($val, $col, $res, $tb, $db) {
  $strSql = " select $res from $tb where $col ='" . $val . "'";
  $_data = $db->Search_Data_FormatJson($strSql);
  return $_data[0][$res];
}
if($_GET[date] !=''){
  $date_now = $_GET[date];
}else{
  $date_now = date('Y-m-d');
}
$strSql = " select * from tb_customer_car where d_deliver = '" . $date_now . "' ";
$customer_car = $db->Search_Data_FormatJson($strSql);


///////////// run
/*
$strSql = " select * from tb_customer_car where d_deliver = '0000-00-00' ";
$run_deliver = $db->Search_Data_FormatJson($strSql);
foreach ($run_deliver as $dataR){
  $d_deliver_update = $dataR[d_sendcar];
  if($dataR[d_sendcar] == "0000-00-00"){
    $d_deliver_update = $dataR[d_outbound_confirm];
  }
  $strSql = "";
        $strSql .= "update tb_customer_car ";
        $strSql .= "set  ";
        $strSql .= "d_deliver = '$d_deliver_update' ";
        $strSql .= "where ref_no = '".$dataR[ref_no]."' ";
        $arr = array(
            array("query" => "$strSql")
        );
        $db->insert_for_upadte($arr);
}
//*/
?>
<!DOCTYPE html>
<html lang="en">
  <!-- BEGIN HEAD -->
  <head>
    <meta charset="utf-8" />
    <title><?=$_SESSION[title] ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="<?=$_SESSION[title_content] ?>"    name="description" />
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
          <div class="page-bar" style="display: none;">
            <ul class="page-breadcrumb">

              <li>
                <h3>ระบบแจ้งสถานะงานซ่อม</a> :: ประจำวันที่ <?=$date_now_th; ?></h3>
              </li>
            </ul>

          </div>
          <!-- END PAGE BAR -->

          <!-- END PAGE HEADER-->
          <div class="row" style="margin-left: 0px; margin-right: 0px;">

            <!-- ****************************  -->                            
            <!-- ****************************  --> 
            <?php
            $thaimonth = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
            ?>
            <style>
              .xl128 {
                mso-style-parent: style0;
                color: white;
                font-size: 28.0pt;
                font-weight: 700;
                /*font-family: Tahoma, sans-serif;*/
                mso-font-charset: 0;
                mso-number-format: "\[$-F800\]dddd\\\,\\ mmmm\\ dd\\\,\\ yyyy";
                text-align: center;
                vertical-align: middle;
                background: #002060;
                mso-pattern: black none;
              }
              .xl131 {
                mso-style-parent: style0;
                color: red;
                font-size: 65.0pt;
                font-weight: 700;
                /*font-family: Tahoma, sans-serif;*/
                mso-font-charset: 0;
                mso-number-format: "\[$-F400\]h\:mm\:ss\\ AM\/PM";
                text-align: center;
                vertical-align: middle;
                background: #002060;
                mso-pattern: black none;
              }
              .xl132 {
                mso-style-parent: style0;
                color: white;
                font-size: 28.0pt;
                font-weight: 700;
                /*font-family: Tahoma, sans-serif;*/
                mso-font-charset: 0;
                text-align: center;
                vertical-align: middle;
                background: #002060;
                mso-pattern: black none;
              }
            </style> 
            <table cellpadding="0" cellspacing="0" style="position: fixed;background-color: #ffffff;">
              <tbody>
                <tr>
                  <td width="0" height="0"></td>
                  <td width="489"></td>
                  <td width="713"></td>
                  <td width="3"></td>
                  <td width="156"></td>
                  <td width="8"></td>
                </tr>
                <tr>
                  <td height="23"></td>
                  <td rowspan="5" align="left" valign="top"><img width="489" height="154" src="status_style/image003.png" v:shapes="Picture_x0020_8"></td>
                </tr>
                <tr>
                  <td height="32"></td>
                  <td></td>
                  <td colspan="3" align="left" valign="top"><img width="167" height="32" src="status_style/image004.png" v:shapes="Text_x0020_Box_x0020_2"></td>
                </tr>
                <tr>
                  <td height="6"></td>
                </tr>
                <tr>
                  <td height="26"></td>
                  <td colspan="2"></td>
                  <td align="left" valign="top">
                    <!--[endif]--><!--[if !excel]
                    <img width="156" height="26" src="status_style/image005.png" alt="START" v:shapes="_x0000_s1025" class="shape" v:dpi="96"><!--[endif]--><!--[if !vml]-->
                  </td>
                </tr>
                <tr>
                  <td height="67"></td>
                  <td colspan="3" align="right">
                    <font style="font-size: 50.0pt;">ระบบแจ้งสถานะงานซ่อม</font>
                  </td>
                </tr>
              </tbody>
            </table>
            <table width="100%" style="position: fixed;margin-top: 154px;">
              <tr height="115" style="mso-height-source:userset;height:86.25pt">
                <td colspan="3" class="xl128"><?=date('d', strtotime($date_now)); ?> <?=$thaimonth[date('m', strtotime($date_now)) - 1]; ?> <?=date('Y', strtotime($date_now)); ?></td>
                <td colspan="3"class="xl131" id="time_now" width="33%" ><?=date('H:i:s', strtotime($date_now)); ?></td>
                <td colspan="2" height="115" class="xl132"   style="height:86.25pt;" align="left" valign="top">
                  <?php
                  $cc = 0;
                  foreach ($customer_car as $objArr) {$cc++;}
                  ?>
                  งานส่งมอบวันนี้ <?=$cc;?> คัน
                </td>
              </tr>
            </table>                         
            <!-- ****************************  -->                            
            <!-- ****************************  -->  
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable" style="margin-top: 269px;">
              <thead>
                <tr style="background-color: #4472C4;color:#ffffff;">
                  <th>REF.NO</th>
                  <th>ยี่ห้อ</th>
                  <th>รุ่น</th>
                  <th>ทะเบียน</th>
                  <th>ระดับงาน</th>
                  <th>งานปัจจุบัน</th>
                  <th>คาดการณ์ / กำหนดส่งรถ</th>
                  <th>สถานะ</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //$objCSV = fopen("excel/status.csv", "r");
                //while (($objArr = fgetcsv($objCSV, 1000, ",")) != FALSE) {
                foreach ($customer_car as $objArr) {

                  if ($objArr[i_deliver]) {
                    $chkbox_deliver = ' checked="checked" ';
                  }
                  if ($objArr[d_deliver] == '0000-00-00') {
                    $d_deliver = $util->DateSql2d_dmm_yyyy($objArr[d_sendcar]);
                  } else {
                    $d_deliver = $util->DateSql2d_dmm_yyyy($objArr[d_deliver]);
                  }
                  $t_deliver = $objArr[t_deliver];

                  $i_dmg = getRowDisplay($objArr[i_dmg], 'i_dmg', 's_dmg_th', 'tb_damage', $db);
                  $s_status = getRowDisplay($objArr[s_status], 's_status', 's_detail_th', 'tb_status', $db);
                  ?>
                  <tr>
                    <td><?=$objArr[ref_no]; ?></td>
                    <td><?=$service->getBrand($objArr[s_brand_code]); ?></td>
                    <td><?=$service->getGeneration($objArr[s_gen_code]); ?></td>
                    <td><?=$objArr[s_license]; ?></td>
                    <td><?=$i_dmg; ?></td>
                    <td><?=$s_status; ?></td>
                    <td>
                      <?php 
                    if($objArr[i_deliver] == 0){
                      echo $objArr[t_deliver];
                    }else{
                      echo "แจ้งภายหลัง";
                    }
                    
                    ?>
                    </td>
                    <td>
                      <?php
                      $time = explode(" น.", $objArr[6]);

                      $date_now = $date_now." ".date('H:i:s');
                      //$date_now = date('Y-m-d H:i:s', strtotime($date_now));
                      $date_row = $objArr[d_deliver] . " " . $objArr[t_deliver] . ":00";

                      if($objArr[i_deliver] == 0){

 
                        if ($date_now > $date_row) {
                          $timestamp_now = strtotime($date_now);
                          $timestamp_row = strtotime($date_row);
                          $total = $timestamp_row - $timestamp_now;
                          if ($total < 0) {
                            $aa = explode("-", $total);
                            $total = $aa[1];
                          }
                          $total;
                          $mins = floor($total / 60);
                          $hr = floor($mins / 60);
                          $mins = $mins % 60;
                          $txt_hr = "";
                          $txt_min = "";
                          if ($hr > 0) {
                            $txt_hr = $hr . " ชม. ";
                          }
                          if ($mins) {
                            $txt_min = $mins . " นาที ";
                          }
                          if($objArr[s_status] == 'R12'){
                            ?>
                          <font style="color: #0000FF;font-weight: bold;">เสร็จสิ้น (ลูกค้ามารับรถแล้ว)</font>
                          <?php
                          }else{
                          ?>
                          <font style="color: #ff0000;font-weight: bold;">ล่าช้า <?=$txt_hr; ?> <?=$txt_min; ?></font>
                          <?php
                          }
                        } else {
                          
                          if($objArr[s_status] == 'R12'){
                            ?>
                          <font style="color: #0000FF;font-weight: bold;">เสร็จสิ้น (ลูกค้ามารับรถแล้ว)</font>
                          <?php
                          }else{
                          ?>
                          <font style="color: #38c566;font-weight: bold;">ปกติ</font>
                          <?php
                          }
                          ?>
                          
                          <?php
                        }
                      } else {
                        ?>
                        รอยืนยัน
                        <?php
                      }
                      ?>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table> 
            <script>
              function checkTime(i) {
                if (i < 10) {
                  i = "0" + i;
                }
                return i;
              }

              function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                // add a zero in front of numbers<10
                h = checkTime(h);
                m = checkTime(m);
                s = checkTime(s);
                //$('#time_now').html(h + ":" + m + ":" + s);
                document.getElementById('time_now').innerHTML = h + ":" + m + ":" + s;

                t = setTimeout(function () {
                  startTime()
                }, 500);
              }
              startTime();

              setInterval(function () {
                location.reload();
              }, 300000);
            </script>                        
            <!-- ****************************  -->                            
            <!-- ****************************  -->                            
            <!-- ****************************  -->                            


          </div>



        </div>
        <!-- END CONTENT BODY -->

        <!-- END CONTENT -->

      </div>
      <!-- END CONTAINER -->








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