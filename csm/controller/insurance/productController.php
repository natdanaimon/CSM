<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new productController();
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
    case "import":
        echo $controller->import($info);
        break;
    case "export":
        echo $controller->export($info);
        break;
}

class productController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../common/excel.php';
        include '../../service/insurance/productService.php';
    }

    public function dataTable() {
        $service = new productService();
        $_dataTable = $service->dataTable();
        if ($_dataTable != NULL) {
            return json_encode($_dataTable);
        } else {
            return NULL;
        }
    }

    public function import($info) {

        if ($this->isValidImport($info)) {
            $db = new ConnectDB();
            $db->conn();
            $service = new productService();
            if ($service->import($db, $_FILES["file"])) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function export() {
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="MasterDataInsurance.xls"');

        $prd = new productService();
        $_comp = $prd->MsInsurance(); // บริษัทประกันภัย
        $_insType = $prd->MsInsuranceType(); //ประเภทประกันภัย
        $_car = $prd->MsCar(); // ข้อมูลรถ
        $_promotion = $prd->MsInsurancePromotion(); //โปรโมชั่น
        $_repair = $prd->MsInsuranceRepair(); //ประเภทการซ่อม


        $html = "";


        $head = array();
        $head[0] = "บริษัทประกันภัย";
        $head[1] = "ประเภทประกันภัย";
        $head[2] = "ข้อมูลรถ";
        $head[3] = "โปรโมชั่น";
        $head[4] = "ประเภทการซ่อม";

        $_data = array();
        $_data[0] = $_comp;
        $_data[1] = $_insType;
        $_data[2] = $_car;
        $_data[3] = $_promotion;
        $_data[4] = $_repair;
        $html .= $this->getTableExcel($head, $_data);




        return $html;
    }

    public function getTableExcel($head, $_data) {
        $comp = $_data[0];
        $insType = $_data[1];
        $car = $_data[2];
        $promotion = $_data[3];
        $repair = $_data[4];



        $table = "";

        $table .= "<table border='0'>";
        $table .= "<tr>";


        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[0]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>VALUE</th>";
        $table .= "</tr>";

        foreach ($comp as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $comp[$key]['i_ins_comp'] . "</td>";
            $table .= "<td>" . $comp[$key]['s_comp_th'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";

        $table .= "<td>&nbsp;</td>";


        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[1]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>VALUE</th>";
        $table .= "</tr>";

        foreach ($insType as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $insType[$key]['i_ins_type'] . "</td>";
            $table .= "<td>" . $insType[$key]['s_name'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";


        $table .= "<td>&nbsp;</td>";


        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '5' style='background:#f5f5f0;'>$head[2]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>BRAND</th>";
        $table .= "<th style='background:#e0e0d1;'>YEAR</th>";
        $table .= "<th style='background:#e0e0d1;'>GENERATION</th>";
        $table .= "<th style='background:#e0e0d1;'>SUB GENERATION</th>";
        $table .= "</tr>";

        foreach ($car as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $car[$key]['s_code'] . "</td>";
            $table .= "<td>" . $car[$key]['s_brand_name'] . "</td>";
            $table .= "<td>" . $car[$key]['i_year'] . "</td>";
            $table .= "<td>" . $car[$key]['s_gen_name'] . "</td>";
            $table .= "<td>" . $car[$key]['s_sub_name'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";


        $table .= "<td>&nbsp;</td>";


        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[3]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>VALUE</th>";
        $table .= "</tr>";

        foreach ($promotion as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $promotion[$key]['i_ins_promotion'] . "</td>";
            $table .= "<td>" . $promotion[$key]['s_promotion'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";


        $table .= "<td>&nbsp;</td>";


        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[4]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>VALUE</th>";
        $table .= "</tr>";

        foreach ($repair as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $repair[$key]['i_repair'] . "</td>";
            $table .= "<td>" . $repair[$key]['s_name'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";




        $table .= "</tr>";
        $table .= "</table>";
        return $table;
    }


    public function isValidImport($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $util = new Utility();
        if (($_FILES["file"]["error"] == 4 || $_FILES["file"] == NULL)) {
            echo $_SESSION['cd_2214'];
        } else if (!$this->typeFile($_FILES["file"]["name"])) {
            echo $_SESSION['cd_2012'];
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

    function typeFile($filename) {
        $arrFile = explode(".", $filename);
        $cnt = count($arrFile);
        if ($cnt > 1) {
            if ($arrFile[$cnt - 1] == "xlsx") {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function delete($seq) {
        $db = new ConnectDB();
        $db->conn();
        $service = new productService();
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
            $service = new productService();
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
        $service = new productService();
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
            $service = new productService();
            if ($service->edit($db, $info)) {
                $db->commit();
                echo $_SESSION['cd_0000'];
            } else {
                $db->rollback();
                echo $_SESSION['cd_2001'];
            }
        }
    }

    public function add($info) {
        if ($this->isValid($info)) {
            $db = new ConnectDB();
            $db->conn();
            $service = new productService();

            if ($service->add($db, $info)) {
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
        if ($util->isEmpty($info[s_insurance_htext])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_htext'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[i_ins_comp])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_comp'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_car_code])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_code'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[i_ins_promotion])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_promotion'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[f_price])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_price'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[f_price])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_price'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[f_discount])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_discount'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[f_discount])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_discount'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[f_point])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_point'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[f_point])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_point'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prcar_base])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_base'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prcar_base])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_base'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prcar_fire])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_fire'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prcar_fire])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_fire'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prcar_water])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_water'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prcar_water])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_water'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prcar_repair])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_repair'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prcar_repair])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_repair'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prperson_per])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_per'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prperson_per])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_per'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prperson_pertimes])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_pertimes'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prperson_pertimes])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_pertimes'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prperson_outsider])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_outside'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prperson_outsider])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_outside'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prother_personal])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_personal'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prother_personal])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_personal'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prother_insurance])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_insurance'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prother_insurance])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_insurance'], $return2003);
            echo $return2003;
        } else if ($util->isEmpty($info[s_prother_medical])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_medical'], $return2099);
            echo $return2099;
        } else if (!is_numeric($info[s_prother_medical])) {
            $return2003 = eregi_replace("field", $_SESSION['lb_setIns_medical'], $return2003);
            echo $return2003;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
