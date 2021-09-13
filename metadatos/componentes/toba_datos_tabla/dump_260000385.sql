------------------------------------------------------------
--[260000385]--  DT - sexo 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 260
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'maiten', --proyecto
	'260000385', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'260000004', --punto_montaje
	'dt_sexo', --subclase
	'datos/dt_sexo.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'DT - sexo', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'maiten', --fuente_datos_proyecto
	'maiten', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2021-08-09 07:59:59', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 260

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'maiten', --objeto_proyecto
	'260000385', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'260000004', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'sexo', --tabla
	NULL, --tabla_ext
	NULL, --alias
	'0', --modificar_claves
	'maiten', --fuente_datos_proyecto
	'maiten', --fuente_datos
	'1', --permite_actualizacion_automatica
	'cidig', --esquema
	'cidig'  --esquema_ext
);

------------------------------------------------------------
-- apex_objeto_db_registros_col
------------------------------------------------------------

--- INICIO Grupo de desarrollo 260
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'maiten', --objeto_proyecto
	'260000385', --objeto
	'260000940', --col_id
	'id_sexo', --columna
	'E', --tipo
	'1', --pk
	'sexo_id_sexo_seq', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	'sexo'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'maiten', --objeto_proyecto
	'260000385', --objeto
	'260000941', --col_id
	'descripcion', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	'50', --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	'sexo'  --tabla
);
--- FIN Grupo de desarrollo 260
