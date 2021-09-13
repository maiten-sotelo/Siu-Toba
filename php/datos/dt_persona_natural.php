<?php
class dt_persona_natural extends maiten_datos_tabla
{
    function get_descripciones()
    {
        $sql = "SELECT id_persona_natural, apyn FROM cidig.persona_natural ORDER BY apyn";
        return toba::db('maiten')->consultar($sql);
    }

}

?>