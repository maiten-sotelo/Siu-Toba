<?php
class ci_gestion_genero extends maiten_ci
{
	protected $s__filtro;

	function rel() 
	{
		return $this->dep('datos'); 
	}
	
	function get_filtro_genero($where='')
	{
		$limite = 'LIMIT 100';

        if($where != '1=1') {
            $limite = ' LIMIT 1000 ';
        }

        $sql = "SELECT
			t_g.id_genero,
			t_g.descripcion,
			t_e.descripcion as id_estado_descripcion
    FROM
	curlib.genero as t_g
	LEFT OUTER JOIN estado as t_e ON (t_g.id_estado = t_e.id_estado)
    WHERE ".$where."
    ORDER BY 1 ".$limite;
return toba::db()->consultar($sql);
	}


	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
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
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(maiten_ei_cuadro $cuadro)
	{
		if (isset($this->s__filtro)) {
			$filtro=$this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_filtro_genero($filtro));
		} else {
		$cuadro->desactivar_modo_clave_segura();
		$sql = ("SELECT 
		t_g.id_genero,
		t_g.descripcion,
		t_es.descripcion as id_estado_descripcion
		FROM
		curlib.genero as t_g LEFT OUTER JOIN curlib.estado as t_es ON (t_g.id_estado = t_es.id_estado)
	ORDER BY descripcion");
		$datos=toba::db()->consultar($sql);
		$cuadro->set_datos($datos);	
	
    }
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->rel()->cargar($seleccion);
		$this->rel('datos')->tabla('genero')->set_cursor(0);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__formulario(maiten_ei_formulario $form)
	{
		if ($this->rel()->tabla('genero')->hay_cursor())
		{
			$form->set_datos($this->rel()->tabla('genero')->get());
		}else{
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('genero')->set($datos);
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

	function evt__volver()
	{
		$this->set_pantalla('pant_seleccion');
	}

}
?>