<?php
class ci_reportes_prestamos extends maiten_ci
{
    protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

    function get_datos_reportes_prestamos($where='')
    {
        $sql = "SELECT 
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
		AND $where;";
		return toba::db()->consultar($sql);
    }


	function conf__cuadro(maiten_ei_cuadro $cuadro)
	{
		if (isset($this->s__filtro)) {
			$filtro=$this->dep('filtro')->get_sql_where();
			
			$cuadro->set_datos($this->get_datos_reportes_prestamos($filtro));
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
			AND  (t_pe.id_persona = t_pn.id_persona) ");
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

}

?>