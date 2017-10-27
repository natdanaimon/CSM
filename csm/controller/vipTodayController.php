<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}
//$info['month'] = '8/1/2017';
//$info['func'] = 'search';

$controller = new vipTodayController();
switch ($info[func]) {
    case "search":
        echo $controller->search($info);
        break;
}

class vipTodayController {

    public function search($info) {
        include '../service/vipTodayService.php';
        include '../common/ConnectDB.php';
        $service = new vipTodayService();
        $db = new ConnectDB();
        $_dataTable = $service->searchAllUsers($db);
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
//                if($_dataTable[$key]['s_user']=='zlwav01035'){
//                    $a = "123";
//                    
//                }
                $turnOver = $service->getTurnOver($db, $info[month], $_dataTable[$key]['s_user']);
                $tmp = array(
                    'month' => $this->convertDate($info[month]),
                    'username' => $_dataTable[$key]['s_user'],
                    'turnover' => $turnOver,
                    'pay' => $service->sumLevel1_2_Percen($db, $_dataTable[$key]['s_user'], $info[month]),
                    'remark' => $this->checkRemark($turnOver)
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

     function convertDate($d) {
        $epStr = explode("/", $d);
        $mm = $epStr[0];
        $yyyy = $epStr[2];
        return "(" . $this->getMonth($mm) . " " . $yyyy . ")";
    }
    

    function getMonth($intMonth) {
        $monthNum = $intMonth;
        $dateObj = DateTime::createFromFormat('!m', $monthNum);
        return $monthName = $dateObj->format('F'); // March
    }

    function checkRemark($turnOver) {
        $remark = "";
        $tmp = floatval($turnOver);
        if ($tmp < 30000) {
            $remark = $_SESSION[lb_vip_remark_turnover];
        }
        return $remark;
    }

    function checkRemarkPDF($turnOver) {
        $remark = "";
        $tmp = floatval($turnOver);
        if ($tmp < 30000) {
            $remark = "TurnOver less than 30,000 baht.";
        }
        return $remark;
    }

}
