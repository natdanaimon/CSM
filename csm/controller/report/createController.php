<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $info = json_decode(preg_replace('/("\w+"):(\d+)/','\\1:"\\2"',json_encode($_POST)),true);
} else {
  $info = json_decode(preg_replace('/("\w+"):(\d+)/','\\1:"\\2"',json_encode($_GET)),true);
}


$controller = new createController();
switch ($info[func]) {
  case "getDetail":
    echo $controller->getDetail($info);
    break;
  case "getDetailPartner":
    echo $controller->getDetailPartner($info);
    break;
  case "add":
    echo $controller->add($info);
    break;
  case "addWithholding":
    echo $controller->addWithholding($info);
    break;
  case "addInvoice":
    echo $controller->addInvoice($info);
    break;
  case "addQuatation":
    echo $controller->addQuatation($info);
    break;
  case "addReceipt":
    echo $controller->addReceipt($info);
    break;
  case "addBill":
    echo $controller->addBill($info);
    break;
  case "dataTableQuotation":
    echo $controller->dataTableQuotation($info);
    break;
  case "dataTableInvoice":
    echo $controller->dataTableInvoice($info);
    break;
  case "dataTableWithholding":
    echo $controller->dataTableWithholding($info);
    break;
  case "dataTableReceipt":
    echo $controller->dataTableReceipt($info);
    break;
  case "dataTableBill":
    echo $controller->dataTableBill($info);
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

  public function getDetail($info) {
    $service = new createService();
    $db = new ConnectDB();
    $db->conn();
    $_dataTable = $service->getDetail($db,$info);
    $util = new Utility();
    if ($_dataTable != NULL) {
      return json_encode($_dataTable);
    } else {
      return NULL;
    }
  }
  public function getDetailPartner($info) {
    $service = new createService();
    $db = new ConnectDB();
    $db->conn();
    $_dataTable = $service->getDetailPartner($db,$info);
    $util = new Utility();
    if ($_dataTable != NULL) {
      return json_encode($_dataTable);
    } else {
      return NULL;
    }
  }

  public function dataTableQuotation() {
    $service = new createService();
    $_dataTable = $service->dataTableQuotation();
    $util = new Utility();
    if ($_dataTable != NULL) {
      return json_encode($_dataTable);
    } else {
      return NULL;
    }
  }

  public function dataTableInvoice() {
    $service = new createService();
    $_dataTable = $service->dataTableInvoice();
    $util = new Utility();
    if ($_dataTable != NULL) {
      foreach ($_dataTable as $key => $value) {
        $_dataTable[$key]['i_ins_comp'] = $service->getInsurance($_dataTable[$key]['ref_no']);

      }
      return json_encode($_dataTable);
    } else {
      return NULL;
    }
  }

  public function dataTableWithholding() {
    $service = new createService();
    $_dataTable = $service->dataTableWithholding();
    $util = new Utility();
    if ($_dataTable != NULL) {
      return json_encode($_dataTable);
    } else {
      return NULL;
    }
  }

  public function dataTableReceipt() {
    $service = new createService();
    $_dataTable = $service->dataTablereceipt();
    $util = new Utility();
    if ($_dataTable != NULL) {
      return json_encode($_dataTable);
    } else {
      return NULL;
    }
  }
  public function dataTableBill() {
    $service = new createService();
    $_dataTable = $service->dataTableBill();
    $util = new Utility();
    if ($_dataTable != NULL) {
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
      if ($service->add($db,$info)) {
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
      $return2099 = eregi_replace("field",$_SESSION['tb_po_spare_refno'],$return2099);
      echo $return2099;
    } else if ($util->isEmpty($info[s_color])) {
      $return2099 = eregi_replace("field",$_SESSION['tb_po_spare_orderdate'],$return2099);
      echo $return2099;
    } else if ($util->isEmpty($info[s_fuel])) {
      $return2099 = eregi_replace("field",$_SESSION['tb_po_spare_orderdate'],$return2099);
      echo $return2099;
    } else if ($util->isEmpty($info[s_distance])) {
      $return2099 = eregi_replace("field",$_SESSION['tb_po_spare_orderdate'],$return2099);
      echo $return2099;
    } else {
      $intReturn = TRUE;
    }
    return $intReturn;
  }

  public function addWithholding($info) {
    if ($this->isValidWithholding($info)) {
      $db = new ConnectDB();
      $db->conn();
      $service = new createService();
      $resAdd = $service->addWithholding($db,$info);
      if ($resAdd > 0) {
        $db->commit();
        echo $_SESSION['cd_0000'].",".$resAdd;
      } else {
        $db->rollback();
        echo $_SESSION['cd_2001'];
      }
    }
  }

  public function isValidWithholding($info) {
    $intReturn = FALSE;
    $return2099 = $_SESSION['cd_2099'];
    $return2003 = $_SESSION['cd_2003'];
    $return2097 = $_SESSION['cd_2097'];
    $util = new Utility();
    if (1 > 2) {
      $return2099 = eregi_replace("field",$_SESSION['tb_po_spare_refno'],$return2099);
      echo $return2099;
    } else {
      $intReturn = TRUE;
    }
    return $intReturn;
  }

  public function addInvoice($info) {
    if ($this->isValidInvoice($info)) {
      $db = new ConnectDB();
      $db->conn();
      $service = new createService();
      $resAdd = $service->addInvoice($db,$info);
      if ($resAdd > 0) {
        $db->commit();
        echo $_SESSION['cd_0000'].",".$resAdd;
      } else {
        $db->rollback();
        echo $_SESSION['cd_2001'];
      }
    }
  }

  public function isValidInvoice($info) {
    $intReturn = FALSE;
    $return2099 = $_SESSION['cd_2099'];
    $return2003 = $_SESSION['cd_2003'];
    $return2097 = $_SESSION['cd_2097'];
    $util = new Utility();
    if (1 > 2) {
      $return2099 = eregi_replace("field",$_SESSION['tb_po_spare_refno'],$return2099);
      echo $return2099;
    } else {
      $intReturn = TRUE;
    }
    return $intReturn;
  }

  public function addQuatation($info) {
    if ($this->isValidQuatation($info)) {
      $db = new ConnectDB();
      $db->conn();
      $service = new createService();
      $get_id = $service->addQuatation($db,$info);
      if ($get_id > 0) {
        $db->commit();
        echo $_SESSION['cd_0000'].",".$get_id;
      } else {
        $db->rollback();
        echo $_SESSION['cd_2001'];
      }
    }
  }

  public function isValidQuatation($info) {
    $intReturn = FALSE;
    $return2099 = $_SESSION['cd_2099'];
    $return2003 = $_SESSION['cd_2003'];
    $return2097 = $_SESSION['cd_2097'];
    $util = new Utility();
    if (1 > 2) {
      $return2099 = eregi_replace("field",$_SESSION['tb_po_spare_refno'],$return2099);
      echo $return2099;
    } else {
      $intReturn = TRUE;
    }
    return $intReturn;
  }

  public function addReceipt($info) {
    if ($this->isValidReceipt($info)) {
      $db = new ConnectDB();
      $db->conn();
      $service = new createService();
      $resAdd = $service->addReceipt($db,$info);
      if ($resAdd > 0) {
        $db->commit();
        echo $_SESSION['cd_0000'].",".$resAdd;
      } else {
        $db->rollback();
        echo $_SESSION['cd_2001'];
      }
    }
  }

  public function isValidReceipt($info) {
    $intReturn = FALSE;
    $return2099 = $_SESSION['cd_2099'];
    $return2003 = $_SESSION['cd_2003'];
    $return2097 = $_SESSION['cd_2097'];
    $util = new Utility();
    if (1 > 2) {
      $return2099 = eregi_replace("field",$_SESSION['tb_po_spare_refno'],$return2099);
      echo $return2099;
    } else {
      $intReturn = TRUE;
    }
    return $intReturn;
  }
  
  public function addBill($info) {
    if (1>0) {
      $db = new ConnectDB();
      $db->conn();
      $service = new createService();
      $resAdd = $service->addBill($db,$info);
      if ($resAdd > 0) {
        $db->commit();
        //echo $_SESSION['cd_0000'].",".$resAdd;
        echo header("Location: ../../report/bill.php?id=".$resAdd);
      } else {
        $db->rollback();
        echo $_SESSION['cd_2001'];
      }
    }
  }

///////////////////// End Class
}
