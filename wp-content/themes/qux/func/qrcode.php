<?php
require_once 'phpqrcode/phpqrcode.php';
$url = urldecode($_GET["data"]);

QRcode::png($url,false,'l',5);