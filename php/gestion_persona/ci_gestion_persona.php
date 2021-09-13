<?php
class ci_gestion_persona extends maiten_ci
{
	protected $s__filtro;

	function rel()
    {
        return $this->dep('datos');
    }
    

	//---- Filtro -----------------------------------------------------------------------
	function get_listados($where='')
	{
	
		$sql = "SELECT
		t_pn.apyn,
		t_p.id_persona,
		t_pt.descripcion as id_persona_tipo_descripcion,
		t_p.cuil_tipo,
		t_p.cuil_documento,
		t_p.cuil_digito,
		t_p.cuil,
		t_c.descripcion as id_cond_fiscal_descripcion,
		t_p.email,
		t_e.descripcion as estado,
		t_d.descripcion as id_tipo_documento_descripcion,
		t_n.descripcion as id_nacionalidad_descripcion,
		t_p.control_doc,
		t_pn.fe_nac as id_persona_natural_fe_nac,
		t_pn.ciudad_nac as id_persona_natural_ciudad_nac,
		t_pn.provincia_nac as id_persona_natural_provincia_nac,
		t_s.descripcion as sexo
					
	FROM
		cidig.persona as t_p INNER JOIN cidig.nacionalidad as t_n ON (t_p.id_nacionalidad_d = t_n.id_nacionalidad)
		INNER JOIN cidig.persona_tipo as t_pt ON (t_p.id_persona_tipo = t_pt.id_persona_tipo)
		LEFT OUTER JOIN cidig.cond_fiscal as t_c ON (t_p.id_cond_fiscal = t_c.id_cond_fiscal)
		INNER JOIN cidig.estado as t_e ON (t_p.id_estado = t_e.id_estado)
		INNER JOIN cidig.tipo_documento as t_d ON (t_p.id_tipo_documento = t_d.id_tipo_documento)
		INNER JOIN cidig.persona_natural as t_pn ON (t_p.id_persona = t_pn.id_persona)
		LEFT JOIN cidig.sexo as t_s ON (t_pn.id_sexo = t_s.id_sexo)
		
	WHERE $where 
		LIMIT 10";
return toba::db()->consultar($sql);
	}


	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		if(isset($this->s__filtro)){
			$filtro=$this->dep('filtro')->get_sql_where();
			$datos=$this->get_listados($filtro);
			$cuadro->set_datos($datos);
		}else{	
		$sql="SELECT
		t_pn.apyn,
		t_p.id_persona,
		t_pt.descripcion as id_persona_tipo_descripcion,
		t_p.cuil_tipo,
		t_p.cuil_documento,
		t_p.cuil_digito,
		t_p.cuil,
		t_c.descripcion as id_cond_fiscal_descripcion,
		t_p.email,
		t_e.descripcion as estado,
		t_d.descripcion as id_tipo_documento_descripcion,
		t_n.descripcion as id_nacionalidad_descripcion,
		t_p.control_doc,
		t_pn.fe_nac as id_persona_natural_fe_nac,
		t_pn.ciudad_nac as id_persona_natural_ciudad_nac,
		t_pn.provincia_nac as id_persona_natural_provincia_nac,
		t_s.descripcion as sexo
					
	FROM
		cidig.persona as t_p INNER JOIN cidig.nacionalidad as t_n ON (t_p.id_nacionalidad_d = t_n.id_nacionalidad)
		INNER JOIN cidig.persona_tipo as t_pt ON (t_p.id_persona_tipo = t_pt.id_persona_tipo)
		LEFT OUTER JOIN cidig.cond_fiscal as t_c ON (t_p.id_cond_fiscal = t_c.id_cond_fiscal)
		INNER JOIN cidig.estado as t_e ON (t_p.id_estado = t_e.id_estado)
		INNER JOIN cidig.tipo_documento as t_d ON (t_p.id_tipo_documento = t_d.id_tipo_documento)
		INNER JOIN cidig.persona_natural as t_pn ON (t_p.id_persona = t_pn.id_persona)
		LEFT JOIN cidig.sexo as t_s ON (t_pn.id_sexo = t_s.id_sexo)
		LIMIT 10";
		$datos=toba::db()->consultar($sql);
		$cuadro->set_datos($datos);
		}
	}

	function evt__cuadro__eliminar($datos)
	{
		$this->dep('datos')->resetear();
		$this->dep('datos')->cargar($datos);
		$this->dep('datos')->eliminar_todo();
		$this->dep('datos')->resetear();
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->rel()->cargar($datos);
		$this->set_pantalla('pant_edicion');
		//ei_arbol($datos);
		//exit();
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if($this->rel()->tabla('persona')->get_cantidad_filas() > 0)
		{
			if($this->rel()->tabla('persona')->get_columna('id_persona_tipo') == 1){ #- Caso Persona Natural
				$datos = $this->rel()->tabla('persona')->get() + $this->rel()->tabla('persona_natural')->get();
			}
			
		}else{

			$this->pantalla()->eliminar_evento('eliminar');
		}
			$form->ef('apyn')->set_estado($datos['apyn']);
			$form->ef('id_persona_natural_fe_nac')->set_estado($datos['fe_nac']);
			$form->ef('id_persona_natural_ciudad_nac')->set_estado($datos['ciudad_nac']);
			$form->ef('id_persona_natural_provincia_nac')->set_estado($datos['provincia_nac']);
			//$form->ef('sexo')->set_estado($datos['id_sexo']);
			$form->set_datos($datos);
			//ei_arbol($datos);
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('persona')->set($datos);
		$this->rel()->tabla('persona_natural')->set($datos);
		$this->dep('datos')->sincronizar();
		$this->resetear();
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

}
?>