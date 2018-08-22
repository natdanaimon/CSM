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


$strSql = "";
$strSql .= " SELECT ";
$strSql .= " * ";
$strSql .= " FROM tb_print_record  ";
$strSql .= " WHERE i_cust_car =" . $_GET[id];
$_record = $db->Search_Data_FormatJson($strSql);
if($_record[0][i_receive] == NULL){
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
}else{
  $chk_no = $_record[0][i_receive]+1;
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
    <title><?= $_SESSION[title] ?> <?= $i_queue; ?> </title>
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
        <td width="70%" align="left">
          <table style="border:0px solid #000; " cellpadding="0" width="100%" >
            <tr>
              <td> 
                <strong style="font-size: 25px;cursor: pointer;" onclick="javascript:window.print();">
                  บริษัท รุ่งทรัพย์ ออโตโมบิล รีแพร์ เซ็นเตอร์ จำกัด <br />
                  RUNGSAP AUTOMOBILE REPAIR CENTRE CO.,LTD
                </strong>
              </td>
            </tr>
          </table>
        </td>
        <td width="30%" align="right">
          <table style="border:0px solid #000;" cellpadding="2" width="100%">
            <tr>
              <td>
                <font style="font-size: 20px;">เลขที่ <?=$s_no;?> <?=$s_run_no;?></font>
                <br />
                <font style="font-size: 20px;"><?php echo date('d/m/Y H:i'); ?></font>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <div align="center"><font style="font-size: 25px;">ใบรับรถ</font></div>
    <table width="100%">
      <tr>
        <td  width="50%" align="letf"><strong style="font-size: 16px;">รายละเอียดลูกค้า</strong></td>
        <td  width="50%" align="letf"><strong style="font-size: 16px;">รายละเอียดรถยนต์</strong></td>
      </tr>
      <tr>
        <td style="border:1px solid #000;">
          <table cellpadding="0" width="100%">
            <tr>
              <td>
                <table width="100%">
                  <tr>
                    <td width="100">REF.NO.</td>
                    <td><?php echo $_data[0][ref_no]; ?></td>
                  </tr>
                  <tr>
                    <td>ชื่อ-นามสกุล คุณ</td>
                    <td><?php echo $_data[0][s_firstname]; ?> <?php echo $_data[0][s_lastname]; ?></td>
                  </tr>
                  <tr>
                    <td>ที่อยุ่</td>
                    <td><?php echo $_data[0][s_address]; ?></td>
                  </tr>
                  <tr>
                    <td>เบอร์ติดต่อ</td>
                    <td>
                      <?php echo $_data[0][s_phone_1]; ?> <?php echo $_data[0][s_phone_2]; ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
        <td style="border:1px solid #000;">
          <table  cellpadding="0" width="100%">
            <tr>
              <td>
                <table width="100%">
                  <tr>
                    <td width="100">ยี่ห้อ/รุ่น</td>
                    <td colspan="2"><?php echo $_data[0][s_brand_name]; ?> <?php echo $_data[0][s_gen_name]; ?></td>
                    <td>ปี <?php echo $_data[0][i_year]; ?></td>
                  </tr>
                  <tr>
                    <td>ทะเบียน</td>
                    <td colspan="2"><?php echo $_data[0][s_license]; ?></td>
                    <td>สี <?=$s_color;?></td>
                  </tr>
                  <tr>
                    <td>ประกันภัย</td>
                    <td colspan="3"><?php echo $_data[0][s_name_display]; ?></td>
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
        </td>
      </tr>
    </table>
    <div align="letf"><strong style="font-size: 16px;">รายการตรวจสอบความเสียหาย ณ วันที่นำรถเข้าจอดซ่อม</strong></div>
    <table width="100%">
      <tr>
        <td width="50%" align="letf"  valign="top">
          <strong style="font-size: 16px;">ชิ้นส่วนเสียหายที่อยุ่ในรายการซ่อม</strong>
          <table style="border:1px solid #000;height: 186px;" cellpadding="2" width="100%">
            <tr>
              <td valign="top">
                <!-- Repair in list -->
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
                      <td><?= $data[s_repair_name]; ?> <?= $data[s_remark]; ?></td>
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
          </table>
          <strong style="font-size: 16px;">ชิ้นส่วนเสียหายที่ไม่อยุ่ในรายการซ่อม</strong>
          <table style="border:1px solid #000;height: 109px;" cellpadding="2" width="100%">
            <tr>
              <td valign="top">
                <!-- Repair not in list -->
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
                      <td><?= $data[s_repair_name]; ?> <?= $data[s_remark]; ?></td>
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
                    $s_txt_ok = $check_repair_other[0][$s_txt_x];
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
          </table>
        </td>
        <td width="50%" align="letf" valign="top">
          <strong style="font-size: 16px;">อุปกรณ์ไฟฟ้าพื้นฐานและระบบไฟส่องสว่าง</strong>
          <table style="border:1px solid #000;" cellpadding="0" width="100%">
            <tr>
              <td>
                <!-- Light -->
                <table width="100%" cellpadding="0">
                  <?php
                  foreach ($list_lighting as $data) {
                    $strSql = " select * ";
                    $strSql .= " FROM tb_report_lighting   WHERE i_lighting = '" . $data[id] . "' and ref_id = '" . $_GET[id] . "'  ";
                    $_lighting = $db->Search_Data_FormatJson($strSql);
                    $chk_lighting = $_lighting[0][i_status];
                    if ($chk_lighting == 1) {
                      $chkbox = 'ปกติ';
                    }elseif($chk_lighting == 2){
                      $chkbox = 'ผิดปกติ';
                    }
                    else {
                      $chkbox = "ไม่มี";
                    }
                    ?>
                    <tr>
                      <td width="60" align="center"><?= $chkbox; ?></td>
                      <td>
                        <?= $data[s_name]; ?>
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
                </table>
                หมายเหตุ : <?=$s_remark;?>
                









              </td>
            </tr>
          </table>
          <strong style="font-size: 16px;">อุปกรณ์เครื่องมือประจำรถ</strong>
          <table style="border:1px solid #000;" cellpadding="0" width="100%">
            <tr>
              <td>
                <!-- ** -->
                <table width="100%" cellpadding="0">
                  <?php
                  foreach ($list_access as $data) {
                    $strSql = " select * ";
                    $strSql .= " FROM tb_report_accessories   WHERE i_accessories = '" . $data[id] . "' and ref_id = '" . $_GET[id] . "'  ";
                    $_accessories = $db->Search_Data_FormatJson($strSql);
                    $chk_accessories = $_accessories[0][i_status];
                    if ($chk_accessories == 1) {
                      $chkbox = 'มี';
                    }elseif($chk_accessories == 2){
                      $chkbox = 'ไม่มี';
                    }
                    else {
                      $chkbox = "-";
                    }
                    ?>
                    <tr>
                      <td width="60" align="center"><?=$chkbox;?></td>
                      <td>
                        <?= $data[s_name]; ?>
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
                </table>





              </td>
            </tr>
          </table>
          <font style="font-size: 16px;">**หากรายการไหนที่เว้นไว้หมายความว่าไม่ได้ตรวจสอบก่อนจอดซ่อม</font>
        </td>
      </tr>
    </table>

    <div align="letf"><strong style="font-size: 16px;">เงื่อนไขการนำรถเข้าซ่อม</strong></div>
    <table style="border:1px solid #000;" cellpadding="2" width="100%">
      <tr>
        <td align="center" colspan="2">
          ความเสียหายดังต่อไปนี้ทางอู่จะไม่รับผิดชอบ คือ ความเสียหายนอกเหนือจากรายการซ่อม, ความเสียหายของแบตเตอรี่ เครื่องยนต์ แอร์ วิทยุ อุปกรณ์ไฟฟ้าต่างๆ ซึ่งไม่เกี่ยวกับการซ่อมในใบเคลมหรือใบเสนอราคา
          <br />
          <strong>
            ข้อมูลที่ระบุในเอกสารฉบับนี้ตรงกับข้อมูลในระบบบันทึกข้อมูลของบริษัทฯ ลูกค้าได้ตรวจสอบความถูกต้องแล้วก่อนทำการพิมพ์ ฉะนั้นจึงถือว่าลูกค้ายอมรับเงื่อนไขการจัดซ่อมโดยไม่ต้องลงลายมือชื่อเป็นลายลักษณ์อักษร
          </strong>
        </td>
      </tr>
      <tr>
        <td width="50%" align="center">
          
          <br />
          <?php echo $_data[0][s_firstname]; ?> <?php echo $_data[0][s_lastname]; ?>
          <br />
          <strong>เจ้าของรถ/ผู้นำรถเข้าซ่อม</strong>
        </td>
        <td width="50%" align="center">
          <br />
          <?= $_SESSION["full_name"] ?>
          
          <br />
          <strong>เจ้าหน้าที่รับรถ</strong>
        </td>
      </tr>
    </table>
    <br />
    <div align="letf" style="width: 100%; border-bottom: 1px dashed #000;"></div>

    <table cellpadding="2" width="100%">
      <tr>
        <td widht="50%"><strong style="font-size: 16px;">รายการจัดซ่อม/อะไหล่คงค้าง (ถ้ามี)</strong></td>
        <td align="center">**ระบุในวันที่ลูกค้ามารับรถออก</td>
      </tr>
    </table>
    <table style="border:1px solid #000;" cellpadding="2" width="100%">
      <tr>
        <td width="50%">
          <table cellpadding="0" width="100%">
            <tr>
              <td align="center" style="border:1px solid #000;" >
                <table  cellpadding="0" width="100%">
                  <tr>
                    <td>
                      ref. No. <br />
                      <?php echo $barcode; ?>
                    </td>
                  </tr>
                </table>
              </td>
              <td valign="top" style="border-bottom: 1px solid #000;">
                ส่วนของลูกค้า นำมาในวันนัดแก้ไข
                <br />
                <strong style="font-size: 16px;">วันที่นัดเข้าทำการแก้ไข </strong>
                <br>
              </td>
            </tr>
          </table>
          <table>
            <tr>
              <td>
                ยี่ห้อ/รุ่น  
              </td>
              <td>
                <?php echo $_data[0][s_brand_name]; ?> <?php echo $_data[0][s_gen_name]; ?>
                ทะเบียน <?php echo $_data[0][s_license]; ?>
              </td>
            </tr>
            <tr>
              <td>วันที่นำรถเข้าซ่อม</td>
              <td><?php echo date('d/m/Y H:i'); ?></td>
            </tr>
            <tr>
              <td>วันที่ลูกค้ารับรถออก</td>
              <td>
                <?php
                $sendcar = date('d/m/Y', strtotime($_data[0][d_sendcar]));
                echo $sendcar;
                ?>

              </td>
            </tr>
          </table>
        </td>
        <td valign="top">
          <table width="100%" border="0" cellpadding="0">
            <?php
            for ($i = 1; $i <= 5; $i++) {
              ?>
              <tr>
                <td width="50" valign="bottom"><?= $i; ?></td>
                <td style="border-bottom: 1px solid #000;"></td>
              </tr>
            <?php } ?>
            <tr>
              <td colspan="2" align="center">
                <table align="center">
                  <tr>
                    <td><strong style="font-size: 16px;">รวมทั้งสิน</strong></td>
                    <td width="100" style="border-bottom: 1px solid #000;"></td>
                    <td><strong style="font-size: 16px;">รายการ</strong></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table width="90%">
            <tr>
              <td width="50">ลงชื่อ</td>
              <td style="border-bottom: 1px solid #000;"></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><strong>เจ้าหน้าที่บันทึกข้อมูล</strong></td>
            </tr>
          </table>
        </td>
        <td>
          <table width="90%">
            <tr>
              <td width="50">ลงชื่อ</td>
              <td style="border-bottom: 1px solid #000;"></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><strong>ลูกค้ารับทราบและลงลายมือชื่อ</strong></td>
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