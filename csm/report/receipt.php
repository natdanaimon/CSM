<?php
@session_start();
include './../common/Permission.php';
include './../common/PermissionADM.php';
include './../common/FunctionCheckActive.php';
include './../common/ConnectDB.php';
include './../common/Utility.php';
$util = new Utility();

$db = new ConnectDB();
$strSql = " select * ";
$strSql .= " FROM tb_report_receipt   WHERE id = '".$_GET[id]."' ";
$data = $db->Search_Data_FormatJson($strSql);
$ref_no = $data[0][ref_no];
$no = $data[0][id];
$d_create = date('d/m/Y',strtotime($data[0][d_create]));
$strSql = " select * ";
$strSql .= " FROM tb_report_receipt_list   WHERE i_invoice_report = '".$_GET[id]."' ";
$dataList = $db->Search_Data_FormatJson($strSql);
$strSql = " select * ";
$strSql .= " FROM tb_user   WHERE s_user = '".$_SESSION[username]."' ";
$adminNow = $db->Search_Data_FormatJson($strSql);
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " car.* ";
$strSql .= " ,cus.s_firstname , cus.s_lastname , cus.s_address ,cus.s_phone_1 , cus.s_phone_2";
$strSql .= " ,ins.s_comp_th,ins.s_address as ins_address  ,ins.s_tax_no as ins_tax_no,ins.s_code,ins.s_name_display";
$strSql .= " ,brand.s_brand_name ";
$strSql .= " ,gen.s_gen_name ";
$strSql .= " FROM tb_customer_car car ";
$strSql .= " LEFT JOIN tb_customer cus ON car.i_customer = cus.i_customer ";
$strSql .= " LEFT JOIN tb_insurance_comp ins ON car.i_ins_comp = ins.i_ins_comp ";
$strSql .= " LEFT JOIN tb_car_brand brand ON car.s_brand_code = brand.s_brand_code ";
$strSql .= " LEFT JOIN tb_car_generation gen ON car.s_gen_code = gen.s_gen_code ";
$strSql .= " WHERE car.ref_no =".$ref_no;
$_data = $db->Search_Data_FormatJson($strSql);

$s_name = ($data[0][ref_no] != '') ? $_data[0][s_comp_th]."<br />เลขประจำตัวผู้เสียภาษีอากร ".$_data[0][ins_tax_no] : $data[0][s_name]."<br />เลขประจำตัวผู้เสียภาษีอากร ".$data[0][s_tax_no];
$s_address = ($data[0][ref_no] != '') ? $_data[0][ins_address] : $data[0][s_address];
$s_code = ($data[0][ref_no] != '') ? $_data[0][s_code] : '';

if($data[0][ref_no] != ''){
  $data[0][s_name] = $_data[0][s_firstname]." ".$_data[0][s_lastname];
  $data[0][s_license] = $_data[0][s_license];
  $data[0][s_address] = $_data[0][s_address];
  $data[0][s_brand] = $_data[0][s_brand_name]."/".$_data[0][s_gen_name];
  $data[0][s_phone] = $_data[0][s_phone_1];
  $data[0][s_ins] = $_data[0][s_name_display];
}

$total_cost = 0;



