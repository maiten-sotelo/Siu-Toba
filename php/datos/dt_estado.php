<?php
class dt_estado extends maiten_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_e.id_estado,
			t_e.descripcion,
			t_e.mod_prog
		FROM
			estado as t_e
		ORDER BY descripcion";
		return toba::db('libros')->consultar($sql);
	}

		function get_descripciones()
		{
			$sql = "SELECT id_estado, descripcion FROM estado ORDER BY descripcion";
			return toba::db('maiten')->consultar($sql);
		}





























}
?>