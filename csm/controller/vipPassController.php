<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


//$func = ($info[func]!=null?$info[func]:$info[func2]);

$controller = new vipPassController();
switch ($info[func]) {
    case "add":
        echo $controller->add($info);
        break;
    case "edit":
        echo $controller->edit($info);
        break;
    case "dataTable":
        echo $controller->dataTable($info);
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
}

class vipPassController {

    public function dataTable() {
        include '../service/vipPassService.php';
        $service = new vipPassService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {
            include '../service/vipPassService.php';
            require_once('../common/ConnectDB.php');

            $db = new ConnectDB();
            $db->conn();
            $service = new vipPassService();


            if ($service->validMain($db, $info[s_username])) {
                echo $_SESSION['cd_2215'];
                return;
            }
            if ($service->add($db, $info)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            include '../service/vipPassService.php';
            require_once('../common/ConnectDB.php');
            $db = new ConnectDB();
            $db->conn();
            $service = new vipPassService();

            if ($service->edit($db, $info)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function delete($seq) {
        include '../service/vipPassService.php';
        require_once('../common/ConnectDB.php');
        $db = new ConnectDB();
        $db->conn();
        $service = new vipPassService();
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
            include '../service/vipPassService.php';
            require_once('../common/ConnectDB.php');
            include '../common/Utility.php';
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new vipPassService();
            $query = $util->arr2strQuery($info[data], "S");
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
        include '../service/vipPassService.php';
        $service = new vipPassService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        include '../common/Utility.php';
        $util = new Utility();
        if ($util->isEmpty($info[s_username])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_username_file'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_username_login])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_cs_username_login'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
