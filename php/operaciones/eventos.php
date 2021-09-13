<?php
class eventos extends maiten_ei_cuadro
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
			/*if(this.ef('devolucion').get_estado() == 'No')
			{
				this.ef('devolucion').ocultar();
			}*/
			//this.ef('devolucion').set_solo_lectura();
		}
		
		{$this->objeto_js}.evt__devolucion = function()
		{
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__devolucion__procesar = function(es_inicial)
		{
		}
		
		{$this->objeto_js}.evt__fecha_devolucion__procesar = function(es_inicial)
		{
		}
		
		{$this->objeto_js}.evt__dias_retraso__procesar = function(es_inicial)
		{
		}
		";
	}


}
?>