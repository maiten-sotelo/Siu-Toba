<?php
class ci_personas_popup extends maiten_ci
{
	protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- cuadro_persona ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_persona(maiten_ei_cuadro $cuadro)
	{
		if(isset($this->s__filtro)){
			$filtro=$this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_filtro_persona($filtro));
		} else {
			$cuadro->desactivar_modo_clave_segura();
			$sql="SELECT t_p.id_persona,  
			t_p.cuil_tipo, 
			t_p.cuil_documento, 
			t_pn.apyn,
			t_p.cuil_digito, 
			t_p.cuil, 
			t_p.email, 
			t_p.control_doc,
			t_f.descripcion as id_cond_fiscal_descripcion,
			t_e.descripcion as id_estado_descripcion,
			t_n.descripcion as id_nacionalidad_descripcion,
			t_pt.descripcion as id_persona_tipo_descripcion,
			t_d.descripcion as id_tipo_documento_descripcion
   FROM 
   cidig.persona as t_p LEFT OUTER JOIN cidig.nacionalidad as t_n ON (t_p.id_nacionalidad_d = t_n.id_nacionalidad),
		cidig.tipo_documento as t_d,
		cidig.estado as t_e,
		cidig.persona_tipo as t_pt,
		cidig.cond_fiscal as t_f ,
		cidig.persona_natural as t_pn
   WHERE 
   		t_p.id_tipo_documento = t_d.id_tipo_documento
		and t_p.id_estado = t_e.id_estado
		and t_p.id_persona_tipo = t_pt.id_persona_tipo
		and t_p.id_cond_fiscal = t_f.id_cond_fiscal
   		and t_p.id_nacionalidad_d = t_n.id_nacionalidad 
		and (t_p.id_persona = t_pn.id_persona)
		    limit 20";
		$datos=toba::db()->consultar($sql);
		$cuadro->set_datos($datos);
	}

	}

	static function get_persona_pp($id=0)
	{
		$rs = toba::db()->consultar("SELECT cuil_documento  FROM cidig.persona WHERE id_persona = ".$id);
		$valor = "No se pudo identificar el Id. persona: ".$id;

		if(count($rs) > 0 ){
			$valor = $rs[0]['cuil_documento'];
		}

		return $valor;
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------

	function get_filtro_persona($where='')
	{
		$sql = "SELECT
		t_p.id_persona,
		t_pn.apyn,
		t_p.control_doc,
		t_p.cuil,
		t_p.cuil_digito,
		t_p.cuil_documento,
		t_p.cuil_tipo,
		t_p.email,
		t_f.descripcion as id_cond_fiscal_descripcion,
		t_e.descripcion as id_estado_descripcion,
		t_n.descripcion as id_nacionalidad_descripcion,
		t_pt.descripcion as id_persona_tipo_descripcion,
		t_d.descripcion as id_tipo_documento_descripcion	
	FROM
		cidig.persona as t_p LEFT OUTER JOIN cidig.nacionalidad as t_n ON (t_p.id_nacionalidad_d = t_n.id_nacionalidad),
		cidig.tipo_documento as t_d,
		cidig.estado as t_e,
		cidig.persona_tipo as t_pt,
		cidig.cond_fiscal as t_f,
		cidig.persona_natural as t_pn
	WHERE 
		(t_p.id_tipo_documento = t_d.id_tipo_documento)
		AND (t_p.id_estado = t_e.id_estado)
		AND (t_p.id_persona_tipo = t_pt.id_persona_tipo)
		AND (t_p.id_cond_fiscal = t_f.id_cond_fiscal)
		AND (t_p.id_persona = t_pn.id_persona_natural)
		AND $where
	limit 10;";
return toba::db()->consultar($sql);

	}

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