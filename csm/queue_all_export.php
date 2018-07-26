<?php
header("Content-Type: text/plain; charset=windows-874");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=CSM-" . date('YmdHis') . ".xls;");
?>
<?php
include './common/ConnectDB.php';
include './service/repair/createService.php';
$service = new createService();
$db = new ConnectDB();
$strSql = " select * from ";
$strSql .= " (";
$strSql .= " select u.*, s.s_detail_th status_th, s.s_detail_en status_en";
$strSql .= " from tb_customer_car u, tb_status s";
$strSql .= " where u.s_status = s.s_status";
$strSql .= " and s.s_type = 'REPAIR'";
//$strSql .= " and s.s_status in ('R2','R3') ";
$strSql .= " ) tb_cust ,";
$strSql .= " (";
$strSql .= " select u.i_customer,concat(t.s_title_th, ' ', u.s_firstname, ' ', u.s_lastname) s_fullname,u.s_phone_1";
$strSql .= " from tb_customer u, tb_status s, tb_title t";
$strSql .= " where u.s_status = s.s_status";
$strSql .= " and s.s_type = 'ACTIVE' and u.i_title = t.i_title ";
$strSql .= " ) customer";
$strSql .= " WHERE tb_cust.i_customer = customer.i_customer ";
$strSql .= " order by tb_cust.d_create asc  ";
$_data = $db->Search_Data_FormatJson($strSql);
$db->close_conn();

function getInsuranceDisplay($seq, $db) {
  //$db = new ConnectDB();
  $strSql = " select * from tb_insurance_comp where i_ins_comp =" . $seq;
  $_data = $db->Search_Data_FormatJson($strSql);
  $db->close_conn();
  return $_data[0]['s_name_display'];
}
?>
<!DOCTYPE html>
<html lang="en">
  <!-- BEGIN HEAD -->
  <head>
    <meta charset="utf-8" />
    <title><?=$_SESSION[title] ?></title>
  </head>
  <body>
    <table>
      <thead>
        <tr>
          <th>REF.NO</th>
          <th>ประกันภัย</th>
          <th>ทะเบียน</th>
          <th>ยี่ห้อ</th>
          <th>รุ่น</th>      
      </thead>
      <tbody>
        <?php
        foreach ($_data as $data) {
          ?>
          <tr>
            <td><?=$data[ref_no]; ?></td>
            <td><?=getInsuranceDisplay($data[i_ins_comp], $db); ?></td>
            <td><?=$data[s_license]; ?></td>
            <td><?=$service->getBrand($data[s_brand_code]); ?></td>
            <td><?=$service->getGeneration($data[s_gen_code]); ?></td>
          </tr>
          <?php
        }
        ?>

      </tbody>
    </table>
  </body>

</html>