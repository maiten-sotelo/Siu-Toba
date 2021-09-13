<?php
class dt_genero extends maiten_datos_tabla
{
    function get_descripciones()
    {
        $sql = "SELECT id_genero, descripcion FROM genero ORDER BY descripcion";
        return toba::db('maiten')->consultar($sql);
    }

    function get_listado($filtro=array())
	{
		$where = array();
	
		$sql = "SELECT
			t_g.id_genero,
			t_g.descripcion,
			t_e.descripcion as id_estado_nombre
		FROM
			curlib.genero as t_g
            LEFT OUTER JOIN estado as t_e ON (t_g.id_estado = t_e.id_estado)
		ORDER BY t_g.descripcion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('maiten')->consultar($sql);
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
			t_e.descripcion as id_estado_nombre
    FROM
	curlib.genero as t_g
	LEFT OUTER JOIN estado as t_e ON (t_g.id_estado = t_e.id_estado)
    WHERE ".$where."
    ORDER BY 1 ".$limite;
return toba::db()->consultar($sql);
	}
}
?>