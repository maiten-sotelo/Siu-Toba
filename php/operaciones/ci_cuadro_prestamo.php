<?php
class ci_cuadro_prestamo extends maiten_ei_cuadro
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__seleccion = function()
		{
			this.ef('fecha_devolucion')->ocultar();
			this.ef('dias_retraso')->ocultar();
		}
		";
	}

}
?>