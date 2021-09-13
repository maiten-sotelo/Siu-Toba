<?php
class dt_nacionalidad extends maiten_datos_tabla
{
    function get_descripciones()
    {
        $sql = "SELECT id_nacionalidad, descripcion FROM cidig.nacionalidad ORDER BY descripcion";
        return toba::db('maiten')->consultar($sql);
    }
}

?>