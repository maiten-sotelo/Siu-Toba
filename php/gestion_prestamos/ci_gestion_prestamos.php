<?php
class ci_gestion_prestamos extends maiten_ci
{
	protected $s__filtro;

	function rel() 
	{
		return $this->dep('datos'); 
	}
	


	//---- Filtro -----------------------------------------------------------------------

	function get_filtro_prestamo($where='')
	{
		$sql=("SELECT 
		t_p.id_prestamo,
		t_pe.cuil_documento,
		t_pn.apyn,
		t_l.titulo,
		t_l.isbn,
		t_p.fecha_alta,
		t_p.plazo,
		t_p.fecha_venc,
		t_p.devolucion,
		t_p.fecha_devolucion,
		t_p.dias_retraso,
		CASE 
			WHEN t_p.devolucion='No' and ((current_date - t_p.fecha_venc) > 0)
			THEN (current_date - t_p.fecha_venc) ELSE 0
			END as retraso
		FROM curlib.prestamo as t_p LEFT OUTER JOIN curlib.libro as t_l ON (t_p.libro_id = t_l.id_libro),
		cidig.persona  as t_pe ,
		cidig.persona_natural as t_pn
		where (t_p.persona_id = t_pe.id_persona) 
		AND  (t_pe.id_persona = t_pn.id_persona) 
		AND t_p.devolucion = 'No'
		AND $where;");
		return toba::db()->consultar($sql);
	}

	function libroporpersona($id = 0)
	{
		$count =toba::db()->consultar("SELECT count(libro_id) as cant
		FROM curlib.prestamo
		where persona_id = '$id' and devolucion= 'No' or devolucion is null");
		$cantLibrosporPers=0;
		if(count($count)>0)
		{
			$cantLibrosporPers = $count[0]['cant'];
		}
		return $cantLibrosporPers;
	}

	//---- Cuadro -----------------------------------------------------------------------
	

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		if (isset($this->s__filtro)) {
			$filtro=$this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_filtro_prestamo($filtro));
		} else {
			$sql=("SELECT 
			t_p.id_prestamo,
			t_pe.cuil_documento,
			t_pn.apyn,
			t_l.titulo,
			t_l.isbn,
			t_p.fecha_alta,
			t_p.plazo,
			t_p.fecha_venc,
			t_p.devolucion,
			t_p.fecha_devolucion,
			t_p.dias_retraso,
			CASE 
				WHEN t_p.devolucion='No' and ((current_date - t_p.fecha_venc) > 0)
				THEN (current_date - t_p.fecha_venc) ELSE 0
				END as retraso
			FROM curlib.prestamo as t_p LEFT OUTER JOIN curlib.libro as t_l ON (t_p.libro_id = t_l.id_libro),
			cidig.persona  as t_pe ,
			cidig.persona_natural as t_pn
			where (t_p.persona_id = t_pe.id_persona) 
			AND  (t_pe.id_persona = t_pn.id_persona) 
			AND t_p.devolucion = 'No'");
		$datos= toba::db()->consultar($sql);
			$cuadro->set_datos($datos);
		}
	}


	function evt__cuadro__eliminar($datos)
	{
		$this->rel()->tabla('prestamo')->resetear();
		$this->rel()->tabla('prestamo')->cargar($datos);
		$this->rel()->tabla('prestamo')->eliminar_todo();
		$this->rel()->tabla('prestamo')->resetear();
	}

	function estado_libro($id){
		$rs = ("SELECT libro_id 
		FROM curlib.prestamo
		where id_prestamo =" .$id);
		return toba::db()->consultar($rs);
	}

	function evt__cuadro__seleccion($datos)
	{
		$id_l = $this->estado_libro($datos['id_prestamo']);
		$this->rel()->tabla('libro')->cargar(array('id_libro'=>$id_l[0]['libro_id']));
		$this->rel()->tabla('prestamo')->cargar(array('id_prestamo'=>$datos['id_prestamo']));
		$this->set_pantalla('pant_devolucion');
		
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		
		$datos= $this->rel()->tabla('prestamo')->get();
		$form->set_datos($datos);
			//$form->set_datos($this->dep('datos')->tabla('persona_natural')->get());
	
	}



	function estado_libro_viejo($id){
		$rs = ("SELECT libro_id 
		FROM curlib.prestamo
		where id_prestamo =" .$id);
		return toba::db()->consultar($rs);
	}


	function evt__formulario__modificacion($datos)
	{
		$libro_nvo = intval($datos['libro_id']);
		$id_prestamo = $datos['id_prestamo'];
		$libros_vjo = $this->estado_libro_viejo($id_prestamo);
		//$libro_entero = $libros_ant[0]['libro_id'];


		if($libro_nvo !== $libros_vjo[0]['libro_id'])
		{
			//vamos con el libro nvo que cargue en el formulario
			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$libro_nvo));
			$fila_nvo = $this->rel()->tabla('libro')->get_filas();
			$fila_nvo[0]['id_estado'] = 2;
			$this->rel()->tabla('libro')->set($fila_nvo[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();

			//ahora con el libro viejo, que quedo en la base
			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$libros_vjo[0]['libro_id']));
			$fila_vjo = $this->rel()->tabla('libro')->get_filas();
			$fila_vjo[0]['id_estado'] = 1;
			$this->rel()->tabla('libro')->set($fila_vjo[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();

			//prestamo
			$this->rel()->tabla('prestamo')->set($datos);
			$this->rel()->tabla('prestamo')->sincronizar();
			$this->rel()->tabla('prestamo')->resetear();
			$this->informar_msg('Libro modificado con exito', 'info');
			$this->set_pantalla('pant_seleccion');
		
		}else{

			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$libro_nvo));
			$fila = $this->rel()->tabla('libro')->get_filas();
			$fila[0]['id_estado'] = 1;

			$this->dep('datos')->tabla('prestamo')->set($datos);
			$this->rel()->tabla('prestamo')->sincronizar();
			$this->rel()->tabla('prestamo')->resetear();


			$this->rel()->tabla('libro')->set($fila[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();
			$this->informar_msg('Libro devuelto con exito', 'info');
			$this->set_pantalla('pant_seleccion');
		}
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_seleccion');
	}

	//---- EVENTOS CI -------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver()
	{
		$this->resetear();
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

	
/*	function ajax__get_calcula_vto($dts, toba_ajax_respuesta $respuesta)
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

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(maiten_ei_filtro $filtro)
	{
		if (isset($this->s__filtro)) {
			$filtro->set_datos($this->s__filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cuadro__devolucion($seleccion)
	{
		$id_l = $this->estado_libro($seleccion['id_prestamo']);
		$this->rel()->tabla('libro')->cargar(array('id_libro'=>$id_l[0]['libro_id']));
		$this->rel()->tabla('prestamo')->cargar(array('id_prestamo'=>$seleccion['id_prestamo']));

		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_cantidad --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_cantidad(maiten_ei_cuadro $cuadro)
	{
	
			$sql=("SELECT 
			count(libro_id) as cantidad, 
			t_pe.cuil_documento 
			from curlib.prestamo as t_p
			INNER JOIN cidig.persona as t_pe ON t_p.persona_id = t_pe.id_persona
			WHERE (t_p.devolucion is null) OR (t_p.devolucion = 'No') 
			group by t_pe.cuil_documento");
			$datos=toba::db()->consultar($sql);
			$cuadro->set_datos($datos);
		
	}



	function conf_evt__cuadro__devolucion(toba_evento_usuario $evento, $fila)
	{

	}

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------


	//-----------------------------------------------------------------------------------
	//---- form_devolucion --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_devolucion(maiten_ei_formulario $form)
	{
		$datos= $this->rel()->tabla('prestamo')->get();
		$form->set_datos($datos);
	}

	function evt__form_devolucion__devolucion($datos)
	{
		$libro_nvo = intval($datos['libro_id']);
		$id_prestamo = $datos['id_prestamo'];
		$libros_vjo = $this->estado_libro_viejo($id_prestamo);
		//$libro_entero = $libros_ant[0]['libro_id'];


		if($libro_nvo !== $libros_vjo[0]['libro_id'])
		{
			//vamos con el libro nvo que cargue en el formulario
			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$libro_nvo));
			$fila_nvo = $this->rel()->tabla('libro')->get_filas();
			$fila_nvo[0]['id_estado'] = 2;
			$this->rel()->tabla('libro')->set($fila_nvo[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();

			//ahora con el libro viejo, que quedo en la base
			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$libros_vjo[0]['libro_id']));
			$fila_vjo = $this->rel()->tabla('libro')->get_filas();
			$fila_vjo[0]['id_estado'] = 1;
			$this->rel()->tabla('libro')->set($fila_vjo[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();

			//prestamo
			$this->rel()->tabla('prestamo')->set($datos);
			$this->rel()->tabla('prestamo')->sincronizar();
			$this->rel()->tabla('prestamo')->resetear();
			$this->informar_msg('Libro modificado con exito', 'info');
			$this->set_pantalla('pant_seleccion');
		
		}else{

			$this->rel()->tabla('libro')->cargar(array('id_libro'=>$libro_nvo));
			$fila = $this->rel()->tabla('libro')->get_filas();
			$fila[0]['id_estado'] = 1;

			$this->dep('datos')->tabla('prestamo')->set($datos);
			$this->rel()->tabla('prestamo')->sincronizar();
			$this->rel()->tabla('prestamo')->resetear();


			$this->rel()->tabla('libro')->set($fila[0]);
			$this->rel()->tabla('libro')->sincronizar();
			$this->rel()->tabla('libro')->resetear();
			$this->informar_msg('Libro devuelto con exito', 'info');
			$this->set_pantalla('pant_seleccion');
		}
	}

}
?>