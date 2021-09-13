
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	'Administrador', --nombre
	'0', --nivel_acceso
	'Accede a toda la funcionalidad', --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'1', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'1'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 260
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000049'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000068'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000070'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000075'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000078'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000079'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000080'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000081'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000082'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000083'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000084'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000085'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000088'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000094'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000096'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'maiten', --proyecto
	'admin', --usuario_grupo_acc
	NULL, --item_id
	'260000097'  --item
);
--- FIN Grupo de desarrollo 260
