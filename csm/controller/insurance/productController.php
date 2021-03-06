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
            foreach ($_dataTable as $key => $value) {
                $_dataTable[$key]['s_cartype'] = $service->searchCar($_dataTable[$key]['i_year'], $_dataTable[$key]['s_brand_code'], $_dataTable[$key]['s_gen_code']);
            }
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
        $_carYear = $prd->MsCarYear(); // ข้อมูลรถ
        $_carBrand = $prd->MsCarBrand(); // ข้อมูลรถ
        $_carGen = $prd->MsCarGen(); // ข้อมูลรถ
        $_promotion = $prd->MsInsurancePromotion(); //โปรโมชั่น
        $_repair = $prd->MsInsuranceRepair(); //ประเภทการซ่อม
        $_compu = $prd->MsCompulsory(); //ประเภทประกันภัยภาคบังคับ
        $_status = $prd->MsStatus(); //ประเภทประกันภัยภาคบังคับ

        $html = "";


        $head = array();
        $head[0] = "บริษัทประกันภัย";
        $head[1] = "ประเภทประกันภัย";
        $head[2] = "ข้อมูลรถ ปี";
        $head[3] = "ข้อมูลรถ แบรนด์";
        $head[4] = "ข้อมูลรถ รุ่น";
        $head[5] = "โปรโมชั่น";
        $head[6] = "ประเภทการซ่อม";
        $head[7] = "ประเภทประกันภัยภาคบังคับ";
        $head[8] = "ประเภทสถานะ";

        $_data = array();
        $_data[0] = $_comp;
        $_data[1] = $_insType;
        $_data[2] = $_carYear;
        $_data[3] = $_carBrand;
        $_data[4] = $_carGen;
        $_data[5] = $_promotion;
        $_data[6] = $_repair;
        $_data[7] = $_compu;
        $_data[8] = $_status;
        $html .= $this->getTableExcel($head, $_data);




        return $html;
    }

    public function getTableExcel($head, $_data) {
        $comp = $_data[0];
        $insType = $_data[1];
        $carYear = $_data[2];
        $carBrand = $_data[3];
        $carGen = $_data[4];
        $promotion = $_data[5];
        $repair = $_data[6];
        $compu = $_data[7];
        $status = $_data[8];

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
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[5]</th>";
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
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[6]</th>";
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


        $table .= "<td>&nbsp;</td>";


        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[7]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>VALUE</th>";
        $table .= "</tr>";

        foreach ($compu as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $compu[$key]['i_compu'] . "</td>";
            $table .= "<td>" . $compu[$key]['s_name'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";


        $table .= "<td>&nbsp;</td>";


        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[8]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>VALUE</th>";
        $table .= "</tr>";

        foreach ($status as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $status[$key]['s_status'] . "</td>";
            $table .= "<td>" . $status[$key]['s_detail_th'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";

        $table .= "<td>&nbsp;</td>";

        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '2' style='background:#f5f5f0;'>$head[2]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>YEAR</th>";
        $table .= "</tr>";

        foreach ($carYear as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $carYear[$key]['i_year'] . "</td>";
            $table .= "<td>" . $carYear[$key]['i_year'] . "</td>";
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
        $table .= "<th style='background:#e0e0d1;'>BRAND</th>";
        $table .= "</tr>";

        foreach ($carBrand as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $carBrand[$key]['s_brand_code'] . "</td>";
            $table .= "<td>" . $carBrand[$key]['s_brand_name'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";


        $table .= "<td>&nbsp;</td>";

        $table .= "<td>";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '3' style='background:#f5f5f0;'>$head[4]</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:yellow;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>BRAND</th>";
        $table .= "<th style='background:#e0e0d1;'>GEN</th>";
        $table .= "</tr>";

        foreach ($carGen as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $carGen[$key]['s_gen_code'] . "</td>";
            $table .= "<td>" . $carGen[$key]['s_brand_name'] . "</td>";
            $table .= "<td>" . $carGen[$key]['s_gen_name'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";


        $table .= "<td>&nbsp;</td>";


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
        $intReturn2 = TRUE;
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
//        } else if ($util->isEmpty($info[s_car_code])) {
//            $return2099 = eregi_replace("field", $_SESSION['lb_setIns_code'], $return2099);
//            echo $return2099;
        } else if ($util->isEmpty($info[i_year])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setYear_year'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_brand_code])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setBrand_code'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_gen_code])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setGen_code'], $return2099);
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

        if ($intReturn) {
            if (!$util->isEmpty($info[s_prother_1_txt]) || !$util->isEmpty($info[s_prother_1_val])) {
                if (!is_numeric($info[s_prother_1_val])) {
                    $intReturn2 = FALSE;
                    $return2003 = eregi_replace("field", $_SESSION['lb_setIns_d_1'], $return2003);
                    echo $return2003;
                } else if ($util->isEmpty($info[s_prother_1_txt])) {
                    $intReturn2 = FALSE;
                    $return2099 = eregi_replace("field", $_SESSION['lb_setIns_h_1'], $return2099);
                    echo $return2099;
                }
            }
            if ((!$util->isEmpty($info[s_prother_2_txt]) || !$util->isEmpty($info[s_prother_2_val]) && $intReturn2)) {
                if (!is_numeric($info[s_prother_2_val])) {
                    $intReturn2 = FALSE;
                    $return2003 = eregi_replace("field", $_SESSION['lb_setIns_d_2'], $return2003);
                    echo $return2003;
                } else if ($util->isEmpty($info[s_prother_2_txt])) {
                    $intReturn2 = FALSE;
                    $return2099 = eregi_replace("field", $_SESSION['lb_setIns_h_2'], $return2099);
                    echo $return2099;
                }
            }
            if ((!$util->isEmpty($info[s_prother_3_txt]) || !$util->isEmpty($info[s_prother_3_val]) && $intReturn2)) {
                if (!is_numeric($info[s_prother_3_val])) {
                    $intReturn2 = FALSE;
                    $return2003 = eregi_replace("field", $_SESSION['lb_setIns_d_3'], $return2003);
                    echo $return2003;
                } else if ($util->isEmpty($info[s_prother_3_txt])) {
                    $intReturn2 = FALSE;
                    $return2099 = eregi_replace("field", $_SESSION['lb_setIns_h_3'], $return2099);
                    echo $return2099;
                }
            }
        }


        return (($intReturn && $intReturn2) ? TRUE : FALSE);
    }

}
