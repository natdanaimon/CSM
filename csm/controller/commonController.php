<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new commonController();
switch ($info[func]) {
    case "DDLStatus":
        echo $controller->DDLStatus();
        break;
    case "DDLStatusActive":
        echo $controller->DDLStatusActive();
        break;
    case "ValidSecurity":
        echo $controller->ValidSecurity($info);
        break;
}

class commonController {

    public function __construct() {
        include '../common/ConnectDB.php';
        include '../common/Utility.php';
        include '../common/Logs.php';
        include '../common/upload.php';
        include '../service/commonService.php';
    }

    public function DDLStatus() {
        $service = new commonService();
        $_dataTable = $service->DDLStatus();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLStatusActive() {
        $service = new commonService();
        $_dataTable = $service->DDLStatusActive();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

}
