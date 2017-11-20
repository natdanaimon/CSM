<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new claimController();
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
    case "getInfoDetail":
        echo $controller->getInfoDetail($info[id]);
        break;
    case "edit":
        echo $controller->edit($info);
        break;
    case "add":
        echo $controller->add($info);
        break;
}

class claimController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/upload.php';
        include '../../service/insurance/claimService.php';
    }

    public function dataTable() {
        $service = new claimService();
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
        $service = new claimService();
        if ($service->delete($db, $seq)) {
            $db->commit();
            echo $_SESSION['cd_0000'];
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
        }

        $this->deleteTempFile($db);
        $this->deleteTempFileDetail($db);
    }

    public function deleteAll($info) {
        if ($info[data] == NULL) {
            echo $_SESSION['cd_2005'];
        } else {
            $util = new Utility();
            $db = new ConnectDB();
            $db->conn();
            $service = new claimService();
            $query = $util->arr2strQuery($info[data], "I");
            if ($service->deleteAll($db, $query)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
            $this->deleteTempFile($db);
            $this->deleteTempFileDetail($db);
        }
    }

    public function getInfo($seq) {
        $service = new claimService();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

     public function getInfoDetail($seq) {
        $service = new claimService();
        $_dataTable = $service->getInfoDetail($seq);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }
    
    public function deleteTempFile($db) {
        $temp = new upload();
        $svTemp = new claimService();
        $temp->set_path("../../upload/claim/");
        $_dataTemp = $svTemp->getInfoFile($db);
        foreach ($_dataTemp as $key => $value) {
            if ($_dataTemp[$key]['img'] != "") {
                $temp->add_FileName($_dataTemp[$key]['img']);
            }
        }
        $temp->deleteFileNoTemp();
    }

    public function deleteTempFileDetail($db) {
        $temp = new upload();
        $svTemp = new claimService();
        $temp->set_path("../../upload/claimDmg/");
        $_dataTemp = $svTemp->getInfoFileDetail($db);
        foreach ($_dataTemp as $key => $value) {
            if ($_dataTemp[$key]['img'] != "") {
                $temp->add_FileName($_dataTemp[$key]['img']);
            }
        }
        $temp->deleteFileNoTemp();
    }

}
