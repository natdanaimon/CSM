<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new slideController();
switch ($info[func]) {
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
    case "edit":
        echo $controller->edit($info);
        break;
    case "add":
        echo $controller->add($info);
        break;
}

class slideController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/ui/slideService.php';
    }

    public function dataTable() {
        $service = new slideService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function deleteNS($seq) {
        $db = new ConnectDB();
        $db->conn();
        $service = new slideService();

        // delete file temp
        $this->deleteTempFile($db);
        // delete file temp

        $arr_img = $service->SelectById($db, $seq);
        if ($service->delete($db, $seq)) {
            $upload = new upload();
            $upload->Initial_and_Clear();
            $upload->set_path("../../upload/slide/");
            foreach ($arr_img as $key => $value) {
                if ($arr_img[$key]['s_image'] != NULL && $arr_img[$key]['s_image'] != "") {
                    $upload->add_FileNameCustom($arr_img[$key]['s_image'],$key);
                }
            }

            if (count($upload->get_FilenameCustom()) > 0) {
                if ($upload->deleteFileCustom()) {
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
    
    
    public function delete($seq) {
        $db = new ConnectDB();
        $db->conn();
        $service = new slideService();

        // delete file temp
        $this->deleteTempFile($db);
        // delete file temp

        $arr_img = $service->SelectById($db, $seq);
        if ($service->delete($db, $seq)) {
            $upload = new upload();
            $upload->Initial_and_Clear();
            $upload->set_path("../../upload/slide/");
            foreach ($arr_img as $key => $value) {
                if ($arr_img[$key]['s_img_p1'] != NULL && $arr_img[$key]['s_img_p1'] != "") {
                    $upload->add_FileName($arr_img[$key]['s_img_p1']);
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
            $service = new slideService();
            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp
            $query = $util->arr2strQuery($info[data], "I");
            $arr_img = $service->SelectByArray($db, $query);
            if ($service->deleteAll($db, $query)) {
                $upload = new upload();
                $upload->Initial_and_Clear();
                $upload->set_path("../../upload/slide/");
                foreach ($arr_img as $key => $value) {
                    if ($arr_img[$key]['s_img_p1'] != NULL && $arr_img[$key]['s_img_p1'] != "") {
                        $upload->add_FileName($arr_img[$key]['s_img_p1']);
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
        $service = new slideService();
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
            $service = new slideService();
            $doc = new upload();
            $doc->set_path("../../upload/slide/");

            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp



            if ($_FILES["s_img_p1"]["error"] == 4) {
                if ($service->edit($db, $info, $info[tmp_img_p1])) {
                    $db->commit();
                    echo $_SESSION['cd_0000'];
                } else {
                    $db->rollback();
                    echo $_SESSION['cd_2001'];
                }
            } else if ($_FILES["s_img_p1"]["error"] == 0) {
                $doc->add_FileName($_FILES["s_img_p1"]);
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
            }
        }
    }
    
    public function add($info) {
        if ($this->isValid($info)) {
            $doc = new upload();
            $doc->set_path("../../upload/slide/");
//            $doc->setResize(TRUE);
            $db = new ConnectDB();
            $db->conn();
            $service = new slideService();

            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp



            $doc->add_FileName($_FILES["s_img_p1"]);
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
        }
    }
    public function addNS($info) {
        if ($this->isValid($info)) {
            $doc = new upload();
            $doc->set_path("../../upload/slide/");
//            $doc->setResize(TRUE);
            $db = new ConnectDB();
            $db->conn();
            $service = new slideService();

            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp



            $doc->add_FileNameCustom($_FILES["s_img_p1"],"abc");
            $flg = $doc->AddFileCustom();
            if ($flg) {
                $tmpDoc = $doc->get_FilenameCustomResult();
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
        }
    }

    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $util = new Utility();

        if ($util->isEmpty($info[s_desc_hl])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setSlide_hl'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_desc_nm])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setSlide_nm'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[i_index])) {
            $return2099 = eregi_replace("field", $_SESSION['index'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[i_index])) {
            $return2003 = eregi_replace("field", $_SESSION['index'], $return2003);
            echo $return2003;
        } else if (($_FILES["s_img_p1"]["error"] == 4 || $_FILES["s_img_p1"] == NULL) && $info[func] == "add") {
            echo $_SESSION['cd_2207'];
        } else {
            $intReturn = TRUE;
        }

        return $intReturn;
    }

    public function deleteTempFile($db) {
        $temp = new upload();
        $svTemp = new slideService();
        $temp->set_path("../../upload/slide/");
        $_dataTemp = $svTemp->getInfoFile($db);
        foreach ($_dataTemp as $key => $value) {
            if ($_dataTemp[$key]['img'] != "") {
                $temp->add_FileName($_dataTemp[$key]['img']);
            }
        }
        $temp->deleteFileNoTemp();
    }

}
