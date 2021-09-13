<?php
class ci_reportes_libros extends maiten_ci
{
    protected $s__filtro;
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function get_datos_reportes_libros($where='')
    {
		$sql = "SELECT 	
        COUNT(t_l.id_libro) as ejemplares,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_l.estante,
		t_es.descripcion as id_estado_nombre,
		t_ad.descripcion as id_adquisicion_nombre,
		t_l.anio,
		t_g.descripcion as id_genero_nombre

		FROM
		curlib.libro as t_l LEFT OUTER JOIN cidig.estado as t_es ON (t_l.id_estado = t_es.id_estado),
		curlib.autor as t_a,
		curlib.editorial as t_e,
		curlib.adquisicion as t_ad,
		curlib.genero as t_g
		WHERE 
			t_l.id_autor = t_a.id_autor 
            AND t_l.id_editorial = t_e.id_editorial 
            AND t_l.adquicision_id = t_ad.id_adquisicion 
            AND t_l.id_genero = t_g.id_genero 
            AND $where						
	GROUP BY t_l.titulo,t_l.resumen,t_a.nombre ,t_e.nombre ,t_l.estante,t_es.descripcion ,t_ad.descripcion,t_l.anio,t_g.descripcion
	ORDER BY titulo ";	
		return toba::db('maiten')->consultar($sql);
    }


	
	function conf__cuadro(maiten_ei_cuadro $cuadro)
	{
        if (isset($this->s__filtro)) {
			$filtro=$this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_datos_reportes_libros($filtro));
		} else {
		$cuadro->desactivar_modo_clave_segura();
        $sql="SELECT 	
        COUNT(t_l.id_libro) as ejemplares,
        t_l.titulo,
        t_l.resumen,
        t_a.nombre as id_autor_nombre,
        t_e.nombre as id_editorial_nombre,
        t_l.estante,
        t_es.descripcion as id_estado_nombre,
        t_ad.descripcion as id_adquisicion_nombre,
        t_l.anio,
        t_g.descripcion as id_genero_nombre
        FROM
        curlib.libro as t_l LEFT OUTER JOIN cidig.estado as t_es ON (t_l.id_estado = t_es.id_estado),
        curlib.autor as t_a,
        curlib.editorial as t_e,
        curlib.adquisicion as t_ad,
        curlib.genero as t_g
        WHERE 
            t_l.id_autor = t_a.id_autor 
            AND t_l.id_editorial = t_e.id_editorial 
            AND t_l.adquicision_id = t_ad.id_adquisicion 
            AND t_l.id_genero = t_g.id_genero 			      
    GROUP BY t_l.titulo,t_l.resumen,t_a.nombre ,t_e.nombre ,t_l.estante,t_es.descripcion ,t_ad.descripcion,t_l.anio,t_g.descripcion
    ORDER BY titulo";
        $datos=toba::db()->consultar($sql);
        $cuadro->set_datos($datos);

	
    }
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(maiten_ei_filtro $filtro)
	{
        if (isset($this->s__filtro)) {
            $filtro->set_datos($this->s__filtro);
        }
	}

	function evt__filtro__filtrar($datos)
	{
        $this->s__filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
        unset($this->s__filtro);
	}

}
?>