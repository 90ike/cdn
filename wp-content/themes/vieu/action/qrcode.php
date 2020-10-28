<?php
//error_reporting(E_ERROR);
require_once 'phpqrcode.php';
//取得GET参数
$text        = isset($_GET["text"]) ? $_GET["text"] : 'help';
$errorLevel = isset($_GET["e"]) ? $_GET["e"] : 'L';
$PointSize  = isset($_GET["p"]) ? $_GET["p"] : '8';
$margin     = isset($_GET["m"]) ? $_GET["m"] : '1';
preg_match('/http:\/\/([\w\W]*?)\//si', $text, $matches);


    //调用二维码生成函数
    createqr($text, $errorLevel, $PointSize, $margin);


function createqr($value,$errorCorrectionLevel,$matrixPointSize,$margin) {
    QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize, $margin);
}
