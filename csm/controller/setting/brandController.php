<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new brandController();
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

class brandController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/setting/brandService.php';
    }

    public function dataTable() {
        $service = new brandService();
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
        $service = new brandService();

        // delete file temp
        $this->deleteTempFile($db);
        // delete file temp

        $arr_img = $service->SelectById($db, $seq);
        if ($service->delete($db, $seq)) {
            $upload = new upload();
            $upload->Initial_and_Clear();
            $upload->set_path("../../upload/brand/");
            foreach ($arr_img as $key => $value) {
                if ($arr_img[$key]['s_image'] != NULL && $arr_img[$key]['s_image'] != "") {
                    $upload->add_FileName($arr_img[$key]['s_image']);
                }
            }

            if (count($upload->get_Filename()) > 0) {
                if ($upload->deleteFile()) {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            } else {
                $db->commit();
                echo $_SESSION['cd_0000'];
            }
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
            $service = new brandService();
            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp
            $query = $util->arr2strQuery($info[data], "I");
            $arr_img = $service->SelectByArray($db, $query);
            if ($service->deleteAll($db, $query)) {
                $upload = new upload();
                $upload->Initial_and_Clear();
                $upload->set_path("../../upload/brand/");
                foreach ($arr_img as $key => $value) {
                    if ($arr_img[$key]['s_image'] != NULL && $arr_img[$key]['s_image'] != "") {
                        $upload->add_FileName($arr_img[$key]['s_image']);
                    }
                }
                if (count($upload->get_Filename()) > 0) {
                    if ($upload->deleteFile()) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                }
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function getInfo($seq) {
        $service = new brandService();
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
            $service = new brandService();
            $doc = new upload();
            $doc->set_path("../../upload/brand/");

            if ($service->isDupplicate($db, $info)) {
                echo $_SESSION[cd_2011];
                return;
            }


            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp

            if ($_FILES["s_image"]["error"] == 0) {
                $doc->add_FileName($_FILES["s_image"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();
                    if ($service->edit($db, $info, $tmpDoc[0])) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        $doc->clearFileAddFail();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    echo $doc->get_errorMessage();
                }
            } else if ($_FILES["s_image"]["error"] == 4) {
                if ($service->edit($db, $info, $info[tmp_image])) {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    $doc->clearFileAddFail();
                    echo $_SESSION['cd_2001'];
                }
            }
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {
            $doc = new upload();
            $doc->set_path("../../upload/brand/");
            $db = new ConnectDB();
            $db->conn();
            $service = new brandService();

            if ($service->isDupplicate($db, $info)) {
                echo $_SESSION[cd_2011];
                return;
            }

            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp
            if ($_FILES["s_image"][error] == 0) {
                $doc->add_FileName($_FILES["s_image"]);
                $flg = $doc->AddFile();
                if ($flg) {
                    $tmpDoc = $doc->get_FilenameResult();
                    if ($service->add($db, $info, $tmpDoc[0])) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        $doc->clearFileAddFail();
                        echo $_SESSION['cd_2001'];
                    }
                } else {
                    echo $doc->get_errorMessage();
                }
            } else {
                if ($service->add($db, $info, NULL)) {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            }
        }
    }

    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $util = new Utility();

        if ($util->isEmpty($info[s_brand_name])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setBrand_name'], $return2099);
            echo $return2099;
//        } else if (($_FILES["s_image"]["error"] == 4 || $_FILES["s_image"] == NULL ) && $info[func] == "add") {
//            echo $_SESSION['cd_2207'];
        } else {
            $intReturn = TRUE;
        }

        return $intReturn;
    }

    public function deleteTempFile($db) {
        $temp = new upload();
        $svTemp = new brandService();
        $temp->set_path("../../upload/brand/");
        $_dataTemp = $svTemp->getInfoFile($db);
        foreach ($_dataTemp as $key => $value) {
            if ($_dataTemp[$key]['s_image'] != "") {
                $temp->add_FileName($_dataTemp[$key]['s_image']);
            }
        }
        $temp->deleteFileNoTemp();
    }

}
