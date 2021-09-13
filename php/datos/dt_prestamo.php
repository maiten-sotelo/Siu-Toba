<?php
class dt_prestamo extends maiten_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_p.id_prestamo,
			t_p.libro_id,
			t_p.persona_id,
			t_p.fecha_alta,
			t_p.plazo,
			t_p.fecha_venc
		FROM
			prestamo as t_p";
		return toba::db('libros')->consultar($sql);

		
	}

	function ajax__get_calcula_vto($dts, toba_ajax_respuesta $respuesta)
	{	  
		$rs = null;
		$fe = date($dts['fecha_alta']);
		$year = substr($fe,6,4); 
		$month = substr($fe,3,2); 
		$day = substr($fe,0,2); 
		$fecha_aux = $year."-".$month."-".$day;
		$fecha_final = strtotime('+'.$dts['plazo'].'day', strtotime($fecha_aux)); 
		$rs = date('d-m-Y', $fecha_final);  
		$respuesta->set($rs);
	}




}

?>