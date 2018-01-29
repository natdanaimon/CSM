<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new createController();
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
}

class createController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/po/createServiceOther.php';
    }

    public function dataTable() {
        $service = new createService();
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
        $service = new createService();
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

    public function delete($seq) {
        $db = new ConnectDB();
        $db->conn();
        $service = new createService();
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
            $service = new createService();
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
        $service = new createService();
        $util = new Utility();
        $_dataTable = $service->getInfo($seq);
        if ($_dataTable != NULL) {
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['d_other_order'] = $util->DateSql2d_dmm_yyyy($_dataTable[$key]['d_other_order']);
                
            }
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {

            $db = new ConnectDB();
            $db->conn();
            $service = new createService();
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
            $db = new ConnectDB();
            $db->conn();
            $service = new createService();


            if ($service->edit($db, $info)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
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
        if ($util->isEmpty($info[s_po_other_ref])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_refno'], $return2099);
            echo $return2099;
        }  else if ($util->isEmpty($info[d_other_order])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_orderdate'], $return2099);
            echo $return2099;

        } else if ($util->isEmpty($info[s_po_other_order])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_order'], $return2099);
            echo $return2099;
        } 
        else if ($util->isEmpty($info[i_other_shop])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_shop'], $return2099);
            echo $return2099;
        } 
        else if ($util->isEmpty($info[i_other_price])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_price'], $return2099);
            echo $return2099;
        }
        else if ($util->isEmpty($info[i_other_amount])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_amount'], $return2099);
            echo $return2099;
        }
        else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
