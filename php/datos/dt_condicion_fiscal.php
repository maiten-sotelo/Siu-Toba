<?php
class dt_condicion_fiscal extends maiten_datos_tabla
{
    function get_descripciones()
    {
        $sql = "SELECT id_cond_fiscal, descripcion FROM cidig.cond_fiscal ORDER BY descripcion";
        return toba::db('maiten')->consultar($sql);
    }
}

?>