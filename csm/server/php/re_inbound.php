<?php

@session_start();

$_SESSION['sub'] = '3';
error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
$upload_handler = new UploadHandler();
