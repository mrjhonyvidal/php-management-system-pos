<?php
require_once "../models/cartas.model.php";
require_once "../helpers/usuarios.helper.php";

header('Content-Type: application/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=cartasporte.csv');

// do not cache the file(filename)				
header('Pragma: no-cache');
header('Expires: 0');

$cuitFilter = $_GET['cuitFilter'];
$calidadFilter = $_GET['calidadFilter'];
$situacionFilter = $_GET['situacionFilter'];
$fechaDescargaInicialFilter = $_GET['fechaDescargaInicial'];
$fechaDescargaFinalFilter = $_GET['fechaDescargaFinal'];

$cartas = array();
$cartas = CartasModel::mdlMostrarDatosReporteCSV($cuitFilter, $calidadFilter, $situacionFilter, $fechaDescargaInicialFilter, $fechaDescargaFinalFilter);

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('GRANO',
	'COSECHA',
	'FECHA DE DESCARGA',
	'FECHA DE DESCARGA',
	'CUIT DESTINO',
	'RAZON SOCIAL DESTINO',
	'CUIT MOLCA POSTERIOR',
	'MOLCA POSTERIOR',
	'CUIT TITULAR CP',
	'RAZON SOCIAL TIULAR',
	'MOLCA ANTERIOR',
	'RAZON SOCIAL INTERMED O RTTE',
	'MOLCA',
	'COD POSTAL DESTINO',
	'LOCALIDAD DESTINO',
	'1',
	'BRUTO',
	'TARA',
	'NETO S/MERMA',
	'MERMA TOTAL',
	'NETO C/MERMA',
	'PORC. HUMEDAD',
	'PORC. MERMA HUM',
	'DESC. KG X HUMEDAD',
	'%ZARANDA',
	'DESC KG ZARANDA',
	'FUMIGADA (1 =SI , 0 = NO)',
	'NETO PROCENCIA',
	'N DE CP',
	'TIPO DE TRANSP (A= AUTOMOTOR. F = FERROCARRIL)',
	'OBSERVACIONES DE LA CP',
	'CUIT EMPRESA TRANSP',
	'RAZON SOCIAL EMPRESA TRANSP',
	'N° DE CTG',
	'PROCEDENCIA',
	'PAT. CHASIS',
	'OBSERVACIONES Y/O CALIDAD',
	'ESTADO',
	'GDM I',
	'GDM II'), ';');


// output each row of the data
foreach ($cartas as $row)
{
	fputcsv($output, array($row['grano'],
		$row['cosecha'],
		$row['fecha_descarga'],
		$row['fecha_descarga2'],
		$row['cuit_destino'],
		$row['razon_social_destino'],
		$row['cuit_molca_posterior'],
		$row['molca_posterior'],
		$row['cuit_titular_carta_porte'],
		$row['razon_social_titular'],
		$row['molca_anterior'],
		$row['razon_social_intermediario'],
		$row['molca'],
		$row['codigo_posta_destino'],
		$row['localidad_destino'],
		$row['tipo_entrega'],
		$row['bruto'],
		$row['tara'],
		$row['neto_sin_merma'],
		$row['merma_total'],
		$row['neto_con_merma'],
		$row['porcentaje_humedad'],
		$row['porcentaje_merma_humedad'],
		$row['descarga_kilo_por_humedad'],
		$row['porcentaje_zaranda'],
		$row['descarga_kilo_zaranda'],
		$row['fumigada'],
		$row['neto_procencia'],
		$row['numero_carta_porte'],
		$row['tipo_de_transporte'],
		$row['observaciones_carta_porte'],
		$row['cuit_empresa_transportista'],
		$row['razon_social_transportista'],
		$row['numero_ctg'],
		$row['procedencia'],
		$row['patente_chasis'],
		$row['observaciones_calidad'],
		$row['estado'],
		$row['gdm_1'],
		$row['gdm_2']), ';');
}


fclose($output);