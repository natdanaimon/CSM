<?php
@session_start();
include '../common/Permission.php';
include '../common/PermissionADM.php';
include '../common/FunctionCheckActive.php';
include '../common/ConnectDB.php';
include '../common/Utility.php';
$util = new Utility();

$db = new ConnectDB();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " car.* ";
$strSql .= " ,cus.s_firstname , cus.s_lastname , cus.s_address ,cus.s_phone_1 , cus.s_phone_2";
$strSql .= " ,ins.s_name_display ";
$strSql .= " ,brand.s_brand_name ";
$strSql .= " ,gen.s_gen_name ";
$strSql .= " ,pay.s_detail pay_detail ";
$strSql .= " ,dmg.s_dmg_th ";
$strSql .= " ,status.s_detail_th status_name ";
$strSql .= " FROM tb_customer_car car ";
$strSql .= " LEFT JOIN tb_customer cus ON car.i_customer = cus.i_customer ";
$strSql .= " LEFT JOIN tb_insurance_comp ins ON car.i_ins_comp = ins.i_ins_comp ";
$strSql .= " LEFT JOIN tb_car_brand brand ON car.s_brand_code = brand.s_brand_code ";
$strSql .= " LEFT JOIN tb_car_generation gen ON car.s_gen_code = gen.s_gen_code ";
$strSql .= " LEFT JOIN tb_pay pay ON car.s_pay_type = pay.s_pay_type ";
$strSql .= " LEFT JOIN tb_damage dmg ON car.i_dmg = dmg.i_dmg ";
$strSql .= " LEFT JOIN tb_status status ON car.s_status = status.s_status ";
$strSql .= " WHERE car.i_cust_car =" . $_GET[id];
$_data = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " list.i_repair_item,list.s_remark ";
$strSql .= " ,item.s_repair_name ";
$strSql .= " FROM tb_list_repair list ";
$strSql .= " LEFT JOIN tb_repair_item item ON list.i_repair_item = item.i_repair_item ";
$strSql .= " WHERE list.ref_no =" . $_data[0][ref_no];
$list_repair = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " *";
$strSql .= " FROM tb_list_repair_other list ";
$strSql .= " WHERE list.ref_no =" . $_data[0][ref_no];
$list_repair_other = $db->Search_Data_FormatJson($strSql);
$db->close_conn();


include('../barcode/src/BarcodeGenerator.php');
include('../barcode/src/BarcodeGeneratorPNG.php');
include('../barcode/src/BarcodeGeneratorSVG.php');
include('../barcode/src/BarcodeGeneratorJPG.php');
include('../barcode/src/BarcodeGeneratorHTML.php');


//$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
//$barcode =  $generator->getBarcode($_data[0][ref_no], $generator::TYPE_CODE_128);

$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
$barcode = '<img  src="data:image/png;base64,' . base64_encode($generator->getBarcode($_data[0][ref_no], $generator::TYPE_CODE_128)) . '">';
$barcode1 = '<img height="53"  src="data:image/png;base64,' . base64_encode($generator->getBarcode($_data[0][ref_no], $generator::TYPE_CODE_128)) . '">';
$title_name = date('ymdHis') . '_' . $_GET[id] . '_receive';



