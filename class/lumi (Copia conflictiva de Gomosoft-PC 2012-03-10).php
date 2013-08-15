<?php

class Lumi
{
    private $_db_server = 'localhost';
    	private $_db_user = 'root';
    	private $_db_pass = '2857811';
    	private $_db_bdata = 'montelibano';
    	private $_tb_lum = 'luminarias';
    	private $_tb_pqr = 'pqr';

	private $_mysqli;
	private $_error = "No hay error";

	private $_condicion = "";

	public function __construct (){

		$mysqli = new mysqli($this->_db_server, $this->_db_user, $this->_db_pass, $this->_db_bdata);

		if ( mysqli_connect_errno () ) {

			$this->_error = "No se pudo conectar con la base de datos";
			return false;

		}else{

			$this->_mysqli = $mysqli;
			return true;

		}

	}

	public function error () {
		return $this->_error;
	}

	private function _count ( $what ){

		$conexion = $this->_mysqli;
		$query = "";

		switch($what){
			case 'filter': $query = "SELECT * FROM `{$this->_tb_lum}` {$this->_condicion}"; break;
			case 'all': $query = "SELECT * FROM `{$this->_tb_lum}`"; break;
		}

		$conexion->query($query);
		return $conexion->affected_rows;

	}

	private function _update ($who, $what, $newVal){
		$conexion = $this->_mysqli;

		$query = "UPDATE `{$this->_tb_lum}` SET `{$what}` = ? WHERE `id` = '{$who}'";

		$up = $conexion->prepare($query);
		$up->bind_param ( 's', $newVal );
		$upd = $up->execute();

		if ( !$upd ) {
			$this->_error = "No se pudo actualizar";
			return false;
		}else{
			return true;
		}

	}

	public function upPos ( $who, $lat, $lng ){
		if ( $this->_update($who, 'norte', $lat) &&  $this->_update($who, 'sur', $lng) ){

			return true;

		}else{

			$this->_error = "No se pudo actualizar posición";
			return false;

		}
	}

	public function setFilter ( $filter ){

		$query = " WHERE `id` IS NOT NULL";

		if ( $filter['serial'] ) {
			$query .= " AND `serial` = '" . $filter['serial'] . "'";
		}elseif ( $filter['barrios'] ) {
			$query .= " AND `barrio` like '%" . $filter['barrios'] . "%'";
		}elseif ( $filter['mes'] ) {
			$query .= " AND `mes` = '" . $filter['mes'] . "'";
		}elseif ( $filter['anio'] ) {
			$query .= " AND `anio` = '" . $filter['anio'] . "'";
		}elseif ( $filter['potencia'] ) {
			$query .= " AND `potencia` = '" . $filter['potencia'] . "'";
		}elseif ( $filter['nuevo'] ) {
			$query .= " AND `estado` = '1'";
		}elseif ( $filter['reparada'] ) {
			$query .= " AND `reparada` != ''";
		}elseif ( $filter['estado'] ) {
			$query .= " AND `estado` = '". $filter["estado"]."'";
		}

		$this->_condicion = $query;
	}

	private function _consult ( $who, $what ){
		$conexion = $this->_mysqli;
		$query = "SELECT `{$what}` FROM `{$this->_tb_lum}` WHERE `serial` = '{$who}'";
		if ($get_data = $conexion->query($query)){
			while($result = $get_data->fetch_assoc()){
				return $result[$what];
			}
		}
	}

	private function _c_rep ( $who ){
		$conexion = $this->_mysqli;
		$query = "SELECT * FROM `{$this->_tb_pqr}` WHERE `serial` = '{$who}'";
		if ($get_data = $conexion->query($query)){
			while($result = $get_data->fetch_assoc()){
				return Array(
					'serial' => $result['serial'],
					'nombre' => $result['nombre'],
					'fecha' => $result['fecha'],
					'cedula' => $result['cedula'],
					'telefono' => $result['telefono'],
					'barrio' => $result['barrio'],
					'dir' => $result['dir'],
					'solicitud' => $result['solicitud'],
					'estado' => $result['estado'],
					'seriales' => $result['seriales'],
					'tipo' => $result['tipo']
				);
			}
		}
	}

	public function infoLum ( $who ){

		return json_encode(Array(

			'id' => $this->_consult($who, 'id'),
			'serial' => $this->_consult($who, 'serial'),
			'barrio' => $this->_consult($who, 'barrio'),
			'potencia' => $this->_consult($who, 'potencia'),
			'fecha' => $this->_consult($who, 'fecha'),
			'estado' => $this->_consult($who, 'estado'),
			'anio' => $this->_consult($who, 'anio'),
			'mes' => $this->_consult($who, 'mes'),
			'detalles' => $this->_consult($who, 'detalles'),
			'lat' => $this->_consult($who, 'norte'),
			'lng' => $this->_consult($who, 'sur'),
			'reparada' => $this->_consult($who, 'reparada'),
			'reporte' => $this->_c_rep($this->_consult($who, 'reparada'))
		));

	}

	public function getJSON () {

		$query = "SELECT * FROM `{$this->_tb_lum}`" . $this->_condicion;

		$conexion = $this->_mysqli;

		if ( $get_data = $conexion->query($query) ){

			$coords = Array();
			while($coor = $get_data->fetch_assoc()){

				$color = '';
				switch( $coor['potencia'] ){
					case '250': $color = 'yellow'; break;
					case '70': $color = 'green'; break;
					case '150': $color = 'blue'; break;
					default: $color = 'fiusha'; break;
				}

				$forma = '';

				$estado = cleantext($coor['estado']);
				switch( $estado ){
					case '5': $forma = 'circle'; $color = 'white'; break;
					case '4': $forma = 'circle'; $color = 'black'; break;
					case '2': $forma = 'square'; break;
					case '6': $forma = 'triangle'; break;
					case '1': $forma = 'star'; break;
					default: $forma = 'circle'; break;
				}

				if( is_numeric($coor['reparada']) ){
					$forma = 'square';  $color = 'red';
				}

				$lat = format_coor($coor['norte']);
				$lng = format_coor($coor['sur'], false);
				$coord = array (
						'id' => $coor['id'],
                        'serial' => $coor['serial'] ,
						'lat' => $lat,
						'lng' => '-' . $lng,
						'key' => $forma . '_' . $color
				);

				$coords[] = $coord;
			}

			$suma = $conexion->query("SELECT SUM(`potencia`) as `total` FROM `luminarias` " . $this->_condicion );
			$suma = $suma->fetch_assoc();

			$all = $this->_count('all');
			$showing = $this->_count('filter');

			$bomb = array(
				'details' => Array(
					'total' => $all,
					'showing' => $showing,
					'percent' => percent($showing, $all),
					'sum' => $suma['total']
				),
				'coor' => $coords
			);

			return json_encode($bomb);
		}
	}
}
