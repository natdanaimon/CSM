<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);
$_SESSION["ss_scriptPHP"] = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}

$controller = new reportUserController();
switch ($info[func]) {
    case "search":
        echo $controller->search($info);
        break;
}

class reportUserController {

    public function search($info) {
        include '../service/reportUserService.php';
        include '../common/Utility.php';
        include '../common/ConnectDB.php';
        $service = new reportUserService();
        $util = new Utility();
        $db = new ConnectDB();
        $user = ($util->isEmpty($info[s_username]) ? FALSE : TRUE );
        $name = ($util->isEmpty($info[fullname]) ? FALSE : TRUE );

        $_dataTable = $service->searchListUser($db, $info, $user, $name);
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmpUser = $_dataTable[$key]['s_username'];
                $tmpName = $_dataTable[$key]['s_fullname'];
                $zero = 0.00;

                $dpAppr = $service->searchDeposit($db, $tmpUser, 'APPR');
                $dp_APPR = ($dpAppr != NULL ? number_format($dpAppr[0]['f_amount'], 2) : $zero);
                $dp_APPR_BONUS = ($dpAppr != NULL ? number_format($dpAppr[0]['f_bonus'], 2) : $zero);
                $dp_APPR_SPECIAL = ($dpAppr != NULL ? number_format($dpAppr[0]['f_bonus_special'], 2) : $zero);

                $dpPend = $service->searchDeposit($db, $tmpUser, 'PEND');
                $dp_PEND = ($dpPend != NULL ? number_format($dpPend[0]['f_amount'], 2) : $zero);

                $dpRej = $service->searchDeposit($db, $tmpUser, 'REJ');
                $dp_REJ = ($dpRej != NULL ? number_format($dpRej[0]['f_amount'], 2) : $zero);


                $wdAppr = $service->searchWithdraw($db, $tmpUser, 'APPR');
                $wd_APPR = ($wdAppr != NULL ? number_format($wdAppr[0]['f_amount'], 2) : $zero);

                $wdPend = $service->searchWithdraw($db, $tmpUser, 'PEND');
                $wd_PEND = ($wdPend != NULL ? number_format($wdPend[0]['f_amount'], 2) : $zero);

                $wdRej = $service->searchWithdraw($db, $tmpUser, 'REJ');
                $wd_REJ = ($wdRej != NULL ? number_format($wdRej[0]['f_amount'], 2) : $zero);

                $total = ($dpAppr != NULL ? floatval($dpAppr[0]['f_amount']) : 0) - ($wdAppr != NULL ? floatval($wdAppr[0]['f_amount']) : 0);
                $pertotal = ($dpAppr != NULL ? floatval($dpAppr[0]['f_amount']) : 0) + ($wdAppr != NULL ? floatval($wdAppr[0]['f_amount']) : 0);
                $color = 'black';
                if ($total > 0) {
                    $color = 'green';
                } else if ($total < 0) {
                    $color = 'red';
                }
                $byPer = ($pertotal == 0 ? 100 : $pertotal) / 100;
                $perDP = (count($dpAppr) > 0 ? floatval($dpAppr[0]['f_amount']) / $byPer : 0);
                $perWD = (count($wdAppr) > 0 ? floatval($wdAppr[0]['f_amount']) / $byPer : 0);
                $perTo = ($perDP + $perWD > 0 ? 0 : 100);

                $tmp = array(
                    's_username' => $tmpUser,
                    's_fullname' => $tmpName,
                    'rs_dp_appr' => $dp_APPR,
                    'rs_dp_appr_bonus' => $dp_APPR_BONUS,
                    'rs_dp_appr_bonus_spcial' => $dp_APPR_SPECIAL,
                    'rs_dp_pend' => $dp_PEND,
                    'rs_dp_rej' => $dp_REJ,
                    'rs_wd_appr' => $wd_APPR,
                    'rs_wd_pend' => $wd_PEND,
                    'rs_wd_rej' => $wd_REJ,
                    'rs_result' => number_format($total, 2),
                    'rs_result_color' => $color,
                    'no_dp' => $perDP,
                    'no_wd' => $perWD,
                    'no_to' => $perTo,
                    'rs_tt_appr' => number_format($pertotal, 2)
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

}
