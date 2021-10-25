<?php 

/**
 * Clase con métodos para modificar o transformar fechas que son utilizadas en el sistema
 * 
 * @author Jhony Vidal 
 */

class FechasHelper{
 
 	public static $fechaFormatted = null;

 	// Modifica fecha que está en formato String ddMMYYYY a un formato Date YYYY-MM-DD
	static public function transformaFechaStringToDate($fecha){

		self::$fechaFormatted = substr($fecha,4,4) . '-' . substr($fecha, 2, 2) . '-' . substr($fecha, 0, 2);

		return self::$fechaFormatted;
	}

	// Modifica fecha que está en formato YYYY-MM-DD o DD-MM-YYYY a ---> DD/MM/YYYY
	static public function mostraFechaConBarras($fecha){

		// fecha = DD-MM-YYYY
		if(strpos($fecha, '-') != 4){

			self::$fechaFormatted = substr($fecha,0,2) . '/' . substr($fecha, 2, 2) . '/' . substr($fecha, 4, 4);

		// fecha = YYYY-DD-MM
		}elseif ($fecha != 0 && !empty($fecha) && $fecha != ''){	

			self::$fechaFormatted = substr($fecha,8,2) . '/' . substr($fecha, 5, 2) . '/' . substr($fecha, 0, 4);

		}else{
			self::$fechaFormatted = '-------';
		}

		return self::$fechaFormatted;
	}
}