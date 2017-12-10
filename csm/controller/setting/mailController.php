<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new mailController();
switch ($info[func]) {
    case "dataTable":
        echo $controller->dataTable();
        break;
    case "delete":
        echo $controller->delete($info[id]);
        break;
    case "deleteAll":
        echo $controller->deleteAll($info);
        break;
    case "getInfo":
        echo $controller->getInfo($info[id]);
        break;
    case "edit":
        echo $controller->edit($info);
        break;
    case "add":
        echo $controller->add($info);
        break;
}

class mailController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/setting/mailService.php';
    }

  

    public function getInfo() {
        $service = new mailService();
        $_dataTable = $service->getInfo();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            $db = new ConnectDB();
            $db->conn();
            $service = new mailService();
            if ($service->edit($db, $info)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $return2097 = $_SESSION['cd_2097'];
        $util = new Utility();
        if ($util->isEmpty($info[s_insurance])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setMail_insurnce'], $return2099);
            echo $return2099;
        } else if (!filter_var($info[s_insurance], FILTER_VALIDATE_EMAIL)) {
            echo $_SESSION['cd_2006'];
        } else if ($util->isEmpty($info[s_claimonline])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setMail_insurnce'], $return2099);
            echo $return2099;
        } else if (!filter_var($info[s_claimonline], FILTER_VALIDATE_EMAIL)) {
            echo $_SESSION['cd_2006'];
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
