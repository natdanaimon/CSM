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
    case "addTapping":
        echo $controller->addTapping($info);
        break;
    case "iniTapping":
        echo $controller->iniTapping($info);
        break;
    case "delTapping":
        echo $controller->delTapping($info);
        break;
    case "addFilling":
        echo $controller->addFilling($info);
        break;
    case "iniFilling":
        echo $controller->iniFilling($info);
        break;
    case "delFilling":
        echo $controller->delFilling($info);
        break;
    case "addSpraying":
        echo $controller->addSpraying($info);
        break;
    case "iniSpraying":
        echo $controller->iniSpraying($info);
        break;
    case "delSpraying":
        echo $controller->delSpraying($info);
        break;
    case "addPrepare":
        echo $controller->addPrepare($info);
        break;
    case "iniPrepare":
        echo $controller->iniPrepare($info);
        break;
    case "delPrepare":
        echo $controller->delPrepare($info);
        break;
    case "addPolishing":
        echo $controller->addPolishing($info);
        break;
    case "iniPolishing":
        echo $controller->iniPolishing($info);
        break;
    case "delPolishing":
        echo $controller->delPolishing($info);
        break;
    case "addCheck":
        echo $controller->addCheck($info);
        break;
    case "iniCheck":
        echo $controller->iniCheck($info);
        break;
    case "delCheck":
        echo $controller->delCheck($info);
        break;
    case "listImage":
        echo $controller->listImage($info);
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

    public function listImage($info) {
        $service = new processService();
        $util = new Utility();
        $db = new ConnectDB();
        $_dataTable = $service->listImage($db,$info);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
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
                    if ($service->addDropzone('tb_img_dismantling', $db, $info, $_FILES['file']['name'])) {
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
        if ($service->delDropzone('tb_img_dismantling', $db, $info)) {
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

    public function addTapping($info) {
        $code = '';
        $name = '';
        $error = $_SESSION['cd_2001'];
        $size = 0;
        $result = array();
        $doc = new upload();
        $doc->set_path("../../upload/step_tapping/" . $info[ref_no] . "/");
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
                    if ($service->addDropzone('tb_img_tapping', $db, $info, $_FILES['file']['name'])) {
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

    public function delTapping($info) {
        $service = new processService();
        $db = new ConnectDB();
        $db->conn();

        $doc = new upload();
        $doc->set_path("../../upload/step_tapping/" . $info[ref_no] . "/");
        $doc->add_FileName($info[filename]);
        if ($service->delDropzone('tb_img_tapping', $db, $info)) {
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

    public function iniTapping($info) {
        $storeFolder = "../../upload/step_tapping/" . $info[ref_no] . "/";
        $result = array();
        $service = new processService();
        $files = $service->initialDropzone('tb_img_tapping', $info[ref_no]);
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

    public function addFilling($info) {
        $code = '';
        $name = '';
        $error = $_SESSION['cd_2001'];
        $size = 0;
        $result = array();
        $doc = new upload();
        $doc->set_path("../../upload/step_filling/" . $info[ref_no] . "/");
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
                    if ($service->addDropzone('tb_img_filling', $db, $info, $_FILES['file']['name'])) {
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

    public function delFilling($info) {
        $service = new processService();
        $db = new ConnectDB();
        $db->conn();

        $doc = new upload();
        $doc->set_path("../../upload/step_filling/" . $info[ref_no] . "/");
        $doc->add_FileName($info[filename]);
        if ($service->delDropzone('tb_img_filling', $db, $info)) {
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

    public function iniFilling($info) {
        $storeFolder = "../../upload/step_filling/" . $info[ref_no] . "/";
        $result = array();
        $service = new processService();
        $files = $service->initialDropzone('tb_img_filling', $info[ref_no]);
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

    public function addSpraying($info) {
        $code = '';
        $name = '';
        $error = $_SESSION['cd_2001'];
        $size = 0;
        $result = array();
        $doc = new upload();
        $doc->set_path("../../upload/step_spraying/" . $info[ref_no] . "/");
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
                    if ($service->addDropzone('tb_img_spraying', $db, $info, $_FILES['file']['name'])) {
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

    public function delSpraying($info) {
        $service = new processService();
        $db = new ConnectDB();
        $db->conn();

        $doc = new upload();
        $doc->set_path("../../upload/step_spraying/" . $info[ref_no] . "/");
        $doc->add_FileName($info[filename]);
        if ($service->delDropzone('tb_img_spraying', $db, $info)) {
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

    public function iniSpraying($info) {
        $storeFolder = "../../upload/step_spraying/" . $info[ref_no] . "/";
        $result = array();
        $service = new processService();
        $files = $service->initialDropzone('tb_img_spraying', $info[ref_no]);
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

    public function addPrepare($info) {
        $code = '';
        $name = '';
        $error = $_SESSION['cd_2001'];
        $size = 0;
        $result = array();
        $doc = new upload();
        $doc->set_path("../../upload/step_prepare/" . $info[ref_no] . "/");
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
                    if ($service->addDropzone('tb_img_prepare', $db, $info, $_FILES['file']['name'])) {
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

    public function delPrepare($info) {
        $service = new processService();
        $db = new ConnectDB();
        $db->conn();

        $doc = new upload();
        $doc->set_path("../../upload/step_prepare/" . $info[ref_no] . "/");
        $doc->add_FileName($info[filename]);
        if ($service->delDropzone('tb_img_prepare', $db, $info)) {
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

    public function iniPrepare($info) {
        $storeFolder = "../../upload/step_prepare/" . $info[ref_no] . "/";
        $result = array();
        $service = new processService();
        $files = $service->initialDropzone('tb_img_prepare', $info[ref_no]);
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

    public function addPolishing($info) {
        $code = '';
        $name = '';
        $error = $_SESSION['cd_2001'];
        $size = 0;
        $result = array();
        $doc = new upload();
        $doc->set_path("../../upload/step_polishing/" . $info[ref_no] . "/");
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
                    if ($service->addDropzone('tb_img_polishing', $db, $info, $_FILES['file']['name'])) {
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

    public function delPolishing($info) {
        $service = new processService();
        $db = new ConnectDB();
        $db->conn();

        $doc = new upload();
        $doc->set_path("../../upload/step_polishing/" . $info[ref_no] . "/");
        $doc->add_FileName($info[filename]);
        if ($service->delDropzone('tb_img_polishing', $db, $info)) {
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

    public function iniPolishing($info) {
        $storeFolder = "../../upload/step_polishing/" . $info[ref_no] . "/";
        $result = array();
        $service = new processService();
        $files = $service->initialDropzone('tb_img_polishing', $info[ref_no]);
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

    public function addCheck($info) {
        $code = '';
        $name = '';
        $error = $_SESSION['cd_2001'];
        $size = 0;
        $result = array();
        $doc = new upload();
        $doc->set_path("../../upload/step_check/" . $info[ref_no] . "/");
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
                    if ($service->addDropzone('tb_img_check', $db, $info, $_FILES['file']['name'])) {
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

    public function delCheck($info) {
        $service = new processService();
        $db = new ConnectDB();
        $db->conn();

        $doc = new upload();
        $doc->set_path("../../upload/step_check/" . $info[ref_no] . "/");
        $doc->add_FileName($info[filename]);
        if ($service->delDropzone('tb_img_check', $db, $info)) {
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

    public function iniCheck($info) {
        $storeFolder = "../../upload/step_check/" . $info[ref_no] . "/";
        $result = array();
        $service = new processService();
        $files = $service->initialDropzone('tb_img_check', $info[ref_no]);
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
                $_dataTable[$key]['i_brand'] = $service->getBrand($_dataTable[$key]['s_brand_code']);
                $_dataTable[$key]['i_gen'] = $service->getGeneration($_dataTable[$key]['s_gen_code']);
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
                 $_dataTable[$key]['i_brand'] = $service->getBrand($_dataTable[$key]['s_brand_code']);
                $_dataTable[$key]['i_gen'] = $service->getGeneration($_dataTable[$key]['s_gen_code']);
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

        $service = new processService();
        $db = new ConnectDB();
        $db->conn();
        if ($service->edit($db, $info)) {
            $db->commit();
            echo $_SESSION['cd_0000'];
        } else {
            $db->rollback();
            echo $_SESSION['cd_2001'];
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
