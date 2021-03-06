<?php

@session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utility
 *
 * @author 
 */
class Utility {

    protected $_pathXML = "language.xml";
    protected $_parameter = "";
    protected $_imageLoading = "images/loading.gif";
    protected $_locationRedirectPremissionUser = "index.php";
    protected $_locationRedirectPremissionAdmin = "index.php";
    protected $_limitPaging = 16;
    protected $_email = "info@horgarage.com";

    function getEmail() {
        return $this->_email;
    }

    function getPathXML() {
        return $this->_pathXML;
    }

    function getLimitPaging() {
        return $this->_limitPaging;
    }

    function setLimitPaging($limitPaging) {
        $this->_limitPaging = $limitPaging;
    }

    function setPathXML($pathXML) {
        $this->_pathXML = $pathXML;
    }

    function getParameterAjax() {
        return $this->__parameter;
    }

    function ClearParameterAjax() {
        $this->__parameter = "";
    }

    function getImageLoading() {
        return $this->_imageLoading;
    }

    function setImageLoading($imageLoading) {
        $this->_imageLoading = $imageLoading;
    }

    function getlocationRedirectPremissionUser() {
        return $this->_locationRedirectPremissionUser;
    }

    function setlocationRedirectPremissionUser($locationRedirectPremission) {
        $this->_locationRedirectPremissionUser = $locationRedirectPremission;
    }

    function getlocationRedirectPremissionAdmin() {
        return $this->_locationRedirectPremissionAdmin;
    }

    function setlocationRedirectPremissionAdmin($locationRedirectPremission) {
        $this->_locationRedirectPremissionAdmin = $locationRedirectPremission;
    }

    function setParameterAjax($variable, $value, $endParameter) {
        $tmp = $variable . "=" . $value;
        $space = "&";
        if ($endParameter) {
            $space = "";
        }

        $this->__parameter = $this->__parameter . $tmp . $space;
    }

    function LanguageConfig($type) {

        $xml = simplexml_load_file($this->_pathXML) or die("Error: Cannot create object");
        foreach ($xml->children() as $languages) {
            if ($type == "th") {
                $_SESSION["$languages->variable"] = (string) $languages->th;
            } else if ($type == "en") {
                $_SESSION["$languages->variable"] = (string) $languages->en;
            }
        }
    }

    function AddModal_Action($modalName, $Action) {
        echo "<script type='text/javascript'>";
        echo "$('#$modalName').modal('$Action');";
        echo "</script>";
    }

    function AddAjaxGetResultResponseText($FunctionName, $element, $path, $modalName) {
        $newline = "\n";
        echo $script = '' . $newline;
        echo $script = '<script type="text/javascript">  ' . $newline;
        echo $script = ' function ' . $FunctionName . '(param,seq) { ' . $newline;
        echo $script = '                   $(\'#' . $modalName . '\').modal(\'show\'); ' . $newline; // parameter $modalName for project biotec
        echo $script = '                var xmlhttp = new XMLHttpRequest();  ' . $newline;
        echo $script = '                xmlhttp.onreadystatechange = function () { ' . $newline;
        echo $script = '                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { ' . $newline;
        echo $script = '                        var result = xmlhttp.responseText.split(","); ' . $newline;
        $cnt = 0;
        foreach ($element as $ele) {
            echo $script = '                        document.getElementById("' . $ele[0] . '").' . $ele[1] . ' = result[' . $cnt++ . ']; ' . $newline;
        }
        /**
         * 
         * @var ****** Start  Sctrip For Reload After read Contact
         * 
         */
        echo $script = '                  update_icon_text(seq);  ' . $newline;
        echo $script = '                   unloading();  ' . $newline;
        /**
         * 
         * @var ****** End  Sctrip For Reload After read Contact
         * 
         */
        echo $script = '                    } ' . $newline;
        echo $script = '                } ' . $newline;
        echo $script = '              ' . $newline;
        echo $script = '                xmlhttp.open("GET", "' . $path . '?" + param, true); ' . $newline;
        echo $script = '                xmlhttp.send(); ' . $newline;
        echo $script = '        } ' . $newline;
        echo $script = "  </script> " . $newline;
        ############################################ AJAX STEP BY STEP ##########################################
//        $util = new Utility();
//
//        //Set -> ElementID , Properties 
//        $element = array(
//            array("par", "innerHTML"),
//            array("txt1", "innerHTML"),
//            array("txtfield", "value")
//        ); 
//        //Set -> FunctionName , Element , PhpAjaxFile , modalName
//                $util->AddAjaxGetResultResponseText("ABC", $element, "ajax.php" ,"modalName")
//                $util->ClearParameterAjax(); 
//                $util->setParameterAjax("param", $i, TRUE);
//        <input type="button" value="OK" onclick="ABC('<?= $util->getParameterAjax() >');"/>
        ########################################## AJAX STEP BY STEP ##########################################
    }

