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
    case "add":
        echo $controller->add($info);
        break;
}

class createController {

    public function __construct() {
        include '../../common/ConnectDB.php';
        include '../../common/Utility.php';
        include '../../common/Logs.php';
        include '../../common/upload.php';
        include '../../service/report/createService.php';
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


    public function isValid($info) {
        $intReturn = FALSE;
        $return2099 = $_SESSION['cd_2099'];
        $return2003 = $_SESSION['cd_2003'];
        $return2097 = $_SESSION['cd_2097'];
        $util = new Utility();
        if ($util->isEmpty($info[s_no])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_spare_refno'], $return2099);
            echo $return2099;
        }  else if ($util->isEmpty($info[s_color])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_spare_orderdate'], $return2099);
            echo $return2099;

        } else if ($util->isEmpty($info[s_fuel])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_spare_orderdate'], $return2099);
            echo $return2099;

        } else if ($util->isEmpty($info[s_distance])) {
            $return2099 = eregi_replace("field", $_SESSION['tb_po_spare_orderdate'], $return2099);
            echo $return2099;

        } 
        
        else {
            $intReturn = TRUE;
        }
        return $intReturn;
    }
    
    
    

///////////////////// End Class
}
