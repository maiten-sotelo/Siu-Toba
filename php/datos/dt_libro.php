<?php
class dt_libro extends maiten_datos_tabla
{

	
	function get_listado($filtro=array())
	{
		$where = array();
		$sql = "SELECT
			t_l.id_libro,
			t_l.titulo,
			t_l.resumen,
			t_a.nombre as id_autor_nombre,
			t_e.nombre as id_editorial_nombre,
			t_l.estante,
			t_e1.descripcion as id_estado_nombre
		FROM
			libro as t_l	LEFT OUTER JOIN estado as t_e1 ON (t_l.id_estado = t_e1.id_estado),
			autor as t_a,
			editorial as t_e
		WHERE
				t_l.id_autor = t_a.id_autor
			AND  t_l.id_editorial = t_e.id_editorial
		ORDER BY titulo";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('maiten')->consultar($sql);
	}



	/*--------------------------------------REPORTES----------------------------------------*/

	function get_datos_reportes_libros($where='')
	{
		$limite = 'LIMIT 100';

		if($where != '1=1') {
			$limite = ' LIMIT 1000 ';
		}

		$sql = "SELECT
		t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_l.estante,
		t_l.id_estado
	FROM
		libro as t_l LEFT OUTER JOIN autor as t_a ON (t_l.id_autor = t_a.id_autor)
		LEFT OUTER JOIN editorial as t_e ON (t_l.id_editorial = t_e.id_editorial)
	WHERE ".$where."
	ORDER BY 1 ".$limite;
return toba::db()->consultar($sql);
	}





}
?>