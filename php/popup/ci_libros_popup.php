<?php
class ci_libros_popup extends maiten_ci
{
	protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- cuadro_libros ----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_libros(maiten_ei_cuadro $cuadro)
	{
		if (isset($this->s__filtro)) {
			$filtro=$this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_datos_reportes_libros($filtro));
		} else {
		$cuadro->desactivar_modo_clave_segura();
		$sql = ("SELECT t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_g.descripcion as id_genero_descripcion,
		t_l.estante,
	
		t_l.anio,
		t_l.isbn,
		t_ad.descripcion as id_adquisicion_descripcion,
		t_es.descripcion as id_estado_nombre,
		t_l.ejemplar
		FROM
		curlib.libro as t_l LEFT OUTER JOIN curlib.estado as t_es ON (t_l.id_estado = t_es.id_estado),
		curlib.autor as t_a,
		curlib.editorial as t_e,
		curlib.adquisicion as t_ad, 
		curlib.genero as t_g 
		WHERE 
			t_l.id_autor = t_a.id_autor 
			AND t_l.id_editorial = t_e.id_editorial  
			AND t_l.id_estado = t_es.id_estado
			AND t_l.adquicision_id = t_ad.id_adquisicion
			AND t_l.id_genero = t_g.id_genero
			AND t_es.id_estado = 1
	ORDER BY titulo");
		$datos=toba::db()->consultar($sql);
		$cuadro->set_datos($datos);
	
    }
	}

	static function get_libro_pp($id = 0)
    {
        $rs = toba::db()->consultar("SELECT titulo FROM curlib.libro WHERE id_libro = ".$id);
        $valor = "No se pudo identificar el Id. libro: ".$id;
        if(count($rs) > 0 ){
            $valor = $rs[0]['titulo'];
		}
        return $valor;
    }



	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_datos_reportes_libros($where='')
    {
        $sql = "SELECT t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_g.descripcion as id_genero_descripcion,
		t_l.estante,
	
		t_l.anio,
		t_l.isbn,
		t_ad.descripcion as id_adquisicion_descripcion,
		t_es.descripcion as id_estado_nombre,
		t_l.ejemplar
		FROM
		curlib.libro as t_l LEFT OUTER JOIN curlib.estado as t_es ON (t_l.id_estado = t_es.id_estado),
		curlib.autor as t_a,
		curlib.editorial as t_e,
		curlib.adquisicion as t_ad, 
		curlib.genero as t_g 
		WHERE 
			t_l.id_autor = t_a.id_autor 
			AND t_l.id_editorial = t_e.id_editorial  
			AND t_l.id_estado = t_es.id_estado
			AND t_l.adquicision_id = t_ad.id_adquisicion
			AND t_l.id_genero = t_g.id_genero
			AND t_es.id_estado = 1
			AND $where;";
			return toba::db()->consultar($sql);
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

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

	function evt__cuadro_libros__seleccion($seleccion)
	{
	}

}
?>