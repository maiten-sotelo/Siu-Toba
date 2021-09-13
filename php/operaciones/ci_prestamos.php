<?php
class ci_prestamos extends maiten_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function rel() 
	{
		return $this->dep('datos'); 
	}

	function evt__agregar()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_inicial');
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar();
		$this->set_pantalla('pant_inicial');
	}

	function evt__guardar()
	{
		$this->dep('datos')->set($datos);
		$this->dep('datos')->resetear();
		$this->dep('datos')->sincronizar();
		//$this->evt_cancelar();
		$this->informar_msg('Los datos se han guardado correctamente', 'info');
	}


	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->set($datos);
	}

	/*function ajax__get_calcula_vto($dts, toba_ajax_respuesta $respuesta)
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
	}*/


	function conf__formulario(fecha $form)
	{
	//$datos = $this->rel()->tabla('prestamo')->get() + $this->rel()->tabla('libro')->get();
	}

	function get_tipo_persona($id=0){
		$rs = toba::db()->consultar("SELECT id_persona_tipo  FROM cidig.persona WHERE id_persona = ".$id);
	$valor = "No se pudo identificar el Id.Persona tipo: ".$id;

	if(count($rs) > 0 ){
		$valor = $rs[0]['id_persona_tipo'];
	}

	return $valor;
	}

	function debe($id=0){
		$rs =toba::db()->consultar("SELECT id_prestamo
		FROM curlib.prestamo
		where persona_id = '$id' AND (devolucion = 'No') AND fecha_venc < current_date");

		$valor=0;

		if(count($rs) > 0 ){
			$valor = $rs[0]['id_prestamo'];
		}
		return $valor;
	}

	function cuenta($id = 0)
	{
		$count =toba::db()->consultar("SELECT count(id_prestamo) as cant
		FROM curlib.prestamo
		where persona_id= '$id' and devolucion = 'No'");
		$cantLibros=0;
		if(count($count)>0)
		{
			$cantLibros = $count[0]['cant'];
		}
		return $cantLibros;
	}

	function stock($id=0){
		$rs =toba::db()->consultar("SELECT ejemplar
		FROM curlib.libro 
		where titulo = '$id' ");
		$valor=0;
		if(count($rs) > 0 ){
			$valor = $rs[0]['ejemplar'];
		}
		return $rs;
	}



	function evt__formulario__alta($datos)
	{
		$id_persona = $datos['persona_id'];
		$id_libro = $datos['libro_id'];
		//$cuil_documento = $datos['cuil_documento'];
		//$ejemplar = $datos['ejemplar'];
		//$this->informar_msg($this->stock($ejemplar), 'info');
	
		if ($this->get_tipo_persona($id_persona)==2){ 
			
			$this->informar_msg('No se puede realizar el prestamo,no es una persona fisica','error');
		}
		elseif ($this->debe($id_persona)!=0){ 
			
			$this->informar_msg('No se puede realizar el prestamo porque debe un libro','error');
		}
		elseif($this->cuenta($id_persona)>=3){

			$this->informar_msg('No se puede realizar el prestamo porque supero la cantidad de libros que pidio prestado','error');

		}
		/*elseif ($this->$ejemplar == 0){ 
			$this->informar_msg('No se puede realizar el prestamo no hay libro disponible','error');
		}*/

		else
		{
			
			$datos['devolucion']="No";
			$libro = $datos['libro_id'];
	
			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$libro));
			$dt_l=$this->rel()->tabla('libro')->get_filas();
			$dt_l[0]['id_estado']=2;
		
			$this->rel()->tabla('prestamo')->set($datos);
			$this->rel()->tabla('prestamo')->sincronizar();
			$this->rel()->tabla('prestamo')->resetear();
			$this->rel()->tabla('libro')->set($dt_l[0]); 
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();
			$this->informar_msg('Datos se creo exitosamente ', 'info');
			$this->set_pantalla('pant_inicial');
		}
		
		
	}

	

	function evt__formulario__baja()
	{
		$this->rel()->tabla('prestamo')->set();
		$this->rel()->sincronizar();

	}

	function evt__formulario__cancelar()
	{
	}

}
?>