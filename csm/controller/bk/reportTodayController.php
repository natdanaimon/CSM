<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}

$controller = new reportTodayController();
switch ($info[func]) {
    case "search":
        echo $controller->search($info);
        break;
}

class reportTodayController {

    public function search($info) {
        include '../service/reportTodayService.php';
        include '../common/Utility.php';
        $service = new reportTodayService();
        $util = new Utility();


        $info[d_start] = $util->DateSQL($info[d_start]);

        $_dataTableRegister = $service->search($info, "tb_cs_user");
        $_dataTableDeposit = $service->search($info, "tb_cs_dp");
        $_dataTableWithdraw = $service->search($info, "tb_cs_wd");



        $tmp = array(
            'register' => $this->convertJson($_dataTableRegister),
            'deposit' => $this->convertJson($_dataTableDeposit),
            'withdraw' => $this->convertJson($_dataTableWithdraw)
        );

        $tmpReturn[] = $tmp;


        return json_encode(array_values($tmpReturn));
    }

    public function convertJson($_dataTable) {
        if ($_dataTable != NULL) {
             foreach ($_dataTable as $key => $value) {
                if($_dataTable[$key]['s_username']==""){
                    $_dataTable[$key]['s_username'] = $_SESSION['rep_today_null'];
                }
            }
            return json_encode($_dataTable);
        } else {
            return "";
        }
    }

}
