<?php
@session_start();
include './../common/Permission.php';
include './../common/PermissionADM.php';
include './../common/FunctionCheckActive.php';
include './../common/ConnectDB.php';
include './../common/Utility.php';
$util = new Utility();

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
$strSql .= " WHERE car.i_cust_car =" . $_GET[id];
$_data = $db->Search_Data_FormatJson($strSql);





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
$strSql .= " list.i_repair_item,list.s_remark ";
$strSql .= " ,item.s_repair_name ";
$strSql .= " FROM tb_check_repair list ";
$strSql .= " LEFT JOIN tb_repair_item item ON list.i_repair_item = item.i_repair_item ";
$strSql .= " WHERE list.ref_no =" . $_data[0][ref_no];
$check_repair = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " *";
$strSql .= " FROM tb_check_repair_other list ";
$strSql .= " WHERE list.ref_no =" . $_data[0][ref_no];
$check_repair_other = $db->Search_Data_FormatJson($strSql);
$db->close_conn();


$db->conn();
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " *";
$strSql .= " FROM tb_list_repair_other list ";
$strSql .= " WHERE list.ref_no =" . $_data[0][ref_no];
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
$strSql .= " FROM tb_report_receive   WHERE ref_id = '" . $_GET[id] . "' ";
$receive = $db->Search_Data_FormatJson($strSql);

$s_no = $receive[0][s_no];
$s_color = $receive[0][s_color];
$s_fuel = $receive[0][s_fuel];
$s_distance = $receive[0][s_distance];
$s_remark = $receive[0][s_remark];

$total_cost = 51231;

include('../barcode/src/BarcodeGenerator.php');
include('../barcode/src/BarcodeGeneratorPNG.php');
include('../barcode/src/BarcodeGeneratorSVG.php');
include('../barcode/src/BarcodeGeneratorJPG.php');
include('../barcode/src/BarcodeGeneratorHTML.php');


//$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
//$barcode =  $generator->getBarcode($_data[0][ref_no], $generator::TYPE_CODE_128);