    function setScriptPageLoading($loadJS_Client, $sec) {
        $sec = $sec * 1000;
        if ($loadJS_Client) {
            echo "<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js'></script>\n";
            echo "<script src='http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js'></script>\n";
        } else {
            echo "<script src='js/jquery1.5.2.js'></script>\n";
            echo "<script src='js/modern.js'></script>\n";
        }
        echo "<script> $(window).load(function () { $('.se-pre-con').delay(" . $sec . ").fadeOut('slow');   }); </script>\n";
    }

    function setCSSPageLoading() {
        $CSS = "";
        $CSS .= "<style> ";
        $CSS .= " ";
        $CSS .= "            .no-js #loader { display: none;  } ";
        $CSS .= "            .js #loader { display: block; position: absolute; left: 100px; top: 0; } ";
        $CSS .= "            .se-pre-con { ";
        $CSS .= "                width:100%; ";
        $CSS .= "                height:100%; ";
        $CSS .= "                position:fixed; ";
        $CSS .= "                top:0; ";
        $CSS .= "                left:0; ";
        $CSS .= "                z-index:999; ";
        $CSS .= "                background: rgba(255,255,255,.5) url(" . $this->_imageLoading . ")    no-repeat; ";
//        $CSS .= "                background-size: 75px 75px; ";
        $CSS .= "                background-position: center center; ";
        $CSS .= "            } ";
        $CSS .= "        </style> ";

        echo $CSS;
    }

    function getPageLoading($loadJS_Client, $sec) {
        $this->setCSSPageLoading();
        $this->setScriptPageLoading($loadJS_Client, $sec);
        echo " <div class='se-pre-con' > </div>";
    }

    function CheckPermissionAdmin($Admin) {
        if ($Admin == null || $Admin == "") {
            header("location:" . $this->_locationRedirectPremissionAdmin);
        }
    }

    function CheckPermissionUser($User) {

        if ($User == null || $User == "") {
            header("location:" . $this->_locationRedirectPremissionUser);
        }
    }

    function isEmptyReg($value) {
        if ($value == null || $value == "") {
            return TRUE;
        } else {
            if (preg_match("/[^A-Za-z0-9]/", $value)) {
                return TRUE;
            }
            return FALSE;
        }
    }

