<?php
class fecha extends maiten_ei_formulario
{
	
	
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		$rs = toba::db()->consultar("SELECT * FROM curlib.libro LIMIT 1");
		
		if ($_SERVER['SERVER_NAME'] == 'localhost')
		{
			$destino = 'D:/toba_2.7.4/proyectos/maiten/www/img/imagenes/return2530.png';
		}
		else
		{
			$destino = '/var/www'.$rs[0]['foto'];
			if(($_SERVER['SERVER_NAME'] == '172.25.50.200') xor  ($_SERVER['SERVER_NAME'] == '192.168.10.200')  )
			{
				$destino = 'http://'.$_SERVER['SERVER_NAME'].$rs[0]['foto'];
			} 
			else
			{
				$destino = 'https://'.$_SERVER['SERVER_NAME'].$rs[0]['foto'];
			} 
		} 
		
		echo "
		//---- Procesamiento de EFs --------------------------------
		function fe_inicial()
		{ 
			var ubi_foto = '$destino'; 
			return ubi_foto;
		}
		
		{$this->objeto_js}.evt__plazo__procesar = function(es_inicial)
		{
			if(this.ef('plazo').get_estado() !== ''){
				dias = this.ef('plazo').get_estado()
				diaI = parseInt(dias, 10)
				const fecha = new Date()
				fecha.setDate(fecha.getDate() + diaI)
				fecha2 = fecha.toLocaleDateString()
				this.ef('fecha_venc').set_estado(fecha2)
			}
		
			/*if(!es_inicial)
			{
				if(this.ef('plazo').get_estado() != '' && this.ef('fecha_alta').get_estado() != '') 
				{
					dts = new Array;
					dts['plazo'] = this.ef('plazo').get_estado();
					dts['fecha_alta'] = this.ef('fecha_alta').get_estado();
					this.controlador.ajax('get_calcula_vto', dts, this, this.datos_vto);					
				} 
			} */
		}
		
		
		{$this->objeto_js}.datos_vto = function(rs)
		{ 
			/*if(rs != '') 
			{
				this.ef('fecha_venc').set_estado(rs);    
			}*/
		}
		
		
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__dias_retraso__procesar = function(es_inicial)
		{
			if(this.ef('devolucion').get_estado() == 'Si')
			{
				var f1 = this.ef('fecha_venc').get_estado();
				var f2 = this.ef('fecha_devolucion').get_estado();
				var aFecha1 = f1.split('/');
				var aFecha2 = f2.split('/');
				var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
				var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
				var dif = fFecha2 - fFecha1;
				var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
				if(dias > 0)
				{
				this.ef('dias_retraso').set_estado(dias)
				}else{
					this.ef('dias_retraso').set_estado(0)
				}
			}
		
		}
		
		
		{$this->objeto_js}.datos_dev = function(rs)
		{ 
			
			//this.ef('dias_retraso').set_estado(rs); 
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__devolucion__procesar = function(es_inicial)
		{
			if(this.ef('devolucion').get_estado() == 'No')
			{
				this.ef('fecha_devolucion').ocultar();
				this.ef('dias_retraso').ocultar();
				this.ef('div').ocultar();
			}else{
				this.ef('fecha_devolucion').mostrar();
				this.ef('dias_retraso').mostrar();
				this.ef('div').mostrar();				
		}
		}
		
		{$this->objeto_js}.evt__fecha_devolucion__procesar = function(es_inicial)
		{
			if(this.ef('devolucion').get_estado() == 'Si')
			{
				const f = new Date();
				fecha = f.toLocaleDateString();
				this.ef('fecha_devolucion').set_estado(fecha);
				
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__fecha_venc__procesar = function(es_inicial)
		{
			/*var fecha = '05/08/2021';
			var dias = 2;
			var cal = fecha.getDate() + dias;
			this.ef('fecha_venc').set_estado(cal);*/
		}
		//---- Eventos ---------------------------------------------
		
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__fecha_alta__procesar = function(es_inicial)
		{
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__libro_id__procesar = function(es_inicial)
		{
			if(this.ef('libro_id').get_estado() != ''){
				const f = new Date();
				fecha = f.toLocaleDateString();
				this.ef('fecha_alta').set_estado(fecha);			
			}
		
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__foto__procesar = function(es_inicial)
		{
		}
		";
	}











}
?>