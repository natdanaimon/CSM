
<?php

@session_start();
include '../common/Permission.php';
include '../common/FunctionCheckActive.php';

date_default_timezone_set('Asia/Bangkok');
ini_set('max_execution_time', 0);
ini_set("memory_limit", "1G");
$info = array();
$info['month'] = '8/1/2017';//$_GET[month];
include '../service/vipTodayService.php';
include '../controller/vipTodayController.php';
include '../common/ConnectDB.php';
$controller = new vipTodayController();
$service = new vipTodayService();
$db = new ConnectDB();
$_dataTable = $service->search($db, $info);


$htmlHeader = '
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div class="container">
    <h3> Monthly Balance Summary   <span id="txt-month">' . $controller->convertDate($info[month]) . '</h3>         
    <table class="table table-bordered">
        
            <tr>
                <th align="center" style="background-color: whitesmoke;">' . Username . '</th>
                <th align="center" style="background-color: whitesmoke;">' . TurnOver . '</th>
                <th align="center" style="background-color: whitesmoke;">' . Pay . '</th>
                <th align="center" style="background-color: whitesmoke;">' . Remark . '</th>
            </tr>
        
        ';
$htmlBody = '';




$htmlBodyEnd .= '           
    </table>
</div>';

// generate pdf
include("../mpdf/mpdf.php");
$mpdf = new mPDF();
$mpdf->SetFooter('Page {PAGENO} of {nb}');
$mpdf->SetTitle('Summary '.$controller->convertDate($info[month]));

if ($_dataTable != NULL) {
    foreach ($_dataTable as $key => $value) {
        $htmlBody .= '<tr>';

        $htmlBody .= '    <td align="center">' . $_dataTable[$key]['s_user'] . '</td>';
        $htmlBody .= '    <td align="right">' . number_format($_dataTable[$key]['f_turnover'], 2) . '&nbsp;</td>';
        $htmlBody .= '    <td align="right">' . number_format($service->sumLevel1_2_Percen($db, $_dataTable[$key]['s_user'], $info[month]), 2) . '&nbsp;</td>';
        $htmlBody .= '    <td align="center" style="color:red;">&nbsp;' . $controller->checkRemarkPDF($_dataTable[$key]['f_turnover']) . '</td>';
        $htmlBody .= '</tr>';
        if ($key % 50 == 0 && $key > 0) {
            $mpdf->AddPage();
            $mpdf->WriteHTML($htmlHeader . $htmlBody . $htmlBodyEnd);
            $htmlBody = '';
        }
    }
    if ($htmlBody != '') {
        $mpdf->AddPage();
        $mpdf->WriteHTML($htmlHeader . $htmlBody . $htmlBodyEnd);
    }
} else {
    $htmlBody .= '<tr><td> No Data. </td></tr>';
}

//$mpdf->Output();
$mpdf->Output($controller->convertDate($info[month]).'.pdf', 'I');

//echo $htmlHeader . $htmlBody . $htmlBodyEnd;

exit;