$title_name = date('ymdHis') . '_' . $_GET[id] . '_repair';

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
  <!-- BEGIN HEAD -->
  <head>
    <meta charset="utf-8" />
    <title><?= $_SESSION[title] ?> <?= $i_queue; ?> </title>
    <!-- END SELECT 2 SCRIPTS -->
    <link rel="shortcut icon" href="../../favicon.ico" />
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/layouts/layout/css/themes/darkblue.min.cssaa" rel="stylesheet" type="text/css" id="style_color" />
    <link href="../../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <style>
      .font_18 tr td{
        font-size: 25px;
      }
      .font_23 {
        font-size: 23px;
      }
      .border-td {
        border-top:1px solid #000; 
        border-left:1px solid #000; 
        border-bottom:1px solid #000; 
        border-right:1px solid #000; 
        padding : 5px;
      }
    </style>
  </head>
  <!-- END HEAD -->
  <body>
    <table width="100%">
      <tr>
        <td width="50%" align="center">
          <table style="border:1px solid #000;" cellpadding="5" width="100%" >
            <tr>
              <td height="80" align="center" onclick="javascript:window.print();" style="cursor: pointer;"> 
                <strong style="font-size: 60px;"><?php echo $_data[0][s_license]; ?></strong>
              </td>
            </tr>
          </table>
        </td>
        <td width="50%" align="center">
          <table style="border:1px solid #000;" cellpadding="5" width="100%">
            <tr>
              <td height="80" align="center">
                <?= $barcode1; ?>
                <br />
                <strong style="font-size: 30px;"><?php echo $_data[0][ref_no]; ?></strong>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" height="5"></td>
      </tr>
      <tr>
        <td align="right">
          <table class="font_18">
            <tr>
              <td align="right"><strong class="font_23" >ประเภท</strong> : </td>
              <td class="border-td font_23"><?php echo $_data[0][pay_detail]; ?></td>
            </tr>
            <tr>
              <td align="right"><strong class="font_23">เงินสด/ประกันภัย</strong> :  </td>
              <td class="border-td font_23"><?php echo $_data[0][s_name_display]; ?></td>
            </tr>
            <tr>
              <td align="right"><strong class="font_23">ความเสียหาย</strong> : </td>
              <td class="border-td font_23"><?php echo $_data[0][s_dmg_th]; ?></td>
            </tr>
          </table>
        </td>
        <td  align="right">
          <table class="font_18">
            <tr>
              <td align="right"><strong class="font_23">ยี่ห้อ</strong>  : </td>
              <td class="border-td font_23"><?php echo $_data[0][s_brand_name]; ?> </td>
            </tr>
            <tr>
              <td align="right"><strong class="font_23">รุ่น</strong>  :  </td>
              <td class="border-td font_23"><?php echo $_data[0][s_gen_name]; ?></td>
            </tr>
            <tr>
              <td align="right"><strong class="font_23">สถานะ</strong>  : </td>
              <td class="border-td font_23"><?php echo $_data[0][status_name]; ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" height="5"></td>
      </tr>
      <tr>
        <td colspan="2"><strong style="font-size: 28px;">รายการซ่อม</strong></td>
      </tr>
      <tr>
        <td colspan="2" height="600" valign="top" style="border: 1px solid #000;">
          <table width="100%">
            <tr>
              <td valign="top" height="540">
                <table cellpadding="3" class="font_18" width="100%" >
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
                      <td width="50%"><?= $data[s_repair_name]; ?> <?= $data[s_remark]; ?></td>
                      <?php
                      $count++;
                      if (($count % 2) == 0) {
                        ?>
                      </tr>
                      <?php
                    }
                    ?>
                  <?php } ?>
                  <?php 
                  for($i=1;$i <=13;$i++){
                    $s_txt_x = 's_txt_'.$i;
                    $s_txt_ok = $list_repair_other[0][$s_txt_x];
                    if($s_txt_ok != ''){
                       
                    if ($count == 0) {
                      ?>
                      <tr>
                        <?php
                      }
                      ?>
                      <td width="50%"><?= $s_txt_ok; ?></td>
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
            <tr>
              <td align="right">
                  <table width="100%">
                    <tr>
                      <td></td>
                      <td align="center"  width="300">
                        <br />
                        <?= $_SESSION["full_name"] ?>
                        <br />
                        <strong>เจ้าหน้าที่ออกใบสั่งซ่อม</strong>
                      </td>
                    </tr>
                  </table>
              </td>
            </tr>
          </table>


        </td>
      </tr>
      <tr style="display: none;">
        <td style="border: 1px solid #000;">
          <table>
            <tr>
              <td>งานเคาะ : </td>
              <td>วันที่กำหนดเสร็จ</td>
            </tr>
            <tr>
              <td>งานโป๊ว : </td>
              <td>วันที่กำหนดเสร็จ</td>
            </tr>
            <tr>
              <td>งานพ่น : </td>
              <td>วันที่กำหนดเสร็จ</td>
            </tr>
            <tr>
              <td>ปก. - ขัด : </td>
              <td>วันที่กำหนดเสร็จ</td>
            </tr>
          </table>
        </td>
        <td style="border: 1px solid #000;">
          <table  width="100%">
            <tr>
              <td width="33%">ช่าง </td>
              <td width="33%">เริ่ม</td>
              <td>เสร็จ</td>
            </tr>
            <tr>
              <td width="33%">ช่าง </td>
              <td width="33%">เริ่ม</td>
              <td>เสร็จ</td>
            </tr>
            <tr>
              <td width="33%">ช่าง </td>
              <td width="33%">เริ่ม</td>
              <td>เสร็จ</td>
            </tr>
            <tr>
              <td width="33%">ช่าง </td>
              <td width="33%">เริ่ม</td>
              <td>เสร็จ</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="70%" style="padding:3px; border-bottom: 1px solid #000;border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">รายการสั่งสี/ชิ้นส่วนเทียบสี</td>
              <td rowspan="2" style="padding:3px; border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">
                <strong style="font-size: 50px;"><?= $barcode; ?></strong>
                <br />
                ref.no : <?php echo $_data[0][ref_no]; ?>
              </td>
            </tr>
            <tr>
              <td align="center" style="padding:3px; border-left: 1px solid #000;border-right: 1px solid #000;"><strong style="font-size: 50px;"><?php echo $_data[0][s_license]; ?></strong></td>
            </tr>
            <tr>
              <td colspan="2" style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">
                <table width="100%">
                  <tr>
                    <td width="50">ประเภทสี</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                    <td width="20" align="right">สี</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                    <td width="30" align="right">รหัสสี</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">
                <table width="100%">
                  <tr>
                    <td width="50">วันที่ใช้</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                    <td width="40" align="right">เวลา</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="30" colspan="2" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">
                <table width="100%">
                  <tr>
                    <td width="150">ปริมาณสีที่ใช้/ปริมาณที่สั่ง</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                    <td width="50" align="right">COTS.</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="70%" style="padding:3px; border-bottom: 1px solid #000;border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">รายการสั่งสี/กระป๋องสี</td>
              <td rowspan="2" style="padding:3px; border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">
                <strong style="font-size: 50px;"><?= $barcode; ?></strong>
                <br />
                ref.no : <?php echo $_data[0][ref_no]; ?>
              </td>
            </tr>
            <tr>
              <td align="center" style="padding:3px; border-left: 1px solid #000;border-right: 1px solid #000;"><strong style="font-size: 50px;"><?php echo $_data[0][s_license]; ?></strong></td>
            </tr>
            <tr>
              <td colspan="2" style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">
                <table width="100%">
                  <tr>
                    <td width="50">ประเภทสี</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                    <td width="20" align="right">สี</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                    <td width="30" align="right">รหัสสี</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">
                <table width="100%">
                  <tr>
                    <td width="50">วันที่ใช้</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                    <td width="40" align="right">เวลา</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="30" colspan="2" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">
                <table width="100%">
                  <tr>
                    <td width="150">ปริมาณสีที่ใช้/ปริมาณที่สั่ง</td>
                    <td style="border-bottom: 1px solid #000;"></td>
                    <td width="50" align="right">COTS.</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
<?php
/*
  $output = ob_get_contents();
  ob_end_clean();
  require_once './../vendorPdf/autoload.php';
  $mpdf = new \Mpdf\Mpdf([
  'mode' => 'utf-8',
  //'default_font_size' => 15,
  'default_font' => 'thsarabunnew'
  ]);
  $mpdf->SetWatermarkText('');
  $mpdf->showWatermarkText = false;
  //$mpdf->showImageErrors = true;
  $mpdf->WriteHTML($output);
  $mpdf->Output($title_name.'.pdf','I');

 */
?>