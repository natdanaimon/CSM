<?php
@session_start();
include './../common/Permission.php';
include './../common/PermissionADM.php';
include './../common/FunctionCheckActive.php';
include './../common/ConnectDB.php';
include './../common/Utility.php';
$util = new Utility();

$db = new ConnectDB();


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
    <?php
    while (list($key,$id) = each($_POST['checkboxItem'])) {
      $_GET[id] = $id;
      $strSql = " select * ";
$strSql .= " FROM tb_report_invoice   WHERE id = '".$_GET[id]."' ";
$data = $db->Search_Data_FormatJson($strSql);
$ref_no = $data[0][ref_no];
$no = $data[0][id];
$d_create = date('d/m/Y',strtotime($data[0][d_create]));
$strSql = " select * ";
$strSql .= " FROM tb_report_invoice_list   WHERE i_report_invoice = '".$_GET[id]."' ";
$dataList = $db->Search_Data_FormatJson($strSql);
$strSql = " select * ";
$strSql .= " FROM tb_user   WHERE s_user = '".$_SESSION[username]."' ";
$adminNow = $db->Search_Data_FormatJson($strSql);
$strSql = "";
$strSql .= " SELECT ";
$strSql .= " car.* ";
$strSql .= " ,cus.s_firstname , cus.s_lastname , cus.s_address ,cus.s_phone_1 , cus.s_phone_2";
$strSql .= " ,ins.s_comp_th,ins.s_address as ins_address  ,ins.s_tax_no as ins_tax_no,ins.s_code";
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

$total_cost = 0;
    ?>
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
                <font style="font-size: 20px;">ใบเสร็จรับเงิน/ใบกำกับภาษี

 <br />
                RECEIPT/TAX INVOICE
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
            วันที่: <?=$d_create;?>
          </div>
          <div style="height: 5px;"></div>
          <div  style="border:1px solid #ccc;padding:5px;">
            เลขที่: <?=$no;?>
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
          <?php echo $s_name;?>
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
            <?=$s_code;?>
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
          <?php echo $s_address;?>
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
            <?=$data[0][s_no_bill];?>
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
        <td style="border-top:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"  align="center">
          <strong style="font-size: 16px;">
            รหัส
            <br />
            CODE
          </strong>
        </td>
        <td  colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            สินค้าหรือบริการ <br />
            DESCRIPTION
          </strong>	
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            จำนวน
            <br />
            QUANTITY
          </strong>
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            ราคาต่อหน่วย
            <br />
            UNIT PRICE
          </strong>
        </td>
        <td style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"   align="center">
          <strong style="font-size: 16px;">
            จำนวนเงิน
            <br />
            AMOUNT
          </strong>
        </td>
      </tr>
      <?php
      if($data[0][ref_no] != ''){
      ?>
      <tr>
        <td style="border-right:1px solid #000;border-left:1px solid #000;border-top:0px solid #000;padding: 5px;" align="center" valign="top">
          <strong style="font-size: 16px;" >
            INS001
          </strong>
        </td>
        <td colspan="2" style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" valign="top">
          ค่าบริการจัดซ่อมรถยนต์ หมายเลขทะเบียน <?php echo $data[0][s_license];?> <?php echo $data[0][s_province];?>
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          <?php echo($data[0][i_amount] > 0) ? "1.0" : "";?>
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          <?php echo($data[0][i_amount] > 0) ? number_format($data[0][i_amount],2) : "";?>
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          <?php 
          $total_cost += $data[0][i_amount];
          echo($data[0][i_amount] > 0) ? number_format($data[0][i_amount],2) : "";
          
          ?>
        </td>
      </tr>
      <?php } ?>
        <?php
      foreach($dataList as $dataL){
        ?>
      <tr style="height: 28px;">
        <td style="border-right:1px solid #000;border-left:1px solid #000;border-top:0px solid #000;padding: 5px;" align="center" valign="top">
          <strong style="font-size: 16px;" >
            <?=$dataL[s_list_code];?>
          </strong>
        </td>
        <td colspan="2" style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" valign="top">
          <?=$dataL[s_list_name];?> <?=$dataL[s_list_detail];?>
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          <?php echo($dataL[s_list_amount] > 0) ? number_format($dataL[s_list_amount],1) : "";?>
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          <?php echo($dataL[s_list_price] > 0) ? number_format($dataL[s_list_price],2) : "";?>
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          <?php 
          $sumList = $dataL[s_list_amount]*$dataL[s_list_price];
          $total_cost += $sumList;
          echo($sumList > 0) ? number_format($sumList,2) : "";
          ?>
        </td>
      </tr>
      <?php
      }
      ?>
      <?php
      for($i=0;$i<=1;$i++){
      ?>
      <tr style="height: 28px;">
        <td style="border-right:1px solid #000;border-left:1px solid #000;border-top:0px solid #000;padding: 5px;" align="center" valign="top">
          <strong style="font-size: 16px;" >
            
          </strong>
        </td>
        <td colspan="2" style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" valign="top">
          
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;padding: 5px;" align="right" valign="top">
          
        </td>
      </tr>
      <?php } ?>
      <tr>
        <td style="border-right:1px solid #000;border-left:1px solid #000;border-bottom :1px solid #000;padding: 5px;" align="center" valign="top">
          <strong style="font-size: 16px;" >
            
          </strong>
        </td>
        <td colspan="2" style="border-right:1px solid #000;border-left:0px solid #000;border-bottom:1px solid #000;padding: 5px;" valign="top">
          
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-bottom:1px solid #000;padding: 5px;" align="right" valign="top">
          
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-bottom:1px solid #000;padding: 5px;" align="right" valign="top">
          
        </td>
        <td style="border-right:1px solid #000;border-left:0px solid #000;border-bottom:1px solid #000;padding: 5px;" align="right" valign="top">
          
        </td>
      </tr>
      <tr>
        <td colspan="3" align="right" style="padding : 5px;border-right:1px solid #000;">
          จำนวนเงิน
        </td>
        <td align="right" style="border-right:1px solid #000;border-bottom:1px solid #000;"></td>
        <td align="center" style="border-right:1px solid #000;border-bottom:1px solid #000;"></td>
        <td align="right" style="border-left:0px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">
          <?=number_format($total_cost,2);?>
        </td>
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
        <td align="right" style="border-left:0px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">
          <?=number_format($total_cost,2);?>
        </td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2" align="right" style="padding : 5px;border-right:1px solid #000;">
          รวมเงิน <br />
          TOTAL
        </td>
        <td align="right" valign="middle" style="border-bottom:1px solid #000;border-right:1px solid #000;">
          <?=number_format($total_cost,2);?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">
          จำนวนเงินรวมทั้งสิ้น (ตัวอักษร)<br />
          <div style="border:1px solid #000;padding:5px;">
            <?php
             $total_vat = $total_cost*7/100;
          $total_cost+= $total_vat;
            ?>
            <?=$util->bahtText($total_cost);?>
          </div>
        </td>
        <td colspan="2" align="right" style="padding : 5px;border-right:1px solid #000;">
          ภาษีมูลค่าเพิ่ม
          <br />
          VAT
        </td>
        <td align="right" valign="middle" style="border-bottom:1px solid #000;border-right:1px solid #000;">
          <?php
          echo number_format($total_vat,2);
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2" align="right" style="padding : 5px;border-right:1px solid #000;">
          รวมเงินทั้งสิ้น
          <br />
          TOTAL AMOUNT
        </td>
        <td align="right" valign="middle" style="border-bottom:1px solid #000;border-right:1px solid #000;">
          <?=number_format($total_cost,2);?>
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
            <div align="center"><?=$_data[0][ref_no];?></div>
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
                <?=$adminNow[0][s_firstname];?>	<?=$adminNow[0][s_lastname];?>		
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
    <?php } ?>

  </body>
</html>
