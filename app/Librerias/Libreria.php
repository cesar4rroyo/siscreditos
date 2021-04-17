<?php 

namespace App\Librerias;
use Validator;
use App\Menuoption;

/**
* Libreria de clases
*/
class Libreria
{

	public function generarPaginacion($lista, $pagina, $filas, $entidad){
		$cantidadTotal = count($lista); 
		if ($filas > $cantidadTotal) { 
			$filas = $cantidadTotal;
		}
		$cantidad = $cantidadTotal * 1.0; 
		$division = $cantidad / $filas; 
		$div = ceil($division); 
		if ($pagina > $div) {
			$pagina = (int) $div;
		}

		$inicio = ($pagina - 1) * $filas; 
		$fin    = ($pagina * $filas); 
		if ($fin > $cantidadTotal) {
			$fin = $cantidadTotal;
		}

		$cadenaPagina  = "";
		$puntosDelante = "";
		$puntosDetras  = "";
		$cadenaPagina .= "<ul class=\"pagination pagination-sm\">";
		$cadenaPagina .= "<li class=\"active mr-4\"><a href=\"#\" id='divtotalregistros'>TOTAL DE REGISTROS " . $cantidadTotal . "</a></li>";

		for ($i=1; $i <= $div ; $i++) { 
			if ($i == 1) {
				if ($i == $pagina) {
					$cadenaPagina .= "<li class=\"page-item active\"><a class=\"page-link\">" . $i . "</a></li>";
				} else {
					$cadenaPagina .= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"buscarCompaginado(" . $i . ", '', '".$entidad."')\">" . $i . "</a></li>";
				}
			}
			if ($i == $div && $i != 1) {
				if ($i == $pagina) {
					$cadenaPagina .= "<li class=\"page-item active\"  class=\"active\"><a class=\"page-link\">" . $i . "</a></li>";
				} else {
					$cadenaPagina .= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"buscarCompaginado(" . $i . ",'', '".$entidad."')\">" . $i . "</a></li>";
				}
			}
			if ($i != 1 && $i != $div) {
				if ($i == $pagina) {
					$cadenaPagina .= "<li class=\"page-item active\" class=\"active\"><a class=\"page-link\">" . $i . "</a></li>";
				} else {
					if ($i == ($pagina - 1) || $i == ($pagina - 2)) {
						$cadenaPagina .= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"buscarCompaginado(" . $i . ",'', '".$entidad."')\">" . $i . "</a></li>";
					}
					if ($i == ($pagina + 1) || $i == ($pagina + 2)) {
						$cadenaPagina .= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"buscarCompaginado(" . $i . ",'', '".$entidad."')\">" . $i . "</a></li>";
					}
				}
			}
			if ($i > 1 && $i < ($pagina - 2)) {
				if ($puntosDelante == '') {
					$puntosDelante =  "<li class=\"page-item \" class=\"disabled\"><a class=\"page-link\" href=\"#\">...</a></li>";
					$cadenaPagina .= $puntosDelante;
				}
			}
			if ($i < $div && $i > ($pagina + 2)) {
				if ($puntosDetras == '') {
					$puntosDetras = "<li class=\"page-item \" class=\"disabled\"><a class=\"page-link\" href=\"#\">...</a></li>";
					$cadenaPagina .= $puntosDetras;
				}
			}
		}
		$cadenaPagina .= "</ul>";
		$paginacion = array(
			'cadenapaginacion' => $cadenaPagina,
			'inicio'           => $inicio,
			'fin'              => $fin,
			'nuevapagina'      => $pagina,
			);
		//Input::replace(array('page' => $pagina));
		return $paginacion;
	}

	

	static function formatearFecha($fecha)
	{
		$date            = DateTime::createFromFormat('Y-m-d', $fecha);
		$fechanacimiento = $date->format('d/m/Y');
		return $fechanacimiento;
	}

	

	static function dias_transcurridos($fecha_i,$fecha_f)
	{
		$dias = (strtotime($fecha_f) - strtotime($fecha_i))/86400;
		$dias = floor($dias);		
		return $dias;
	}


	static function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	static function formatoFecha($fecha, $formatoorigen, $formatodestino)
	{
		if (is_null(self::getParam($fecha))) {
			return NULL;
		}
		$date = DateTime::createFromFormat($formatoorigen, $fecha);
		return $date->format($formatodestino);
	}

	static function obtenerParametro($value = NULL)
	{
		return (!is_null($value) && trim($value) !== '') ? $value : NULL ;
	}

	public static function verificarExistencia($id, $tabla)
	{
		$reglas = array(
			'id' => 'required|integer|exists:'.$tabla.',id,deleted_at,NULL'
			);
		$validacion = Validator::make(array('id' => $id), $reglas);
		if ($validacion->fails()) {
			$cadena = '<blockquote><p class="text-danger">Registro no existe en la base de datos. No manipular ID</p></blockquote>';
			$cadena .= '<button class="btn btn-warning btn-sm" id="btnCerrarexiste"><i class="fa fa-times fa-lg"></i> Cerrar</button>';
			$cadena .= "<script type=\"text/javascript\">
							$(document).ready(function() {
								$('#btnCerrarexiste').attr('onclick','cerrarModal(' + (contadorModal - 1) + ');').unbind('click');
							}); 
						</script>";
			return $cadena;
		}else{
			return true;
		}
	}

	public static function getParam($valor, $defecto = NULL)
	{
		return (!is_null($valor) && trim($valor) !== '') ? $valor : $defecto ;
	}

}