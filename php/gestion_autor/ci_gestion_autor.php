<?php
class ci_gestion_autor extends maiten_ci
{
	protected $s__filtro;
	//---- Filtro -----------------------------------------------------------------------

	function get_filtro_autor($where='')
	{
		$limite = 'LIMIT 100';

        if($where != '1=1') {
            $limite = ' LIMIT 1000 ';
        }
        $sql = "SELECT
			t_a.id_autor,
			t_a.nombre,
			t_e.descripcion as id_estado_nombre
    FROM
	autor as t_a	LEFT OUTER JOIN estado as t_e ON (t_a.id_estado = t_e.id_estado)
    WHERE ".$where."
    ORDER BY 1 ".$limite;
return toba::db()->consultar($sql);
	}

	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
        $filtro = $this->dep('filtro')->get_sql_where();
        $datos = $this->get_filtro_autor($filtro);
        $cuadro->set_datos($datos);
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
		$this->dep('datos')->cargar($datos);
		$this->set_pantalla('pant_edicion');
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			$form->set_datos($this->dep('datos')->tabla('autor')->get());
		} else {
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('autor')->set($datos);
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