ob_start();
?>
<!DOCTYPE html>
<html lang="en">
  <!-- BEGIN HEAD -->
  <head>
    <meta charset="utf-8" />
    <title><?=$_SESSION[title]?> <?=$i_queue;?> </title>
    <!-- END SELECT 2 SCRIPTS -->
    <link rel="shortcut icon" href="favicon.ico" /> 
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link rel="shortcut icon" href="../../favicon.ico" />
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/layouts/layout/css/themes/darkblue.min.cssaa" rel="stylesheet" type="text/css" id="style_color" />
    <link href="../../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
  </head>
  <!-- END HEAD -->
  <body>
    <?php
    for ($a = 0; $a <= 1; $a++) {
      ?>
      <table width="100%" celpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="5" style="border-top:0px solid #000;border-left:0px solid #000;border-right:0px solid #000;" align="left">
            <strong style="font-size: 16px;">
              <?php
              if ($data[0][ref_no] == '') {
                echo "SERVICE ASSISTANCE";
              }
              else {
                echo "ref.NO ".$data[0][ref_no]."/".$data[0][s_license];
              }
              ?>
            </strong>
          </td>
        </tr>
        <tr>
          <td colspan="2" rowspan="2" style="border:1px solid #000;border-right:0px solid #000;" align="center">
            <strong style="font-size: 30px;cursor: pointer;" onclick="javascript:print();" >
              ใบเสร็จรับเงิน
            </strong>
          </td>
          <td  rowspan="2"  style="border-bottom:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;padding: 5px;">
            <font style="font-size: 30px;">
            <?php
            if ($a == 1) {
              ?>
              สำเนา
              <?php
            }
            else {
              ?>
              ตันฉบับ
            <?php }?>
            </font>
          </td>
          <td style="border-top:1px solid #000;border-bottom:0px solid #000;padding: 2px;">
            เลขที่
          </td>
          <td style="border-right:1px solid #000;border-top:1px solid #000;padding: 2px;" align="right">
            REC<?=$data[0][id];?>
          </td>
        </tr>
        <tr>
          <td style="border-top:0px solid #000;border-bottom:1px solid #000;padding: 2px;">
            วันที่
          </td>
          <td style="border-right:1px solid #000;border-bottom:1px solid #000;padding: 2px;" align="right">
            REC<?=$data[0][id];?>
          </td>
        </tr>
        <tr>
          <td style="border-left: 1px solid #000;padding: 2px;">ชื่อลูกค้า:</td>
          <td><?=$data[0][s_name];?></td>
          <td>ยี่ห้อ/รุ่น:</td>
          <td colspan="2"  style="border-right: 1px solid #000;padding: 2px;"><?=$data[0][s_brand];?></td>
        </tr>
        <tr>
          <td style="border-left: 1px solid #000;padding: 2px;">ที่อยู่:</td>
          <td><?=$data[0][s_address];?></td>
          <td>ทะเบียน:</td>
          <td colspan="2"  style="border-right: 1px solid #000;padding: 2px;"><?=$data[0][s_license];?></td>
        </tr>
        <tr>
          <td style="border-left: 1px solid #000;border-bottom: 1px solid #000;padding: 2px;">เบอร์โทร:	</td>
          <td style="border-bottom: 1px solid #000;padding: 2px;"><?=$data[0][s_phone];?></td>
          <td style="border-bottom: 1px solid #000;padding: 2px;">ประกันภัย:</td>
          <td colspan="2"  style="border-right: 1px solid #000;border-bottom: 1px solid #000;padding: 2px;"><?=$data[0][s_ins];?></td>
        </tr>

        <tr>
          <td colspan="5" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 2px;">
            <table width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="15">ที่</td>
                <td>รายการ</td>
                <td width="120"  align="right" style="padding-right: 5px;">จำนวน</td>
                <td width="120"  align="right" style="padding-right: 5px;">ราคา</td>
                <td width="120"  align="right" style="padding-right: 5px;">รวมเงิน</td>
              </tr>

              <?php
              $ii = 1;
              $i_sum_total = 0;
              foreach ($dataList as $dataL) {
                $i_total = $dataL[s_list_amount] * $dataL[s_list_price];
                $i_sum_total += $i_total;
                if ($dataL[s_list_amount] > 0 and $dataL[s_list_name] != '') {
                  $i_i = $ii;
                  $s_list_name = $dataL[s_list_name];
                  $s_list_amount = number_format($dataL[s_list_amount],2);
                  $s_list_price = number_format($dataL[s_list_price],2);
                  $s_total = number_format($i_total,2);
                }
                else {
                  $i_i = "";
                  $s_list_name = "";
                  $s_list_amount = "";
                  $s_list_price = "";
                  $s_total = "";
                }
                ?>
                <tr style="height: 20px;">
                  <td><?=$i_i;?></td>
                  <td><?=$s_list_name;?></td>
                  <td style="padding-right: 5px;" align="right"><?=$s_list_amount;?></td>
                  <td style="padding-right: 5px;" align="right"><?=$s_list_price;?></td>
                  <td style="padding-right: 5px;" align="right"><?=$s_total;?></td>
                </tr>
                <?php
                $ii++;
              }
              ?>

            </table>
          </td>
        </tr>
        <?php
            if($data[0][i_discount] > 0){
            $i_total_discount = ($i_sum_total*$data[0][i_discount]) / 100;
              $s_discount = $data[0][i_discount]." %";
              $i_txt_discount = number_format($i_total_discount,2);
             } 
             $i_last_total = $i_sum_total-$i_total_discount;
             ?>
        <tr>
          <td style="border-top: 0px solid #000;" colspan="3" rowspan="3" >
            (<?=$util->bahtText($i_last_total);?>)
            <div align="center" >ได้รับสินค้าหรือบริการครบถ้วนสมบูรณ์ดีแล้ว</div>
            <div style="height: 30px;"></div>
            <table width="100%">
              <tr>
                <td width="50%"  align="center">
                  <div style="width: 70%;border-bottom: 1px dashed #000;"></div>
                </td>
                <td width="50%" align="center">
                  <div style="width: 70%;border-bottom: 1px dashed #000;"></div>
                </td>
              </tr>
              <tr>
                <td align="center">ผู้รับเงิน</td>
                <td align="center">จ่ายเงิน</td>
              </tr>
            </table>
          </td>
          <td style="border-top: 0px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;padding-right: 5px;" align="right">รวมเป็นเงิน</td>
          <td style="border-top: 0px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;padding-right: 5px;" align="right">
            <?=number_format($i_sum_total);?>
          </td>
        </tr>
        <tr>
          <td align="right" style="border-left: 1px solid #000;border-right: 1px solid #000;padding-right: 5px;">ส่วนลด <?=$s_discount;?></td>
          <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;padding-right: 5px;">
            <?=$i_txt_discount;?>
          </td>
        </tr>
        <tr>
          <td align="right" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;padding-right: 5px;">รวมทั้งสิ้น</td>
          <td align="right" style="border-bottom: 1px solid #000;border-right: 1px solid #000;padding-right: 5px;">
            <?=number_format($i_last_total,2);?>
          </td>
        </tr>
        <tr>
          <td colspan="4" style="border-right:1px solid #000;"></td>
          <td style="height: 2px;border:1px solid #000;border-top:0px;border-left:0px;"></td>
        </tr>
      </table>
      <?php
      if ($a == 0) {
        ?>
        <hr style="border:2px dashed #ccc;" />
        <div style="height: 50px;"></div>
      <?php }?>
    <?php }?>

  </body>
</html>
<?php
/*
  $output = ob_get_contents();
  ob_end_clean();
  require_once '../vendorPdf/autoload.php';

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

  // */
?>