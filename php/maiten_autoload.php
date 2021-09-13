<?php
/**
 * Esta clase fue y ser� generada autom�ticamente. NO EDITAR A MANO.
 * @ignore
 */
class maiten_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'maiten_ci' => 'extension_toba/componentes/maiten_ci.php',
		'maiten_cn' => 'extension_toba/componentes/maiten_cn.php',
		'maiten_datos_relacion' => 'extension_toba/componentes/maiten_datos_relacion.php',
		'maiten_datos_tabla' => 'extension_toba/componentes/maiten_datos_tabla.php',
		'maiten_ei_arbol' => 'extension_toba/componentes/maiten_ei_arbol.php',
		'maiten_ei_archivos' => 'extension_toba/componentes/maiten_ei_archivos.php',
		'maiten_ei_calendario' => 'extension_toba/componentes/maiten_ei_calendario.php',
		'maiten_ei_codigo' => 'extension_toba/componentes/maiten_ei_codigo.php',
		'maiten_ei_cuadro' => 'extension_toba/componentes/maiten_ei_cuadro.php',
		'maiten_ei_esquema' => 'extension_toba/componentes/maiten_ei_esquema.php',
		'maiten_ei_filtro' => 'extension_toba/componentes/maiten_ei_filtro.php',
		'maiten_ei_firma' => 'extension_toba/componentes/maiten_ei_firma.php',
		'maiten_ei_formulario' => 'extension_toba/componentes/maiten_ei_formulario.php',
		'maiten_ei_formulario_ml' => 'extension_toba/componentes/maiten_ei_formulario_ml.php',
		'maiten_ei_grafico' => 'extension_toba/componentes/maiten_ei_grafico.php',
		'maiten_ei_mapa' => 'extension_toba/componentes/maiten_ei_mapa.php',
		'maiten_servicio_web' => 'extension_toba/componentes/maiten_servicio_web.php',
		'maiten_comando' => 'extension_toba/maiten_comando.php',
		'maiten_modelo' => 'extension_toba/maiten_modelo.php',
	);
}
?>