$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
$barcode = '<img  src="data:image/png;base64,' . base64_encode($generator->getBarcode($_data[0][ref_no], $generator::TYPE_CODE_128)) . '">';
$title_name = date('ymdHis') . '_' . $_GET[id] . '_receive';

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
  <!-- BEGIN HEAD -->
  <head>
    <meta charset="utf-8" />
    <title><?=$_SESSION[title] ?> <?=$i_queue; ?> </title>
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
                <strong style="font-size: 23px;cursor: pointer;" onclick="javascript:window.print();">
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
                <font style="font-size: 20px;">ใบเสนอราคา <br />
                QUOTATION
                </font>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <strong style="font-size: 20px;">
            เลขประจำตัวผู้เสียภาษีอากร 0 1155 57000 58 4  สำนักงานใหญ่
          </strong>
        </td>
        <td>
          <div style="border:1px solid #ccc;padding:5px;">
            วันที่: <?=date('d/m/Y'); ?>
          </div>
          <div style="height: 5px;"></div>
          <div  style="border:1px solid #ccc;padding:5px;">
            เลขที่: QA_
          </div>
        </td>
      </tr>
    </table>
    <div align="center"></div>
    <table width="100%" celpadding="0" cellspacing="0" border="0">
      <tr>
        <td colspan="3" align="letf">
          <strong style="font-size: 16px;">
            เอกสารออกเป็นชุด	
          </strong>
        </td>
        <td width="70"></td>
        <td width="100"></td>
        <td width="110"></td>
      </tr>
      <tr>
        <td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;" width="110" align="center">
          <strong style="font-size: 16px;">
            นามผู้ซื้อ <br />
            SOLD TO
          </strong>
        </td>
        <td  colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;padding: 5px;">
          <?php echo $_data[0][s_firstname]; ?> <?php echo $_data[0][s_lastname]; ?>
        </td>
        <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;padding: 5px;"   align="left">
          <strong style="font-size: 16px;">
            เลขที่ใบสั่งซื้อ <br />
            PO.NO.
          </strong>

        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            รหัสผู้ซื้อ <br />
            <?=$_data[0][ref_no]; ?>
          </strong>

        </td>
      </tr>
      <tr>
        <td style="border:1px solid #000;border-right:1px solid #000;" align="center">
          <strong style="font-size: 16px;" >
            ที่อยู่
            <br />
            ADDRESS
          </strong>
        </td>
        <td  colspan="2" style="border:1px solid #000;border-left:0px solid #000;padding: 5px;">
          <?php echo $_data[0][s_address]; ?>
        </td>
        <td colspan="2" style="border:1px solid #000;border-left:0px solid #000;padding: 5px;">
          <strong style="font-size: 16px;">
            การชำระ
            <br />
            TERM
          </strong>
        </td>
        <td style="border:1px solid #000;border-left:0px solid #000;" align="center">
          <strong style="font-size: 16px;">
            รหัสผู้ออกบิล <br />
            -
          </strong>
        </td>
      </tr>

      <tr>
        <td colspan="3" align="letf" style="height: 5px;">
          <strong style="font-size: 16px;">
          </strong>
        </td>
      </tr>
      <tr>
        <td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;"  align="center">
          <strong style="font-size: 16px;">
            รหัส
            <br />
            CODE
          </strong>
        </td>
        <td  colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            สินค้าหรือบริการ <br />
            DESCRIPTION
          </strong>	
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            จำนวน
            <br />
            QUANTITY
          </strong>
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            ราคาต่อหน่วย
            <br />
            UNIT PRICE
          </strong>
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            จำนวนเงิน
            <br />
            AMOUNT
          </strong>
        </td>
      </tr>
      <tr>
        <td style="border:1px solid #000; height: 300px;padding: 5px;" align="left" valign="top">
          <strong style="font-size: 16px;" >
            INS001
          </strong>
        </td>
        <td colspan="2" style="border:1px solid #000;border-left:0px solid #000;padding: 5px;" valign="top">
          ค่าบริการจัดซ่อมรถยนต์ หมายเลขทะเบียน <?php echo $_data[0][s_license]; ?>
        </td>
        <td style="border:1px solid #000;border-left:0px solid #000;padding: 5px;" align="right" valign="top">
        1.0
        </td>
        <td style="border:1px solid #000;border-left:0px solid #000;padding: 5px;" align="right" valign="top">
        </td>
        <td style="border:1px solid #000;border-left:0px solid #000;padding: 5px;" align="right" valign="top">

        </td>
      </tr>
      <tr>
        <td colspan="3" align="right" style="padding : 5px;border-right:1px solid #000;">
          จำนวนเงิน
        </td>
        <td align="right" style="border-right:1px solid #000;border-bottom:1px solid #000;"></td>
        <td align="center" style="border-right:1px solid #000;border-bottom:1px solid #000;"></td>
        <td align="right" style="border-left:0px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;"></td>
      </tr>
      <tr>
        <td colspan="3" align="right" style="padding : 5px;border-right:1px solid #000;">
          ส่วนลด (%)
        </td>
        <td align="right" style="border-right:1px solid #000;border-bottom:1px solid #000;"></td>
        <td align="center" style="border-right:1px solid #000;border-bottom:1px solid #000;">%</td>
        <td align="right" style="border-left:0px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;"></td>
      </tr>
      <tr>
        <td colspan="3" align="right" style="padding : 5px;border-right:1px solid #000;">
          หลังหักส่วนลด
        </td>
        <td align="right" style="border-right:1px solid #000;border-bottom:1px solid #000;"></td>
        <td align="center" style="border-right:1px solid #000;border-bottom:1px solid #000;"></td>
        <td align="right" style="border-left:0px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;"></td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2" align="right" style="padding : 5px;border-right:1px solid #000;">
          รวมเงิน <br />
          TOTAL
        </td>
        <td align="right" valign="middle" style="border-bottom:1px solid #000;border-right:1px solid #000;"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">
          จำนวนเงินรวมทั้งสิ้น (ตัวอักษร)<br />
          <div style="border:1px solid #000;padding:5px;">
            <?=$util->bahtText($total_cost); ?>
          </div>
        </td>
        <td colspan="2" align="right" style="padding : 5px;border-right:1px solid #000;">
          ภาษีมูลค่าเพิ่ม
          <br />
          VAT
        </td>
        <td align="right" valign="middle" style="border-bottom:1px solid #000;border-right:1px solid #000;"></td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2" align="right" style="padding : 5px;border-right:1px solid #000;">
          รวมเงินทั้งสิ้น
          <br />
          TOTAL AMOUNT
        </td>
        <td align="right" valign="middle" style="border-bottom:1px solid #000;border-right:1px solid #000;">
          <?=number_format($total_cost, 2); ?>
        </td>
      </tr>
      <tr>
        <td style="height: 10px;"></td>
      </tr>
      <tr>
        <td colspan="2" style="padding : 0px;border:2px solid #000;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 5px;">
            <tr>
              <td>
                <table width="300" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td colspan="3">
                      ผู้สั่งซื้อ			
                    </td>
                  </tr>
                  <tr>
                    <td width="50" align="right">ลงชื่อ</td>
                    <td style="border-bottom: 1px solid #000;" colspan="2"></td>
                  </tr>
                  <tr>
                    <td width="50" align="right">วันที่</td>
                    <td width="150" style="border-bottom: 1px solid #000;"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="2" align="center">
                      ประทับตรา (ถ้ามี)	
                    </td>
                  </tr>
                </table>
              </td>

            </tr>
          </table>
        </td>
        <td width="120" valign="top" style="border: 2px solid #000;border-left: 0px solid #000;padding: 5px;">
          <strong style="font-size: 16px;">
            REF.no
            <br />
            <div align="center"><?=$_data[0][ref_no]; ?></div>
          </strong>
        </td>
        <td colspan="3" style="padding : 0px;border:2px solid #000;border-left: 0px solid #000;">
          <table width="100%" style="padding: 5px;">
            <tr>
              <td colspan="2">
                จึงเรียนมาเพื่อโปรพิจารณา		
              </td>
            </tr>
            <tr>
              <td width="50">ลงชื่อ</td>
              <td style="border-bottom: 1px solid #000;"></td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                ว่าที่ รต.หญิง วิไลลักษณ์ ราศรี		
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                การเงิน		
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