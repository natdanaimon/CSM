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

if (count($info) == 0) {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}

$controller = new processController();
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
    case "dataTableKey":
        echo $controller->dataTableKey($info[id]);
        break;
    case "getCheckBoxMain":
        echo $controller->getCheckBoxMain($info[ref_no]);
        break;
    case "getCheckBoxOther":
        echo $controller->getCheckBoxOther($info[ref_no]);
        break;
    case "addDismantling":
        echo $controller->addDismantling($info);
        break;
    case "iniDismantling":
        echo $controller->iniDismantling($info);
        break;
    case "delDismantling":
        echo $controller->delDismantling($info);
        break;
}

class processController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/repair/processService.php';
    }

    public function addDismantling($info) {
        $code = '';
        $name = '';
        $error = $_SESSION['cd_2001'];
        $size = 0;
        $result = array();
        $doc = new upload();
        $doc->set_path("../../upload/step_dismantling/" . $info[ref_no] . "/");
        $doc->setResize(TRUE);
        if (!empty($_FILES)) {
            
            if (file_exists($doc->get_path() . $_FILES['file']['name'])) {
                $error = $_SESSION['cd_2015'];
            } else {


                $filename = explode(".", $_FILES['file']['name']);
                $doc->add_FileNameCustom($_FILES['file'], $filename[0]);
                if (count($doc->get_FilenameCustom()) > 0) {
                    $db = new ConnectDB();
                    $db->conn();
                    $service = new processService();
                    if ($service->addDismantling($db, $info, $_FILES['file']['name'])) {
                        if ($doc->AddFileCustom()) {
                            $code = '0';
                            $name = $doc->get_FilenameCustomResult()[0];
                            $size = filesize($doc->get_path() . $_FILES['file']['name']);
                            $db->commit();
                            $error = $_SESSION['cd_0000'];
                        } else {
                            $db->rollback();
                            $doc->clearFileAddFailCustom();
                        }
                    } else {
                        $db->rollback();
                    }
                }
            }
        }
        $util = new Utility();
        $result = array(
            "code" => $code,
            "error" => $error,
            "name" => $name,
            "size" => $util->convertFileSize($size)
        );
        return json_encode($result);
    }

    public function delDismantling($info) {
        $service = new processService();
        $db = new ConnectDB();
        $db->conn();

        $doc = new upload();
        $doc->set_path("../../upload/step_dismantling/" . $info[ref_no] . "/");
        $doc->add_FileName($info[filename]);
        if ($service->delDismantling($db, $info)) {
            if ($doc->deleteFile()) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                $doc->clearFileAddFail();
                echo $_SESSION['cd_2001'];
            }
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
        }
    }

    public function iniDismantling($info) {
        $storeFolder = "../../upload/step_dismantling/" . $info[ref_no] . "/";
        $result = array();
        $service = new processService();
        $files = $service->initialDropzone('tb_img_dismantling', $info[ref_no]);
        if ($files != NULL) {
            foreach ($files as $key => $value) {
                $obj['name'] = $files[$key]['s_image'];
                $obj['size'] = filesize($storeFolder . $files[$key]['s_image']);
                $result[] = $obj;
            }
        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($result);
    }

    public function dataTable() {
        $service = new processService();
        $_dataTable = $service->dataTable();
        $util = new Utility();
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['i_year'] = $service->getYear($_dataTable[$key]['s_car_code']);
                $_dataTable[$key]['i_brand'] = $service->getBrand($_dataTable[$key]['s_car_code']);
                $_dataTable[$key]['i_gen'] = $service->getGeneration($_dataTable[$key]['s_car_code']);
                $_dataTable[$key]['i_sub'] = $service->getSub($_dataTable[$key]['s_car_code']);
                $_dataTable[$key]['i_ins_comp'] = $service->getInsurance($_dataTable[$key]['i_ins_comp']);
                $_dataTable[$key]['i_dmg'] = $service->getDamage($_dataTable[$key]['i_dmg']);

                $_dataTable[$key]['d_inbound'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_inbound']);
                $_dataTable[$key]['d_outbound_confirm'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_outbound_confirm']);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function dataTableKey($id) {
        $service = new processService();
        $_dataTable = $service->dataTableKey($id);
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['i_year'] = $service->getYear($_dataTable[$key]['s_car_code']);
                $_dataTable[$key]['i_brand'] = $service->getBrand($_dataTable[$key]['s_car_code']);
                $_dataTable[$key]['i_gen'] = $service->getGeneration($_dataTable[$key]['s_car_code']);
                $_dataTable[$key]['i_sub'] = $service->getSub($_dataTable[$key]['s_car_code']);
                $_dataTable[$key]['i_ins_comp'] = $service->getInsurance($_dataTable[$key]['i_ins_comp']);
                $_dataTable[$key]['i_dmg'] = $service->getDamage($_dataTable[$key]['i_dmg']);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function getCheckBoxMain($ref_no) {
        $service = new processService();
        $_dataTable = $service->getCheckBoxMain($ref_no);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function getCheckBoxOther($ref_no) {
        $service = new processService();
        $_dataTable = $service->getCheckBoxOther($ref_no);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function delete($seq) {
        $db = new ConnectDB();
        $db->conn();
        $service = new processService();
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
            $service = new processService();
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
        $service = new processService();
        $util = new Utility();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['d_ins_exp'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_ins_exp']);
                $_dataTable[$key]['d_inbound'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_inbound']);
                $_dataTable[$key]['d_outbound_confirm'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_outbound_confirm']);
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function edit($info) {
        if ($this->isValid($info)) {
            $service = new processService();
            $db = new ConnectDB();
            $db->conn();
            $doc = new upload();
            $doc->set_path("../../upload/step_checkrepair/");
            $doc->setResize(TRUE);

            $doc2 = new upload();
            $doc2->set_path("../../upload/step_checkrepair_other/");
            $doc2->setResize(TRUE);

            $flgValid = TRUE;
            $arrOld = array();
            $arrOld2 = array();




            $listRepairActive = $service->getListRepairActive($db);
            if ($listRepairActive != NULL) {
                foreach ($listRepairActive as $key => $value) {
                    $keyDB = $listRepairActive[$key]['i_repair_item'];
                    $keyInputCheckbox = 'i_repair_item_' . $keyDB;
                    $keyInputFile = 'file_' . $keyDB;
                    $keyInputRemark = 's_repair_item_' . $keyDB;
                    $keyckOld = 'ck_' . $keyDB;
                    $valckOld = $info[$keyckOld];
                    if ($info[$keyInputCheckbox] != NULL && $info[$keyInputCheckbox] != '') {
                        if ($_FILES[$keyInputFile]["error"] == 4 && $valckOld == '') {
                            $flgValid = FALSE;
                            echo $_SESSION['cd_2207'];
                            break;
                        } else {
                            if ($valckOld == '') {
                                $doc->add_FileNameCustom($_FILES[$keyInputFile], $info[ref_no] . '_' . $keyDB);
                            } else {
                                array_push($arrOld, $keyDB);
                            }
                        }
                    }
                }
            }


            for ($i = 1; $i < 14; $i++) {
                $keyDB = $i;
                $keyInputCheckbox = 'i_repair_subitem_' . $keyDB;
                $keyInputFile = 'files_' . $keyDB;
                $keyInputRemark = 's_repair_subitem_' . $keyDB;
                $keyckOld = 'cks_' . $keyDB;
                $valckOld = $info[$keyckOld];
                if ($info[$keyInputCheckbox] != NULL && $info[$keyInputCheckbox] != '') {
                    if ($_FILES[$keyInputFile]["error"] == 4 && $valckOld == '') {
                        $flgValid = FALSE;
                        echo $_SESSION['cd_2207'];
                        break;
                    } else {
                        if ($valckOld == '') {
                            $doc2->add_FileNameCustom($_FILES[$keyInputFile], $info[ref_no] . '_' . $keyDB);
                        }
                    }
                }
            }




            if ($flgValid) {

                if (count($doc->get_FilenameCustom()) > 0) {
                    if ($doc->AddFileCustom()) {

                        if (count($doc2->get_FilenameCustom()) > 0) {
                            if ($doc2->AddFileCustom()) {
                                if ($service->edit($db, $info, $arrOld)) {
                                    $db->commit();
                                    echo $_SESSION['cd_0000'];
                                } else {
                                    $db->rollback();
                                    $doc->clearFileAddFailCustom();
                                    $doc2->clearFileAddFailCustom();
                                    echo $_SESSION['cd_2001'];
                                }
                            } else {
                                echo $doc2->get_errorMessage();
                            }
                        } else {
                            if ($service->edit($db, $info, $arrOld)) {
                                $db->commit();
                                echo $_SESSION['cd_0000'];
                            } else {
                                $db->rollback();
                                $doc->clearFileAddFailCustom();
                                echo $_SESSION['cd_2001'];
                            }
                        }
                    } else {
                        echo $doc->get_errorMessage();
                    }
                } else {


                    if (count($doc2->get_FilenameCustom()) > 0) {
                        if ($doc2->AddFileCustom()) {
                            if ($service->edit($db, $info, $arrOld)) {
                                $db->commit();
                                echo $_SESSION['cd_0000'];
                            } else {
                                $db->rollback();
                                $doc2->clearFileAddFailCustom();
                                echo $_SESSION['cd_2001'];
                            }
                        } else {
                            echo $doc2->get_errorMessage();
                        }
                    } else {
                        if ($service->edit($db, $info, $arrOld)) {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                        } else {
                            $db->rollback();
                            echo $_SESSION['cd_2001'];
                        }
                    }
                }
            }
            // delete file temp
            $this->deleteTempFile($db);
            // delete file temp
        }
    }

    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $return2097 = $_SESSION['cd_2097'];
        $util = new Utility();
        if ($util->isEmpty($info[i_dmg])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_re_dmg'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[status])) {
            $return2099 = eregi_replace("field", $_SESSION['label_status'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

    public function deleteTempFile($db) {
        $temp = new upload();
        $svTemp = new processService();
        $temp->set_path("../../upload/step_checkrepair/");
        $_dataTemp = $svTemp->getInfoFile($db);
        foreach ($_dataTemp as $key => $value) {
            if ($_dataTemp[$key]['img'] != "") {
                $temp->add_FileName($_dataTemp[$key]['img']);
            }
        }
        $temp->deleteFileNoTemp();
    }

}
