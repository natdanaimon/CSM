<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new compulsoryController();
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

class compulsoryController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/setting/compulsoryService.php';
    }

    public function dataTable() {
        $service = new compulsoryService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        $db = new ConnectDB();
        $db->conn();
        $service = new compulsoryService();
        if ($service->delete($db, $seq)) {
            $db->commit();
            echo $_SESSION['cd_0000'];
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
        }
    }

    public function deleteAll($info) {
        if ($info[data] == NULL) {
            echo $_SESSION['cd_2005'];
        } else {
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new compulsoryService();
            $query = $util->arr2strQuery($info[data], "I");
            if ($service->deleteAll($db, $query)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function getInfo($seq) {
        $service = new compulsoryService();
        $_dataTable = $service->getInfo($seq);
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
            $service = new compulsoryService();
            if ($service->edit($db, $info)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {
            $db = new ConnectDB();
            $db->conn();
            $service = new compulsoryService();
            if ($service->add($db, $info)) {
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
        if ($util->isEmpty($info[s_name])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setCompu_name'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[f_amount])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setCompu_amount'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[f_amount])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setCompu_amount'], $return2003);
            echo $return2003;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
