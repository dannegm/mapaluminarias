<?php
include_once('../class/lumi.php');
include_once('../php/functions.php');

$serial = isset($_GET['serial']) ? $_GET['serial'] : false;
$barrios = isset($_GET['barrios']) ? $_GET['barrios'] : false;
$mes = isset($_GET['mes']) ? $_GET['mes'] : false;
$anio = isset($_GET['anio']) ? $_GET['anio'] : false;
$potencia = isset($_GET['potencia']) ? $_GET['potencia'] : false;
$nuevo = isset($_GET['nuevo']) ? $_GET['nuevo'] : false;
$reparada = isset($_GET['reparada']) ? $_GET['reparada'] : false;
$estado = isset($_GET['estado']) ? $_GET['estado'] : false;

$filtro = Array(
	'serial' => $serial,
	'barrios' => $barrios,
	'mes' => $mes,
	'anio' => $anio,
	'potencia' => $potencia,
	'nuevo' => $nuevo,
	'reparada' => $reparada,
	'estado' => $estado
);

$lumi = new Lumi ();
$lumi->setFilter( $filtro );

header('Content-type: text/javascript');
echo $lumi->getJSON();

?>