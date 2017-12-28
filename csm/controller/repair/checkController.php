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


$controller = new checkController();
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
}

class checkController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/repair/checkService.php';
    }

    public function dataTable() {
        $service = new checkService();
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
        $service = new checkService();
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
        $service = new checkService();
        $_dataTable = $service->getCheckBoxMain($ref_no);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function getCheckBoxOther($ref_no) {
        $service = new checkService();
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
        $service = new checkService();
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
            $service = new checkService();
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
        $service = new checkService();
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

//    public function add($info) {
//        if ($this->isValid($info)) {
//
//            $db = new ConnectDB();
//            $db->conn();
//            $service = new checkService();
//            if ($service->add($db, $info)) {
//                $db->commit();
//                echo $_SESSION['cd_0000'];
//            } else {
//                $db->rollback();
//                echo $_SESSION['cd_2001'];
//            }
//        }
//    }

    public function edit($info) {
        if ($this->isValid($info)) {
            $service = new checkService();
            $db = new ConnectDB();
            $db->conn();
            $doc = new upload();
            $doc->set_path("../../upload/step_checkrepair/");
            $doc->setResize(TRUE);
            $flgValid = TRUE;

            // delete file temp
            //$this->deleteTempFile($db);
            // delete file temp



            $listRepairActive = $service->getListRepairActive($db);
            if ($listRepairActive != NULL) {
                foreach ($listRepairActive as $key => $value) {
                    $keyDB = $listRepairActive[$key]['i_repair_item'];
                    $keyInputCheckbox = 'i_repair_item_' . $keyDB;
                    $keyInputFile = 'file_' . $keyDB;
                    $keyInputRemark = 's_repair_item_' . $keyDB;

                    if ($info[$keyInputCheckbox] != NULL && $info[$keyInputCheckbox] != '') {
                        if ($_FILES[$keyInputFile]["error"] == 4) {
                            $flgValid = FALSE;
                            echo $_SESSION['cd_2207'];
                            break;
                        } else {
                            $doc->add_FileNameCustom($_FILES[$keyInputFile], $info[ref_no] . '_' . $keyDB);
                        }
                    }
                }
            }


            if ($flgValid) {

                if (count($doc->get_FilenameCustom()) > 0) {
                    if ($doc->AddFileCustom()) {
                        if ($service->edit($db, $info)) {
                            $db->commit();
                            echo $_SESSION['cd_0000'];
                        } else {
                            $db->rollback();
                            $doc->clearFileAddFailCustom();
                            echo $_SESSION['cd_2001'];
                        }
                    } else {
                        echo $doc->get_errorMessage();
                    }
                } else {
                    if ($service->edit($db, $info)) {
                        $db->commit();
                        echo $_SESSION['cd_0000'];
                    } else {
                        $db->rollback();
                        echo $_SESSION['cd_2001'];
                    }
                }
            }
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
        $svTemp = new checkService();
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
