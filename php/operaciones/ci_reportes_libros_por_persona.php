<?php
class ci_reportes_libros_por_persona extends maiten_ci
{
	protected $s__filtro= null;
	protected $s__filtro_persona = null;
	protected $s__persona = 0;
	function rel()
	{
		return $this->dep('datos');
	}

    function get_datos_reportes_prestamos($where='')
    {
		$id = intval($this->s__persona);
        $sql = "SELECT 
		count(libro_id) as cantidad,
		t_pe.cuil_documento,
		t_p.persona_id,
		t_pn.apyn, string_agg(t_l.titulo, ' ,' ) as libros
		FROM curlib.prestamo as t_p
		INNER JOIN cidig.persona as t_pe on (t_p.persona_id = t_pe.id_persona)
		INNER JOIN curlib.libro as t_l on (t_p.libro_id = t_l.id_libro)
		INNER JOIN cidig.persona_natural t_pn on (t_pe.id_persona= t_pn.id_persona)
		WHERE t_p.persona_id = $id
		
		GROUP BY t_pe.cuil_documento, t_pn.apyn, t_p.persona_id";
return toba::db()->consultar($sql);
    }

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_persona($id=0){
		$rs = toba::db()->consultar("SELECT id_persona  FROM cidig.persona WHERE id_persona = ".$id);
	$valor = "No se pudo identificar el Id.Persona tipo: ".$id;

	if(count($rs) > 0 ){
		$valor = $rs[0]['id_persona'];
	}

	return $valor;
	}



	function conf__cuadro(maiten_ei_cuadro $cuadro)
	{
		$id = intval($this->s__persona);
		//var_dump($this->s__filtro);
		if (isset($this->s__filtro)) {
			$filtro=$this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_datos_reportes_prestamos($filtro));
			$id = intval($this->s__persona);
		} else {
			$sql=("SELECT 
			count(libro_id) as cantidad,
			t_pe.cuil_documento,
			t_p.persona_id,
			t_pn.apyn, string_agg(t_l.titulo, ' ,' ) as libros
			FROM curlib.prestamo as t_p
			INNER JOIN cidig.persona as t_pe on (t_p.persona_id = t_pe.id_persona)
			INNER JOIN curlib.libro as t_l on (t_p.libro_id = t_l.id_libro)
			INNER JOIN cidig.persona_natural t_pn on (t_pe.id_persona= t_pn.id_persona)
			WHERE t_p.persona_id = $id
			
			GROUP BY t_pe.cuil_documento, t_pn.apyn, t_p.persona_id");
			$datos=toba::db()->consultar($sql);
			$cuadro->set_datos($datos);

		}
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

	//-----------------------------------------------------------------------------------
	//---- cuadro_personas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_listados($where='')
	{
	
		$sql = "SELECT
		t_p.id_persona,
		t_p.cuil,
		t_p.cuil_documento,
		t_p.email,
		t_n.descripcion as id_nacionalidad_descripcion,
		t_pn.apyn
		
	FROM
		cidig.persona as t_p INNER JOIN cidig.nacionalidad as t_n ON (t_p.id_nacionalidad_d = t_n.id_nacionalidad),
		cidig.persona_natural as t_pn
	WHERE 
		t_p.id_persona = t_pn.id_persona
		AND $where
		LIMIT 10;";
return toba::db()->consultar($sql);
	}



	function conf__cuadro_personas(maiten_ei_cuadro $cuadro)
	{
		if(isset($this->s__filtro_persona)){
			$filtro=$this->dep('filtro_personas')->get_sql_where();
			$datos=$this->get_listados($filtro);
			$cuadro->set_datos($datos);
		}else{	
		$sql="SELECT
		t_p.id_persona,
		t_p.cuil,
		t_p.cuil_documento,
		t_p.email,
		t_n.descripcion as id_nacionalidad_descripcion,
		t_pn.apyn
	FROM
		cidig.persona as t_p INNER JOIN cidig.nacionalidad as t_n ON (t_p.id_nacionalidad_d = t_n.id_nacionalidad),
		cidig.persona_natural as t_pn
	WHERE 
		t_p.id_persona = t_pn.id_persona
	limit 10;";
		$datos=toba::db()->consultar($sql);
		$cuadro->set_datos($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- filtro_personas --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro_personas(maiten_ei_filtro $filtro)
	{
		if (isset($this->s__filtro)) {
            $filtro->set_datos($this->s__filtro_persona);
        }
	}

	function evt__filtro_personas__filtrar($datos)
	{
		$this->s__filtro_persona = $datos;
	}

	function evt__filtro_personas__cancelar()
	{
		unset($this->s__filtro_persona);
	}

	function evt__cuadro_personas__seleccion($seleccion)
	{
		$this->s__persona = $seleccion['id_persona'];
		$this->set_pantalla('pant_inicial');
		//ei_arbol($this->s__persona);
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__cancelar()
	{
		$this->set_pantalla('pant_seleccion');
	}

	function evt__eliminar()
	{
		$this->resetear();
	}

}
?>