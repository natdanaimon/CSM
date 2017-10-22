<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_POST)), true);
} else {
    $info = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', json_encode($_GET)), true);
}
//$info['func'] = 'captcha';

$controller = new loginController();
switch ($info[func]) {
    case "login":
        echo $controller->login($info);
        break;
    case "forgot":
        echo $controller->forgot($info);
        break;
    case "captcha":
        echo $controller->captcha();
        break;
}

class loginController {

   
    public function login($info) {
        include '../service/loginService.php';
        include '../common/Utility.php';
        $servic = new loginService();
        $util = new Utility();
        $util->setPathXML("../language/language_common.xml");
        $util->LanguageConfig("th");
        $util->setPathXML("../language/language_page.xml");
        $util->LanguageConfig("th");
        $_SESSION["lan"] = "th";
        $_SESSION["selected_lan_pic"] = "th.png";
        $_SESSION["selected_lan_name"] = "TH";

//        $util->setPathXML("../language/language_common.xml");
//        $util->LanguageConfig("en");
//        $util->setPathXML("../language/language_page.xml");
//        $util->LanguageConfig("en");
//        $_SESSION["lan"] = "en";
//        $_SESSION["selected_lan_pic"] = "us.png";
//        $_SESSION["selected_lan_name"] = "US";

        $flgUser = $util->isEmptyReg($info[username]);

        if ($flgUser) {
            echo $_SESSION['cd_4001'];
            return;
        }


        $flgPass = $util->isEmptyReg($info[password]);
        if ($flgPass && !$flgUser) {
            echo $_SESSION['cd_4002'];
            return;
        }

        if (strtoupper($info[captcha]) != strtoupper($_SESSION[captcha][code])) {
            echo $_SESSION['cd_4004'];
            return;
        }

        if (!$flgUser && !$flgPass) {
            $_data = $servic->login($info);

            if ($_data != NULL) {
                foreach ($_data as $key => $value) {
                    $_SESSION["i_user"] = $_data[$key]['i_user'];
                    $_SESSION["username"] = $_data[$key]['s_user'];
                    $_SESSION["user_email"] = $_data[$key]['s_email'];
                    $_SESSION["password"] = $_data[$key]['s_pass'];
                    $_SESSION["img_profile"] = $_data[$key]['s_image'];
                    $_SESSION["full_name"] = $_data[$key]['s_firstname'] . " " . $_data[$key]['s_lastname'];
                    $_SESSION["perm"] = $_data[$key]['s_type'];
                }
                $_SESSION[mode_lock] = FALSE;
                echo $_SESSION['cd_0000'];
            } else {
                echo $_SESSION['cd_4003'];
            }
        }
    }

    public function captcha() {
        include '../captcha/simple-php-captcha.php';
        $_SESSION = array();
        $_SESSION['captcha'] = simple_php_captcha();
        echo $_SESSION['captcha'][image_src];
    }

}
