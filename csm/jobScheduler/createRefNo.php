<?php

include '../common/ConnectDB.php';
include '../common/Utility.php';
$util = new Utility();
$year = substr($util->getDatetimePattern('Y'), 2, 2);
$month = $util->getDatetimePattern('m');
$initialRunning = "000";


$db = new ConnectDB();
$db->conn();

$strSQLCheck = "SELECT count(*) cnt from tb_master_running where s_year = '$year' and s_month = '$month' ";
$_data = $db->Search_Data_FormatJson($strSQLCheck);

if ($_data[0][cnt] == "0") {
    $strSQL = "INSERT INTO tb_master_running(s_year, s_month, s_running) VALUES ('$year','$month','$initialRunning')";
    $arr = array(
        array("query" => "$strSQL")
    );
    $reslut = $db->insert_for_upadte($arr);
    $db->commit();
}

$db->close_conn();


