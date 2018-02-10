<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);
ini_set("post_max_size", "1024M");
ini_set("upload_max_filesize", "1024M");
ini_set("max_input_time", "3600");
ini_set("output_buffering", "Off");
ini_set("max_execution_time", "1800");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new commentController();
switch ($info[func]) {
    case "dataTable":
        echo $controller->dataTable($info);
        break;
    case "comment":
        echo $controller->comment($info);
        break;
    case "delete":
        echo $controller->delete($info[id]);
        break;
}

class commentController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/repair/commentService.php';
    }

    public function dataTable($info) {
        $service = new commentService();
        $_dataTable = $service->dataTable($info);
        $util = new Utility();
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
//                 $_dataTable[$key]['d_create'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_create']);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        $db = new ConnectDB();
        $db->conn();
        $service = new commentService();
        if ($service->delete($db, $seq)) {
            $db->commit();
            echo $_SESSION['cd_0000'];
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
        }
    }

    public function comment($info) {
        if ($this->isValid($info)) {
            $db = new ConnectDB();
            $db->conn();
            $service = new commentService();
            if ($service->addComment($db, $info)) {
                $db->commit();
                echo $_SESSION['cdcomment_0000'];
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
        if ($util->isEmpty($info[s_comment])) {
            $return2099 = eregi_replace("field", $_SESSION['btn_addComment'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
