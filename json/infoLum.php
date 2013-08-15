<?php
include_once('../class/lumi.php');
include_once('../php/functions.php');

$id = isset($_GET['id']) ? $_GET['id'] : false;
$lumi = new Lumi ();

 header('Content-type: text/javascript');
     echo $lumi->infoLum($id);

?>