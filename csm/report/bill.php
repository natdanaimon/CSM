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
$strSql .= " FROM tb_report_bill   WHERE id = '".$_GET[id]."' ";
$data = $db->Search_Data_FormatJson($strSql);
$s_code_by = $data[0][s_code_by];
$s_code_buy = $data[0][s_code_buy];
$no = $data[0][id];
$d_create = date('d/m/Y',strtotime($data[0][d_create]));
$strSql = " select * ";
$strSql .= " FROM tb_report_bill_list   WHERE i_report_bill = '".$_GET[id]."' ";
$dataList = $db->Search_Data_FormatJson($strSql);

$strSql = " select * ";
$strSql .= " FROM tb_report_invoice   WHERE id = '".$dataList[0][i_invoice]."' ";
$i_invoice = $db->Search_Data_FormatJson($strSql);
$ref_no = $i_invoice[0][ref_no];
//echo $ref_no;
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " car.* ";
$strSql .= " ,cus.s_firstname , cus.s_lastname , cus.s_address ,cus.s_phone_1 , cus.s_phone_2";
$strSql .= " ,ins.s_comp_th,ins.s_address as ins_address  ,ins.s_tax_no as ins_tax_no";
$strSql .= " ,brand.s_brand_name ";
$strSql .= " ,gen.s_gen_name ";
$strSql .= " FROM tb_customer_car car ";
$strSql .= " LEFT JOIN tb_customer cus ON car.i_customer = cus.i_customer ";
$strSql .= " LEFT JOIN tb_insurance_comp ins ON car.i_ins_comp = ins.i_ins_comp ";
$strSql .= " LEFT JOIN tb_car_brand brand ON car.s_brand_code = brand.s_brand_code ";
$strSql .= " LEFT JOIN tb_car_generation gen ON car.s_gen_code = gen.s_gen_code ";
$strSql .= " WHERE car.ref_no =".$ref_no;
$_data = $db->Search_Data_FormatJson($strSql);
//echo $data[0][ref_no];
$s_name = ($i_invoice[0][ref_no] != '') ? $_data[0][s_comp_th]."<br />เลขประจำตัวผู้เสียภาษีอากร ".$_data[0][ins_tax_no] : $data[0][s_name]."<br />เลขประจำตัวผู้เสียภาษีอากร ".$data[0][s_tax_no];
$s_address = ($i_invoice[0][ref_no] != '') ? $_data[0][ins_address] : $data[0][s_address];

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
    <table width="100%">
      <tr>
        <td width="110">
          <img src="../images/logo/logo.jpg" style="width: 100px;"/>
        </td>
        <td  align="left" valign="top">
          <table style="border:0px solid #000; " cellpadding="0" width="100%" >
            <tr>
              <td valign="top"> 
                <strong style="font-size: 22px;cursor: pointer;" onclick="javascript:window.print();">
                  บริษัท รุ่งทรัพย์ ออโตโมบิล รีแพร์ เซ็นเตอร์ จำกัด <br />
                </strong>
                <font style="font-size: 20px;">
                23/326 หมู่ที่2 ซอยสุขุมวิท35 อัศวนนท์ ถนนสุขุมวิท <br />
                ตำบลบางเมือง อำเภอเมืองฯ จังหวัดสมุทรปราการ 10270 <br />
                โทร. +662 388 0700, +662 388 1821  FAX.+662 702 5185
                </font>
              </td>
            </tr>
          </table>
        </td>
        <td width="200" align="center">
          <table style="border:2px solid #000;" cellpadding="2" width="100%">
            <tr>
              <td align="center">
                <font style="font-size: 40px;">ใบวางบิล
                </font>
              </td>
            </tr>
          </table>
          <font style="font-size: 18px;">สำนักงานใหญ่</font>
          <div style="height: 5px;"></div>
          <div  style="border:1px solid #ccc;padding:5px;">
            วันที่: <?=$d_create;?>เลขที่: <?=$no;?>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">

        </td>
        <td>

        </td>
      </tr>
    </table>
    <div align="center"></div>
    <table width="100%" celpadding="0" cellspacing="0" border="0">
      <tr>
        <td width="60"></td>
        <td width=""></td>
        <td width="150"></td>
        <td width="150"></td>
        <td width="150"></td>
        <td width="150"></td>
      </tr>
      <tr>
        <td colspan="3" rowspan="2" style="border-bottom:1px solid #000;border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;" width="110" align="center">
          <strong style="font-size: 20px;"><?=$s_name;?></strong>
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;padding: 5px;"   align="center">
          <strong style="font-size: 16px;">
            ผู้ออกเอกสาร
          </strong>
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;padding: 5px;"   align="center">
          <strong style="font-size: 16px;">
            รหัสผู้ซื้อ 
          </strong>
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            เลขที่ 
          </strong>

        </td>
      </tr>
      <tr>
        <td align="center" style="border:1px solid #000;border-left:0px solid #000;padding: 5px;">
          <strong style="font-size: 16px;">
            <?=$s_code_by;?>
          </strong>
        </td>
        <td align="center" style="border:1px solid #000;border-left:0px solid #000;padding: 5px;">
          <strong style="font-size: 16px;">
            <?=$s_code_buy;?>
          </strong>
        </td>
        <td align="center" style="border:1px solid #000;border-left:0px solid #000;" align="center">
          <strong style="font-size: 16px;">
            <?=$no;?>
          </strong>
        </td>
      </tr>

      <tr>
        <td colspan="6" align="letf" style="height: 5px;">
          <strong style="font-size: 16px;">
          </strong>
        </td>
      </tr>
      <tr>
        <td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"  align="center">
          <strong style="font-size: 16px;">
            ลำดับที่
          </strong>
        </td>
        <td  style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            เลขที่เคลม
          </strong>	
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            เลขที่กรมมธรรม์
          </strong>
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            ราคา
          </strong>
        </td>
        <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            หมายเหตุ
          </strong>
        </td>
      </tr>

      <?php
      $i = 1;
      foreach ($dataList as $dataL) {
        ?>
        <tr>
          <td style="border-top:0px solid #000;border-left:1px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"  align="center">
            <?=$i;?>
          </td>
          <td  style="border-top:0px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"   align="left">
            <?=$dataL[s_no_claim];?>
          </td>
          <td style="border-top:0px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"   align="left">
            <?=$dataL[s_ins];?>
          </td>
          <td style="border-top:0px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;padding-right:10px;"   align="right">
            <?=number_format($i_invoice[0][i_amount],2);?>
            <?php
            $total_cost += $i_invoice[0][i_amount];
            ?>
          </td>
          <td colspan="2" style="border-top:0px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"   align="left">
            <?=$dataL[s_remark];?>
          </td>
        </tr>
        <?php
        $i++;
      }
      ?>
      <?php
      $total_line = 16 - $i;
      for ($i = 0; $i <= $total_line; $i++) {
        ?>
        <tr style="height: 28px;">
          <td style="border-top:0px solid #000;border-left:1px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"  align="center">

          </td>
          <td  style="border-top:0px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"   align="left">

          </td>
          <td style="border-top:0px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"   align="left">

          </td>
          <td style="border-top:0px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"   align="left">

          </td>
          <td colspan="2" style="border-top:0px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;"   align="left">

          </td>
        </tr>
      <?php }?>
      <tr>
        <td style="border-right:1px solid #000;border-left:1px solid #000;border-bottom :1px solid #000;padding: 5px;" align="center" valign="top">
          <strong style="font-size: 16px;" >

          </strong>
        </td>
        <td  style="border-right:1px solid #000;border-left:0px solid #000;border-bottom:1px solid #000;padding: 5px;" valign="top">

        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-bottom:1px solid #000;padding: 5px;" align="right" valign="top">

        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-bottom:1px solid #000;padding: 5px;" align="right" valign="top">

        </td>
        <td colspan="2"s style="border-right:1px solid #000;border-left:0px solid #000;border-bottom:1px solid #000;padding: 5px;" align="right" valign="top">

        </td>
      </tr>
      <tr>
        <td rowspan="2" colspan="3" align="right" style="padding : 5px;border-right:1px solid #000;">
          จำนวนเงิน
          <br />
          <div style="border:0px solid #000;padding:5px;">
            <?php
            //$total_vat = $total_cost * 7 / 100;
            //$total_cost += $total_vat;
            ?>
            <?=$util->bahtText($total_cost);?>
          </div>
        </td>
        <td rowspan="2" align="right" style="border-right:1px solid #000;border-bottom:1px solid #000;padding-right:10px;">
          <?=number_format($total_cost,2);?>
        </td>
        <td rowspan="2" colspan="2" align="left" style="border-left:0px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">
          บาท
        </td>
      </tr>


      <tr>
        <td colspan="6" style="height: 10px;"></td>
      </tr>
      <tr>
        <td colspan="6" style="height: 10px;"></td>
      </tr>
      <tr>
        <td colspan="2" style="padding : 0px;border:2px solid #000;">
          <table width="100%" cellpadding="5" cellspacing="0" border="0">
            <tr>
              <td width="80" align="left">วันที่วางบิล</td>
              <td width="100" align="left"  style="border-bottom: 1px solid #000;"></td>
            </tr>
            <tr>
              <td  align="left">วันที่รับวางบิล</td>
              <td style="border-bottom: 1px solid #000;"></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="3" style="border-bottom: 2px solid #000;"></td>
            </tr>
            <tr>
              <td colspan="3"  align="center">วำหนดวันชำระเงิน</td>
            </tr>
            <tr>
              <td colspan="3"  align="center">
                <div style="border-bottom: 1px solid #000;width: 250px;height: 20px;"></div>
              </td>
            </tr>
          </table>
        </td>
        <td valign="top" style="border: 2px solid #000;border-left: 0px solid #000;padding: 5px;">
          <table width="100%" cellpadding="5" cellspacing="0" border="0">
            <tr>
              <td colspan="2" align="center">ผู้วางรับบิล</td>
            </tr>
            <tr>
              <td colspan="2" style="border-bottom: 1px solid #000;"></td>
            </tr>
            <tr>
              <td colspan="2"  align="center"></td>
            </tr>
            <tr>
              <td colspan="2"  align="center">
                <div style="border-bottom: 1px solid #000;width: 150px;height: 20px;"></div>
              </td>
            </tr>
            <tr>
              <td colspan="2"  align="left">วันที่</td>
            </tr>
          </table>
        </td>
        <td valign="top"  style="padding : 0px;border:2px solid #000;border-left: 0px solid #000;">
          <table width="100%" cellpadding="5" cellspacing="0" border="0">
            <tr>
              <td colspan="2" align="center" >CODE.</td>
            </tr>
            <tr>
              <td colspan="2" style="border-bottom: 0px solid #000;"></td>
            </tr>
          </table>
        </td>
        <td colspan="2" style="padding : 0px;border:2px solid #000;border-left: 0px solid #000;">
          <table width="100%" cellpadding="5" cellspacing="0" border="0">
            <tr>
              <td colspan="2" align="center">ผู้วางบิล</td>
            </tr>
            <tr>
              <td colspan="2" style="border-bottom: 1px solid #000;"></td>
            </tr>
            <tr>
              <td colspan="2"  align="center"></td>
            </tr>
            <tr>
              <td colspan="2"  align="center">
                <div style="border-bottom: 1px solid #000;width: 150px;height: 20px;"></div>
              </td>
            </tr>
            <tr>
              <td colspan="2"  align="left">วันที่</td>
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