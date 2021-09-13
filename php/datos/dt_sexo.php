<?php
class dt_sexo extends maiten_datos_tabla
{
    function get_descripciones()
    {
        $sql = "SELECT id_sexo, descripcion FROM cidig.sexo ORDER BY descripcion";
        return toba::db('maiten')->consultar($sql);
    }
}
?>