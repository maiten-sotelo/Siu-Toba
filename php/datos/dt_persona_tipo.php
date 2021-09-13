<?php
class dt_persona_tipo extends maiten_datos_tabla
{
    function get_descripciones()
    {
        $sql = "SELECT id_persona_tipo, descripcion FROM cidig.persona_tipo ORDER BY descripcion";
        return toba::db('maiten')->consultar($sql);
    }
}

?>