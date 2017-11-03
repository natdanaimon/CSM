<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new commonController();
switch ($info[func]) {
    case "DDLStatus":
        echo $controller->DDLStatus();
        break;
    case "DDLStatusActive":
        echo $controller->DDLStatusActive();
        break;
    case "DDLDepartment":
        echo $controller->DDLDepartment();
        break;
    case "ValidSecurity":
        echo $controller->ValidSecurity($info);
        break;
    case "DDLProvince":
        echo $controller->DDLProvince($info);
        break;
    case "DDLAmphure":
        echo $controller->DDLAmphure($info);
        break;
    case "DDLDistrict":
        echo $controller->DDLDistrict($info);
        break;
    case "DDLZipcode":
        echo $controller->DDLZipcode($info);
        break;
    case "DDLTitle":
        echo $controller->DDLTitle();
        break;
    case "DDLYear":
        echo $controller->DDLYear();
        break;
    case "DDLBrand":
        echo $controller->DDLBrand();
        break;
    case "DDLGeneration":
        echo $controller->DDLGeneration();
        break;
    case "DDLSub":
        echo $controller->DDLSub();
        break;
}

class commonController {

    public function __construct() {
        include '../common/ConnectDB.php';
        include '../common/Utility.php';
        include '../common/Logs.php';
        include '../common/upload.php';
        include '../service/commonService.php';
    }

    public function DDLStatus() {
        $service = new commonService();
        $_dataTable = $service->DDLStatus();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLStatusActive() {
        $service = new commonService();
        $_dataTable = $service->DDLStatusActive();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLDepartment() {
        $service = new commonService();
        $_dataTable = $service->DDLDepartment();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLProvince($info) {
        $service = new commonService();
        $_dataTable = $service->DDLProvince($info);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLAmphure($info) {
        $service = new commonService();
        $_dataTable = $service->DDLAmphure($info);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLDistrict($info) {
        $service = new commonService();
        $_dataTable = $service->DDLDistrict($info);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLZipcode($info) {
        $service = new commonService();
        $_dataTable = $service->DDLZipcode($info);
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLTitle() {
        $service = new commonService();
        $_dataTable = $service->DDLTitle();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function DDLYear() {
        $service = new commonService();
        $_dataTable = $service->DDLYear();
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['i_year'],
                    'text' => $_dataTable[$key]['i_year']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

    public function DDLBrand() {
        $service = new commonService();
        $_dataTable = $service->DDLBrand();
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['s_brand_code'],
                    'text' =>  $_dataTable[$key]['s_brand_name'],
                    'img' => $_dataTable[$key]['s_image']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

    public function DDLGeneration() {
        $service = new commonService();
        $_dataTable = $service->DDLGeneration();
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['s_gen_code'],
                    'text' => $_dataTable[$key]['s_gen_name']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

    public function DDLSub() {
        $service = new commonService();
        $_dataTable = $service->DDLSub();
        if ($_dataTable != NULL) {
            $tmpReturn = array();
            foreach ($_dataTable as $key => $value) {
                $tmp = array(
                    'id' => $_dataTable[$key]['s_sub_code'],
                    'text' => $_dataTable[$key]['s_sub_name']
                );
                $tmpReturn[] = $tmp;
            }

            return json_encode(array_values($tmpReturn));
        } else {
            return NULL;
        }
    }

}
