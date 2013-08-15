<?php
include_once('../class/lumi.php');
include_once('../php/functions.php');
$lumi = new Lumi ();

$id = isset($_POST['id']) ? $_POST['id'] : false;
$lat = isset($_POST['lat']) ? $_POST['lat'] : false;
$lng = isset($_POST['lng']) ? $_POST['lng'] : false;

if ( $lumi->upPos( $id, $lat, $lng ) ){
	echo 'success';
}else{
	echo 'error_' . $lumi->error();
}