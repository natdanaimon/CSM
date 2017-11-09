<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}


$controller = new mappingController();
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

class mappingController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../common/excel.php';
        include '../../service/setting/mappingService.php';
    }

    public function dataTable() {
        $service = new mappingService();
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
            $service = new mappingService();
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
        header('Content-Disposition: attachment; filename="MasterData.xls"');
        include '../../service/setting/yearService.php';
        include '../../service/setting/brandService.php';
        include '../../service/setting/generationService.php';
        include '../../service/setting/subService.php';

        $year = new yearService();
        $brand = new brandService();
        $gen = new generationService();
        $sub = new subService();

        $_year = $year->dataTableEx();
        $_brand = $brand->dataTableEx();
        $_gen = $gen->dataTableEx();
        $_sub = $sub->dataTableEx();

        $html = "";
//        $html .= $this->getTableExcel("MASTER CAR YEAR", $_year);
//        $html .= $this->getTableExcel("MASTER CAR BRAND", $_brand);
//        $html .= $this->getTableExcel("MASTER CAR GENERATION", $_gen);
//        $html .= $this->getTableExcel("MASTER CAR SUB", $_sub);

        $head = array();
        $head[0] = "MASTER CAR YEAR";
        $head[1] = "MASTER CAR BRAND";
        $head[2] = "MASTER CAR GENERATION";
        $head[3] = "MASTER CAR SUB";

        $_data = array();
        $_data[0] = $_year;
        $_data[1] = $_brand;
        $_data[2] = $_gen;
        $_data[3] = $_sub;
        $html .= $this->getTableExcel($head, $_data);




        return $html;
    }

    public function getTableExcel($head, $_data) {
        $years = $_data[0];
        $brands = $_data[1];
        $gens = $_data[2];
        $subs = $_data[3];




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

        foreach ($years as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $years[$key]['s_code'] . "</td>";
            $table .= "<td>" . $years[$key]['s_name'] . "</td>";
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

        foreach ($brands as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $brands[$key]['s_code'] . "</td>";
            $table .= "<td>" . $brands[$key]['s_name'] . "</td>";
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
        $table .= "<th style='background:#e0e0d1;'>VALUE</th>";
        $table .= "</tr>";

        foreach ($gens as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $gens[$key]['s_code'] . "</td>";
            $table .= "<td>" . $gens[$key]['s_name'] . "</td>";
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

        foreach ($subs as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $subs[$key]['s_code'] . "</td>";
            $table .= "<td>" . $subs[$key]['s_name'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table>";
        $table .= "</td>";







        $table .= "</tr>";
        $table .= "</table>";
        return $table;
    }

    public function getTableExcelBK($header, $_data) {
        $table = "";
        $table .= "<table border='1'>";
        $table .= "<tr>";
        $table .= "<th colspan = '2' style='background:#e0e0d1;'>$header</th>";
        $table .= "</tr>";
        $table .= "<tr>";
        $table .= "<th style='background:#e0e0d1;'>CODE</th>";
        $table .= "<th style='background:#e0e0d1;'>VALUE</th>";
        $table .= "</tr>";

        foreach ($_data as $key => $value) {
            $table .= "<tr>";
            $table .= "<td>" . $_data[$key]['s_code'] . "</td>";
            $table .= "<td>" . $_data[$key]['s_name'] . "</td>";
            $table .= "</tr>";
        }
        $table .= "</table><br/>";

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
        $service = new mappingService();
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
            $service = new mappingService();
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
        $service = new mappingService();
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
            $service = new mappingService();


            if ($service->isDupplicate($db, $info)) {
                echo $_SESSION[cd_2011];
                return;
            }
            if ($service->isDuppCarCode($db, $info)) {
                echo $_SESSION[cd_2014];
                return;
            }
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
            $service = new mappingService();
            if ($service->isDupplicate($db, $info)) {
                echo $_SESSION[cd_2011];
                return;
            }
            if ($service->isDuppCarCode($db, $info)) {
                echo $_SESSION[cd_2014];
                return;
            }
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
        if ($util->isEmpty($info[s_car_code])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setCar_code'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[i_year])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setYear_year'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_brand_code])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setBrand_code'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_gen_code])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setGen_name'], $return2099);
            echo $return2099;
        } else if ($util->isEmpty($info[s_sub_code])) {
            $return2099 = eregi_replace("field", $_SESSION['lb_setSub_code'], $return2099);
            echo $return2099;
        } else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }

}
