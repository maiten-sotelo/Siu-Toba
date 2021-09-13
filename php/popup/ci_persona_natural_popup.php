<?php
class ci_persona_natural_popup extends maiten_ci
{

    protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- cuadro_persona_natural -------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_persona_natural(maiten_ei_cuadro $cuadro)
	{
        if (isset($this->s__filtro)) {
			$filtro=$this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_datos_persona_natural($filtro));
		} else {
		$cuadro->desactivar_modo_clave_segura();
		$sql = ("SELECT t_pn.id_persona_natural,
        t_p.id_persona,
        t_pn.apyn
		FROM
		cidig.persona_natural as t_pn LEFT OUTER JOIN cidig.persona as t_p ON (t_pn.id_persona_natural = t_p.id_persona)
	 limit 10;
	ORDER BY apyn");
		$datos=toba::db()->consultar($sql);
		$cuadro->set_datos($datos);
	
	}
	}



/*	static function get_persona_natural_pp($id=0)
	{
		$rs = toba::db()->consultar("SELECT apyn  FROM cidig.persona_natural WHERE id_persona = ".$id);
		$valor = "No se pudo identificar el Id. persona: ".$id;

		if(count($rs) > 0 ){
			$valor = $rs[0]['apyn'];
		}

		return $valor;
	}
*/

    function get_datos_persona_natural($where='')
	{
		$sql = "SELECT 
        t_pn.id_persona_natural,
        t_p.id_persona,
        t_pn.apyn
		FROM
		cidig.persona_natural as t_pn LEFT OUTER JOIN cidig.persona as t_p ON (t_pn.id_persona_natural = t_p.id_persona)
		WHERE  $where limit 10;";
return toba::db()->consultar($sql);
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