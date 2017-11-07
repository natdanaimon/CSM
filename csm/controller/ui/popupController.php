<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new popupController();
switch ($info[func]) {
    case "getInfo":
        echo $controller->getInfo();
        break;
    case "edit":
        echo $controller->edit($info);
        break;
}

class popupController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/ui/popupService.php';
    }

    public function getInfo() {
        $util = new Utility();
        $service = new popupService();
        $_dataTable = $service->getInfo();
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {

                $_dataTable[$key]['d_start'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_start']);
                $_dataTable[$key]['d_end'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_end']);
            }


            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {

            $service = new popupService();
            $db = new ConnectDB();
            $db->conn();
            $uC = new Utility();


            if ($_FILES["s_img_p1"]["error"] == 4 || $_FILES["s_img_p1"] == NULL) {
                $s = $uC->DateSQL($info[d_start]);
                $e = $uC->DateSQL($info[d_end]);
                if ($service->edit($db, $info[tmp_img_p1], $info, $s, $e)) {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            } else {
                $doc = new upload();
                $doc->set_path("../../upload/popup/");
                $doc->add_FileName($_FILES["s_img_p1"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();

                    $s = $uC->DateSQL($info[d_start]);
                    $e = $uC->DateSQL($info[d_end]);
                    if ($service->edit($db, $tmpDoc[0], $info, $s, $e)) {
                        $doc->Initial_and_Clear();
                        $doc->set_path("../../upload/popup/");
                        if ($info[tmp_img_p1] != "") {
                            $doc->add_FileName($info[tmp_img_p1]);
                            if ($doc->deleteFile()) {
                                $db->commit();
                                echo $_SESSION['cd_0000'];
                            } else {
                                $db->rollback();
                                $doc->clearFileAddFail();
                                echo $_SESSION['cd_2001'];
                            }
                        } else {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                        }
                    } else {
                        $doc->clearFileAddFail();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    $doc->clearFileAddFail();
                    echo $doc->get_errorMessage();
                }
            }
        }
    }

 

    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $util = new Utility();
        if ($util->isEmpty($info[s_url])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setPop_link'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }

        return $intReturn;
    }

}
