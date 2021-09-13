<?php
class dt_autor extends maiten_datos_tabla
{
		function get_descripciones()
		{
			$sql = "SELECT id_autor, nombre FROM autor ORDER BY nombre";
			return toba::db('maiten')->consultar($sql);
		}

	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['nombre'])) {
			$where[] = "nombre ILIKE ".quote("%{$filtro['nombre']}%");
		}
		if (isset($filtro['id_estado'])) {
			$where[] = "id_estado = ".quote($filtro['id_estado']);
		}
		$sql = "SELECT
			t_a.id_autor,
			t_a.nombre,
			t_e.descripcion as id_estado_nombre
		FROM
			autor as t_a	LEFT OUTER JOIN estado as t_e ON (t_a.id_estado = t_e.id_estado)
		ORDER BY nombre";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('maiten')->consultar($sql);
	}



}
?>