    function isEmpty($tmp) {
        if ($tmp == NULL || trim($tmp) == '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function countObject($_data) {
        $no = 0;
        foreach ($_data as $key => $value) {
            $no++;
        }
        return $no;
    }

    function ContinueObject($page, $seq) {
        $max = $page * $this->_limitPaging;
        $min = $max - $this->_limitPaging;
        if (($seq > $min) && ($seq <= $max)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function CopyTemplatedMail($filemain, $filecopy, $msg) {
        $templatedMail = fopen($filemain, "r") or die("Unable to open file!");
        $txt = fread($templatedMail, filesize($filemain));
        fclose($templatedMail);
        $txt = eregi_replace("&detail;", $msg, $txt);
        $txt = eregi_replace("http://localhost/CSM/csm/email/", "../email/", $txt);
        $txt = eregi_replace("https://www.horgarage.com//csm/email/", "../email/", $txt);
        $txt = eregi_replace("https://www.horgarage.com/csm/email/", "../email/", $txt);
        $txt = eregi_replace("https://www.horgarage.com/csm/email/", "../email/", $txt);
        $txt = eregi_replace("https://www.horgarage.com/csm/email/", "../email/", $txt);

        $temp = fopen($filecopy, "w") or die("Unable to open file!");
        fwrite($temp, $txt);
        fclose($temp);
    }

    function CopyTemplatedMailForgot($filemain, $filecopy, $name, $lastname, $user, $password) {
        $templatedMail = fopen($filemain, "r") or die("Unable to open file!");
        $txt = fread($templatedMail, filesize($filemain));
        fclose($templatedMail);
        $txt = eregi_replace("&to;", $name . " " . $lastname, $txt);
        $txt = eregi_replace("&username;", $user, $txt);
        $txt = eregi_replace("&password;", $password, $txt);
        $txt = eregi_replace("http://localhost/CSM/csm/email/", "../email/", $txt);
        $txt = eregi_replace("https://www.horgarage.com//csm/email/", "../email/", $txt);
        $txt = eregi_replace("https://www.horgarage.com/csm/email/", "../email/", $txt);
        $txt = eregi_replace("https://www.horgarage.com/csm/email/", "../email/", $txt);
        $txt = eregi_replace("https://www.horgarage.com/csm/email/", "../email/", $txt);

        $temp = fopen($filecopy, "w") or die("Unable to open file!");
        fwrite($temp, $txt);
        fclose($temp);
    }

    public function DateSQL($date) {

        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $yyyy = substr($date, 6, 4);
        return $yyyy . "-" . $mm . "-" . $dd;
    }

    public function DateSelectSQL($date) {

        $dd = substr($date, 0, 2);
        $mm = substr($date, 4, 2);
        $yyyy = substr($date, 7, 4);
        return $yyyy . "-" . $mm . "-" . $dd;
    }

    public function DateSql2d_dmm_yyyy($date) {

        $yyyy = substr($date, 0, 4);
        $mm = substr($date, 5, 2);
        $dd = substr($date, 8, 2);
        return $dd . "-" . $mm . "-" . $yyyy;
    }

    public function DateSql2ddmmyyyy($date) {

        $yyyy = substr($date, 0, 4);
        $mm = substr($date, 5, 2);
        $dd = substr($date, 8, 2);
        return $dd . "/" . $mm . "/" . $yyyy;
    }

    public function TimeSql2hh($time) {
        $hh = substr($time, 0, 2);
        return $hh;
    }

    public function TimeSql2mi($time) {
        $mi = substr($time, 3, 2);
        return $mi;
    }

    function dateTimeAgo($dt) {
        date_default_timezone_set('Asia/Bangkok');
        $strStart = new DateTime($dt);
        $strEnd = new DateTime('now');
        $dteDiff = $strStart->diff($strEnd);
        $day = (Integer) $dteDiff->format("%d");
        $hour = (Integer) $dteDiff->format("%H");
        $min = (Integer) $dteDiff->format("%i");
        $sec = (Integer) $dteDiff->format("%s");
        if ($day > 0) {
            return $day . " " . $_SESSION[ago_day];
        }
        if ($hour > 0) {
            return $hour . " " . $_SESSION[ago_hour];
        }
        if ($min > 0) {
            return $min . " " . $_SESSION[ago_min];
        }
        if ($min <= 0) {
            return $_SESSION[ago_now];
        }
    }

    function arr2strQuery($arr, $type) {
        $i = 1;
        $tmp = "";
        $fl = "";
        if ($type == "S") {
            $fl = "'";
        }
        foreach ($arr as $value) {
            $tmp .= $fl . $value . $fl;
            if (count($arr) != $i) {
                $tmp .= ",";
            }

            $i++;
        }
        return $tmp;
    }

    function isPhoneNumber($str) {
        //$str = "(999) 999-9999";
        $str = str_replace("(", "", $str);
        $str = str_replace(")", "", $str);
        $str = str_replace("-", "", $str);
        $str = str_replace(" ", "", $str);

        if (strlen($str) == 10 && is_numeric($str)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function isAccountNo($str) {
        //$str = "123-4-56789-0";
        $str = str_replace("(", "", $str);
        $str = str_replace(")", "", $str);
        $str = str_replace("-", "", $str);
        $str = str_replace(" ", "", $str);

        if (strlen($str) == 10 && is_numeric($str)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function isSecurity($str) {
        //$str = "999999";
        if (strlen($str) == 4 && is_numeric($str)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function range_month_key($i) {
        $date = date_create(date("Y-m", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' months')), 'n/' . '1' . '/Y');
    }

    function range_month_value($i) {
        $date = date_create(date("Y-m", new DateTimeZone('Asia/Bangkok')), new DateTimeZone('Asia/Bangkok'));
        return date_format(date_add($date, date_interval_create_from_date_string('-' . $i . ' months')), 'Y-m');
    }

    function convertFileSize($size) {

        $size = ($size / 1000);

        $kbCal = 1024;
        if ($size < 100) {
            $returnSize = number_format($size, 1, '.', '') . " KB";
        } else {
            $returnSize = number_format(($size / $kbCal), 1, '.', '') . " MB";
        }


        return $returnSize;
    }

    function getDatetimePattern($formatPattern) {
        date_default_timezone_set('Asia/Bangkok');
        $date = new DateTime('now');
        return $date->format($formatPattern);
    }
    
    
//Thai text for that number
  function integerToThai($number) {
    $number = ltrim($number, ' 0');
    if ($number == '') {
      return 'ศูนย์';
    }
    if ($number == '1') {
      return 'หนึ่ง';
    }
    $number = strrev($number);
    return $this->millionToThaiHelper($number, '', true);
  }
  function millionToThaiHelper($rnumber, $sofar, $first) {
    if (strcmp($rnumber, '1') == 0) {
      if ($first) {
        return 'หนึ่ง' . $sofar;
      } else {
        return 'หนึ่งล้าน' . $sofar;
      }
    } else {
      if (strlen($rnumber) > 6) {
        if ($first) {
          return $this->millionToThaiHelper(substr($rnumber, 6), $this->integerToThaiHelper($rnumber, 1, '') . $sofar, false);
        } else {
          return $this->millionToThaiHelper(substr($rnumber, 6), $this->integerToThaiHelper($rnumber, 1, '') . 'ล้าน' . $sofar, false);
        }
      } else {
        if ($first) {
          return $this->integerToThaiHelper($rnumber, 1, '') . $sofar;
        } else {
          return $this->integerToThaiHelper($rnumber, 1, '') . 'ล้าน' . $sofar;
        }
      }
    }
  }
  function integerToThaiHelper($rnumber, $digit, $sofar) {
    if ($digit > 6) {
      return $sofar;
    }
    if ($rnumber == '') {
      return '';
    } else {
      $bahttext_reading = array(
          1 => array('', 'เอ็ด', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'),
          2 => array('', 'สิบ', 'ยี่สิบ', 'สามสิบ', 'สี่สิบ', 'ห้าสิบ', 'หกสิบ', 'เจ็ดสิบ', 'แปดสิบ', 'เก้าสิบ'),
          3 => array('', 'หนึ่งร้อย', 'สองร้อย', 'สามร้อย', 'สี่ร้อย', 'ห้าร้อย', 'หกร้อย', 'เจ็ดร้อย', 'แปดร้อย', 'เก้าร้อย'),
          4 => array('', 'หนึ่งพัน', 'สองพัน', 'สามพัน', 'สี่พัน', 'ห้าพัน', 'หกพัน', 'เจ็ดพัน', 'แปดพัน', 'เก้าพัน'),
          5 => array('', 'หนึ่งหมื่น', 'สองหมื่น', 'สามหมื่น', 'สี่หมื่น', 'ห้าหมื่น', 'หกหมื่น', 'เจ็ดหมื่น', 'แปดหมื่น', 'เก้าหมื่น'),
          6 => array('', 'หนึ่งแสน', 'สองแสน', 'สามแสน', 'สี่แสน', 'ห้าแสน', 'หกแสน', 'เจ็ดแสน', 'แปดแสน', 'เก้าแสน')
      );
      if (strlen($rnumber) == 1) {
        return $bahttext_reading[$digit][$rnumber] . $sofar;
      } else {
        return $this->integerToThaiHelper(substr($rnumber, 1), ($digit + 1), $bahttext_reading[$digit][substr($rnumber, 0, 1)] . $sofar);
      }
    }
  }


  function bahtText($number) {
    if (!is_numeric($number) || $number < 0) {
      die('bahtText error: the argument is not a valid positive number');
    }
    if (is_float($number)) {//for weird formats such as 2E5
      //echo 'float';
      $whole = floor($number);
      $decimal = round(($number - $whole) * 100);
    } else {
      $temp = explode('.', $number);
      if (count($temp) == 1) {
        $whole = $temp[0];
        $decimal = 0;
      } else {
        $whole = $temp[0];
        $length = strlen($temp[1]);
        if ($length > 2) {
          $decimal .= '0';
          $decimal = substr($temp[1], 0, 3);
          $decimal = round($decimal / (10.0));
        } else if ($length == 2) {
          $decimal = $temp[1];
        }//0.5 ==> ห้าสิบสตางค์
        else {
          $decimal = $temp[1] . '0';
        }
      }
    }
    if ($decimal == 0) {
      return $this->integerToThai($whole) . 'บาทถ้วน';
    } else {
      if ($whole != 0) {
        return $this->integerToThai($whole) . 'บาท' . $this->integerToThai($decimal) . 'สตางค์';
      } else {
        return $this->integerToThai($decimal) . 'สตางค์';
      }
    }
  }


}
