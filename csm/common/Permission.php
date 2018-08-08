<?php
@session_start();
if($_SESSION["username"] == NULL){
$_SESSION["remember"] = $_COOKIE['remember'];
$_SESSION["username"] = $_COOKIE['username'];
$_SESSION["password"] = $_COOKIE['password'];
$_SESSION["i_user"] = $_COOKIE['i_user'];
$_SESSION["user_email"] = $_COOKIE['user_email'];
$_SESSION["img_profile"] = $_COOKIE['img_profile'];
$_SESSION["img_profile"] = $_COOKIE['img_profile'];
$_SESSION["full_name"] = $_COOKIE['full_name'];
$_SESSION["perm"] = $_COOKIE['perm'];
header("location:controller/changelanguageController.php?lan=th&url=".$_SERVER[REQUEST_URI]);

}
error_reporting(E_ERROR | E_PARSE);

if ($_SESSION["username"] == null || $_SESSION["username"] == "") {

    header("location:index.php");

    exit(0);

}

if ($_SESSION["perm"] == null || $_SESSION["perm"] == "") {

    header("location:index.php");

    exit(0);

}



if ($_SESSION[mode_lock] != NULL) {

    $mode_lock = (boolean) $_SESSION[mode_lock];

    if ($mode_lock) {

        header("location:lock_screen.php");

        exit(0);

    }

}



//$disable = ($_SESSION["perm"] == "U" ? "disabled='disabled'" : "");

//$readonly = ($_SESSION["perm"] == "U" ? "readonly='readonly'" : "");

//$hidden = ($_SESSION["perm"] == "U" ? "style='display:none;'" : "");



$disable = "";

$readonly = "";

$hidden = "";

define("JS_VERSION","3");

?>

