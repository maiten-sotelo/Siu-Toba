<?php
class dt_tipo_documento extends maiten_datos_tabla
{
    
		function get_descripciones()
		{
			$sql = "SELECT id_tipo_documento, descripcion FROM cidig.tipo_documento ORDER BY descripcion";
			return toba::db('maiten')->consultar($sql);
		}
}

?>