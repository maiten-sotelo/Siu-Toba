<?php
class dt_persona extends maiten_datos_tabla
{
	function get_listado($filtro=array())
	{
		
		$where = array();		
		$sql = "SELECT
		t_p.id_persona,
		t_p.control_doc,
		t_p.cuil,
		t_p.cuil_digito,
		t_p.cuil_documento,
		t_p.cuil_tipo,
		t_p.email,
		t_p.id_cond_fiscal,
		t_p.id_estado,
		t_n.descripcion as id_nacionalidad_descripcion,
		t_p.id_persona_tipo,
		t_d.descripcion as id_tipo_documento_descripcion
		
	FROM
		cidig.persona as t_p
		LEFT OUTER JOIN cidig.nacionalidad as t_n ON (t_p.id_nacionalidad_d = t_n.id_nacionalidad),
		cidig.tipo_documento as t_d
	WHERE
		t_p.id_tipo_documento = t_d.id_tipo_documento
		limit 10";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('maiten')->consultar($sql);
	}

	function get_descripciones()
	{
		$sql = "SELECT id_estado, descripcion, mod_prog FROM cidig.estado ORDER BY descripcion";
		return toba::db('maiten')->consultar($sql);
	}

/*	function get_descripciones_estado()
    {
        $sql = "SELECT id_estado, descripcion FROM cidig.estado ORDER BY descripcion";
        return toba::db('maiten')->consultar($sql);
    }*/

}
?>