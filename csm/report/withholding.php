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
    ฉบับที่ 1 (สำหรับผู้ถูกหักภาษี ณ ที่จ่าย ใช้แนบพร้อมกับแบบแสดงรายการภาษี)<br />										
    ฉบับที่ 2 (สำหรับผู้ถูกหักภาษี ณ ที่จ่าย เก็บไว้เป็นหลักฐาน)

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #000;">
      <tr>
        <td align="center" style="border-bottom: 1px solid #000;">
          <strong>หนังสือรับรองหักภาษี ณ ที่จ่าย ตามมาตรา 50 ทวิ แห่งประมวลรัษฎากร</strong>
        </td>
      </tr>
      <tr>
        <td style="padding:5px;">
          <table width="100%">
            <tr>
              <td width="105">
                <img src="../images/logo/logo.jpg" style="width: 100px;"/>
              </td>
              <td  align="left" valign="top">
                <table style="border:0px solid #000; " cellpadding="0" width="100%" >
                  <tr>
                    <td valign="top"> 
                      <strong style="font-size: 16px;cursor: pointer;" onclick="javascript:window.print();">
                        บริษัท รุ่งทรัพย์ ออโตโมบิล รีแพร์ เซ็นเตอร์ จำกัด <br />
                      </strong>
                      <font style="font-size: 16px;">
                      Rungsap Automobile Repair Centre Co.,Ltd.<br />
                      23/326 หมู่ที่2 ซอยสุขุมวิท35 อัศวนนท์ ถนนสุขุมวิท <br />
                      ตำบลบางเมือง อำเภอเมืองฯ จังหวัดสมุทรปราการ 10270 <br />
                      Tel.(662) 388 0700, (662) 388 1821 Fax.(622) 702 5185
                      </font>
                    </td>
                  </tr>
                </table>
              </td>
              <td align="right">
                <table  cellpadding="2" width="100%">
                  <tr>
                    <td align="right">เลขที่ <br />No.</td>
                    <td align="center" style="border:1px solid #000;">
                      <font style="font-size: 20px;">
                      1
                      </font>
                    </td>
                  </tr>
                </table>
                <table  cellpadding="2" width="100%">
                  <tr>
                    <td align="right">เลขประจำตัวผู้เสียภาษีอากร</td>
                    <td align="center" style="border:1px solid #000;">
                      <font style="font-size: 20px;">
                      0 1155 57000 584
                      </font>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="3" align="center" style="border-bottom: 1px solid #000;">
              </td>
            </tr>
          </table>
          <div align="center" style="height: 10px;"></div>
          <table width="100%" celpadding="0" cellspacing="0" border="0">
            <tr>
              <td align="letf">
                <font style="font-size: 15px;">
                <strong>ชื่อ ที่อยู่ ของผู้ถูกหักภาษี ณ ที่จ่าย </strong><br />
                Name and Address of Recipient	
                </font>
              </td>
              <td width="100"></td>
              <td width="50"></td>
              <td width="50"></td>
              <td width="100"></td>
            </tr>
            <tr>
              <td rowspan="3" valign="top" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;padding: 5px;">
                <?php echo $_data[0][s_firstname]; ?> <?php echo $_data[0][s_lastname]; ?>
                <br />
                <?php echo $_data[0][s_address]; ?>
              </td>
              <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;padding: 2px;"   align="right">
                <strong style="font-size: 15px;">
                  รหัสผู้ขาย :
                </strong>
              </td>
              <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
                <strong style="font-size: 15px;">
                  <?php echo $_data[0][ref_no]; ?>
                </strong>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;padding: 2px;"   align="right">
                <strong style="font-size: 15px;">
                  เลขประจำตัวประชาชน :
                </strong>
              </td>
              <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">

              </td>
            </tr>
            <tr>
              <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;padding: 2px;"   align="right">
                <strong style="font-size: 15px;">
                  เลขประจำตัวผู้เสียภาษีอากร :</strong><br />
                ของผู้ถูกหักภาษี ณ ที่จ่าย  
              </td>
              <td colspan="2" style="border-top:1px solid #000;border-right:1px solid #000;"   align="center">
                <strong style="font-size: 15px;">

                </strong>
              </td>
            </tr>


            <tr>
              <td style="border:1px solid #000;border-right:1px solid #000;" align="center">
                <strong style="font-size: 15px;" >
                  ประเภทเงินได้พึงประเมินที่จ่าย
                </strong>
              </td>
              <td style="border:1px solid #000;border-left:0px solid #000;padding: 2px;" align="center">
                <strong style="font-size: 15px;">
                  วัน เดือน
                  <br />
                  หรือปีภาษี ที่จ่าย
                </strong>
              </td>
              <td colspan="2" style="border:1px solid #000;border-left:0px solid #000;padding: 2px;" align="center">
                <strong style="font-size: 15px;">
                  จำนวนเงินที่จ่าย
                </strong>
              </td>
              <td style="border:1px solid #000;border-left:0px solid #000;" align="center">
                <strong style="font-size: 15px;">
                  ภาษีที่หักและนำส่งไว้
                </strong>
              </td>
            </tr>
            <tr>
              <td style="border-left:1px solid #000;border-right:1px solid #000;">
                <table cellpadding="1" border="0" cellspacing="1">
                  <tr>
                    <td width="10">1.</td>
                    <td colspan="4">
                      เงินเดือน ค่าจ้าง เบี้ยเลี้ยง โบนัส ฯลฯ ตามมาตรา 40 (1)
                    </td>
                  </tr>
                  <tr>
                    <td>2.</td>
                    <td colspan="4">
                      ค่าธรรมเนียม ค่านายหน้า ฯลฯ ตามมาตรา 40 (2)
                    </td>
                  </tr>
                  <tr>
                    <td>3.</td>
                    <td colspan="4">
                      ค่าแห่งลิขสิทธิ์ ฯลฯ ตามมาตรา 40 (3)
                    </td>
                  </tr>
                  <tr>
                    <td valign="top">4.</td>
                    <td>(ก)</td>
                    <td  colspan="3">ค่าดอกเบี้ย ฯลฯ ตามมาตรา 40 (4) (ก)</td>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>(ข)</td>
                    <td colspan="3">เงินปันผล เงินส่วนแบ่งกำไร ฯลฯ ตามมาตรา 40</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td valign="top">(1)</td>
                    <td colspan="2">
                      กรณีผู้ได้รับเงินปันผลได้รับเครดิต โดยจ่ายจาก กำไรสุทธิ<br />
                      ของกิจการที่ต้องเสียภาษีเงินได้นิติบุคคล ในอัตราดังนี้
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>(1.1)</td>
                    <td>อัตราร้อยละ 30 ของกำไรสุทธิ</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>(1.2)</td>
                    <td>อัตราร้อยละ 25 ของกำไรสุทธิ</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>(1.3)</td>
                    <td>อัตราร้อยละ 20 ของกำไรสุทธิ</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>(1.4)</td>
                    <td>อัตราอื่นๆ (ระบุ)..............ของกำไรสุทธิ</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td valign="top">(2)</td>
                    <td colspan="2">
                      กรณีผู้ได้รับเงินปันผลได้รับเครดิตภาษีเนื่องจากจ่ายจาก
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>(2.1)</td>
                    <td>กำไรสุทธิของกิจการที่ได้รับยกเว้นภาษีเงินได้นิติบุคคล</td>
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
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>(2.4)</td>
                    <td>กำไรที่รับรู้ทางบัญชีโดยวิธีส่วนได้เสีย</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>(2.5)</td>
                    <td>อื่นๆ (ระบุ).....................................................</td>
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
                  </tr>
                  <tr>
                    <td  valign="top">6.</td>
                    <td colspan="4">
                      เงินได้จากวิชาชีพอิสระ
                    </td>
                  </tr>
                  <tr>
                    <td  valign="top">7.</td>
                    <td colspan="4">
                      เงินได้จากการรับเหมา
                    </td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td colspan="4">
                      เงินได้อื่นๆ นอกจากที่ระบุไว้ในประเภทที่ 1 ถึงประเภทที่ 7
                    </td>
                  </tr>
                </table>
              </td>
              <td valign="top" style="border:1px solid #000;border-left:0px solid #000;padding: 2px;border-top:0px solid #000;" align="center">
                <strong style="font-size: 15px;">

                </strong>
              </td>
              <td valign="top" colspan="2" style="border:1px solid #000;border-left:0px solid #000;padding: 2px;border-top:0px solid #000;" align="center">
                <strong style="font-size: 15px;">

                </strong>
              </td>
              <td valign="top" style="border:1px solid #000;border-left:0px solid #000;border-top:0px solid #000;" align="center">
                <strong style="font-size: 15px;">

                </strong>
              </td>
            </tr>

            <tr>
              <td colspan="2" style="border:1px solid #000;border-right:1px solid #000;border-bottom:0px solid #000;" align="center">
                <table width="100%">
                  <tr>
                    <td>
                      <strong style="font-size: 15px;" >
                        รวมเงินภาษีที่หักนำสั่ง(ตัวอักษร)
                      </strong>
                    </td>
                    <td align="right">
                      <strong style="font-size: 15px;" >
                        รวมเงินที่จ่ายและภาษีที่หักนำส่ง 
                      </strong>
                    </td>
                  </tr>
                </table>
              </td>
              <td colspan="2" style="border:1px solid #000;border-left:0px solid #000;padding: 2px;border-bottom:0px solid #000;" align="right">

              </td>
              <td style="border:1px solid #000;border-left:0px solid #000;border-bottom:0px solid #000;" align="right">

              </td>
            </tr>
            <tr>
              <td colspan="2" style="border:0px solid #000;border-right:1px solid #000;height: 2px;border-left:1px solid #000;" align="center">
              </td>
              <td colspan="2" style="border:1px solid #000;border-left:0px solid #000;" align="right">

              </td>
              <td style="border:1px solid #000;border-left:0px solid #000;" align="right">

              </td>
            </tr>
            <tr>
              <td colspan="5" style="border-bottom:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;" align="center">
                <table width="100%">
                  <tr>
                    <td>
                      <strong style="font-size: 15px;" >
                        <?=$util->bahtText($total_cost); ?>
                      </strong>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="border-bottom:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;" align="center">
                <table width="100%">
                  <tr>
                    <td>
                      ลำดับที่/เลขที่หนังสือรับรองฯ
                    </td>
                    <td align="right">ในใบแนบ</td>
                    <td width="110">
                      <input type="checkbox" id="a1" name="a1"/>
                      <label for="a1">ภ.ง.ด. 1 ก.</label>
                    </td>
                    <td width="200">
                      <input type="checkbox" id="a1s" name="a1s"/>
                      <label for="a1s">ภ.ง.ด. 1 ก. (พิเศษ)</label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      ลำดับที่/เลขที่บัญชี/เลขที่ตั๋วเงิน
                    </td>
                    <td align="right">ในใบแนบ</td>
                    <td>
                      <input type="checkbox" id="a2" name="a2"/>
                      <label for="a2">ภ.ง.ด. 2</label>
                    </td>
                    <td>
                      <input type="checkbox" id="a2s" name="a2s"/>
                      <label for="a2s">ภ.ง.ด. 2 ก</label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      ลำดับที่/เลขทีหนังสือรับรอง
                    </td>
                    <td align="right">ในใบแนบ</td>
                    <td>
                      <input type="checkbox" id="a3" name="a3"/>
                      <label for="a3">ภ.ง.ด. 3</label>
                    </td>
                    <td>
                      <input type="checkbox" id="a3s" name="a3s"/>
                      <label for="a3s">ภ.ง.ด. 53</label>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="padding:5px;border-bottom:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;" align="left">
                <strong style="font-size: 15px;" >
                  ผู้จ่ายเงิน :
                </strong>
                <table width="100%">
                  <tr>
                    <td width="25%">
                      <input type="checkbox" id="pay1" name="pay1"/>
                      <label for="pay1">(1) หัก ณ ที่จ่าย</label>
                    </td>
                    <td width="25%">
                      <input type="checkbox" id="pay2" name="pay2"/>
                      <label for="pay2">(2) ออกให้ตลอดไป</label>
                    </td>
                    <td width="25%">
                      <input type="checkbox" id="pay3" name="pay3"/>
                      <label for="pay3">(3) ออกให้ครั้งเดียว</label>
                    </td>
                    <td width="25%">
                      <input type="checkbox" id="pay4" name="pay4"/>
                      <label for="pay4">(4) อื่น ๆ (ระบุ)_____________</label>
                    </td>
                  </tr>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="5" style="border-bottom:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;" align="center">
          <table width="100%">
            <tr>
              <td style="border-right:1px solid #000;" width="200">
                <strong style="font-size: 15px;" >
                  คำเตือน : <br />
                </strong>
                ผู้มีหน้าที่ ออกหนังสือรับรองการหักภาษี ณ ที่จ่าย ฝ่าฝืน ไม่ปฏิบัติตามมาตรา 50 ทวิ แห่งประมวลรัษฎากร ต้องรับโทษทางอาญาตามมาตรา35แห่งประมวลรัษฎากร
              </td>
              <td aligin="center" valign="top">
                <table width="100%">
                  <tr>
                    <td align="center" colspan="2">
                      ขอรับรองว่าข้อความและตัวเลขดังกล่าวข้างต้นถูกต้องตรงกับความจริงทุกประการ
                    </td>
                  </tr>
                  <tr>
                    <td>
                      ลงชื่อ………………………………………………….ผู้มีหน้าที่หัก ณ ที่จ่าย
                    </td>
                    <td rowspan="2" align="left">
                      <style>
                        #logo_circle { 
                          width: 60px; /* ความกว้าง */
                          height: 60px; /* ความสูง */
                          -moz-border-radius: 70px; 
                          -webkit-border-radius: 70px; 
                          border-radius: 70px;
                          border:1px solid #ccc;
                          text-align: center;
                          padding: 10px;
                        }
                      </style>
                      <div id="logo_circle">
                        <span style="margin-top: 5px;">
                          ตราประทับ<br />
                          นิติบุคล<br />
                          (ถ้ามี)
                        </span>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top">
                      <?=date('d/m/Y'); ?>	    (วัน เดือน ปี ที่ออกหนังสือรับรองฯ)
                    </td>
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