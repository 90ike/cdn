<?php
session_start();
define('ROOT_PATH', dirname(__FILE__));
require 'ValidateCode.class.php';
$_vc = new ValidateCode();
$_vc->doimg();
$_SESSION['authcode'] = $_vc->getCode();
?>