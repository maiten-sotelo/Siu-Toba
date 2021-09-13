<?php
class ci_gestion_de_libros extends maiten_ci
{
	protected $s__filtro;
	protected $s__path_inicial;
	protected $s__nom_img;
	function rel()
	{
		return $this->dep('datos');
	}


	//---- Filtro -----------------------------------------------------------------------
	function get_datos_reportes_libros($where = '')
	{
		$sql = "SELECT	t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_l.estante,
		t_es.descripcion as id_estado_nombre,
		t_ad.descripcion as id_adquisicion_descripcion,
		t_l.anio,
		t_g.descripcion as id_genero_nombre,
		t_l.isbn,
		t_l.foto
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
	ORDER BY titulo";
		return toba::db()->consultar($sql);
	}


	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		if (isset($this->s__filtro)) {
			$filtro = $this->dep('filtro')->get_sql_where();
			$cuadro->set_datos($this->get_datos_reportes_libros($filtro));
		} else {
			$cuadro->desactivar_modo_clave_segura();
			$sql = ("SELECT count(id_libro) as ejemplar,
		t_l.id_libro,
		t_l.titulo,
		t_l.resumen,
		t_a.nombre as id_autor_nombre,
		t_e.nombre as id_editorial_nombre,
		t_es.descripcion id_estado_nombre,
		t_ad.descripcion as id_adquisicion_descripcion,
		t_g.descripcion id_genero_nombre,
		t_l.anio,
		t_l.estante,
		t_l.foto
		from curlib.libro as t_l
		INNER JOIN curlib.autor as t_a on (t_l.id_autor = t_a.id_autor)
		INNER JOIN curlib.editorial as t_e on (t_l.id_editorial = t_e.id_editorial)
		INNER JOIN curlib.estado as t_es on (t_l.id_estado = t_es.id_estado)
		INNER JOIN curlib.adquisicion as t_ad on (t_l.adquicision_id = t_ad.id_adquisicion)
		INNER JOIN curlib.genero as t_g on (t_l.id_genero = t_g.id_genero)
		group by t_l.id_libro, t_l.id_libro, t_l.titulo, t_l.resumen, t_a.nombre, t_e.nombre, t_es.descripcion, 
		t_ad.descripcion, t_g.descripcion, t_l.anio, t_l.estante, t_l.foto");
			$datos = toba::db()->consultar($sql);
			/* $img_pendiente = toba_recurso::imagen_proyecto('img/imagenes/', true);
		$datos=  $img_pendiente; */
			//$datos[0]['imghtml'] = $img_pendiente;
			$cuadro->set_datos($datos);
		}
	}

	function evt__cuadro__eliminar($datos)
	{
		$this->dep('datos')->resetear();
		$this->dep('datos')->cargar($datos);
		$this->dep('datos')->eliminar_todo();
		$this->dep('datos')->resetear();
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->rel()->cargar($datos);
		$this->rel()->tabla('libro')->set_cursor(0);
		$nombre_img = toba::db()->consultar("SELECT foto FROM curlib.libro where id_libro= '$datos[id_libro]'");
		$this->s__nom_img = $nombre_img;

		$this->set_pantalla('pant_edicion');
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			$form->set_datos($this->dep('datos')->tabla('libro')->get());
			$path_final = 'img/imagenes/';
			$ruta_inicial = $this->s__path_inicial['path'];
			$ruta = $ruta_inicial;
			$nom_imagen = $this->s__nom_img;
			$img = $ruta . $nom_imagen[0]['foto'];
			$form->ef('imagen')->set_estado("<img src= '$img' width=100px height=auto>");
		} else {
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}


	function resetear()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_seleccion');
	}

	//---- EVENTOS CI -------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver()
	{
		$this->resetear();
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->resetear();
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

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__formulario__alta($datos)
	{
		//declaro la variable que tendra la imagen que se carga por defecto, si va vacio el upload
		$img_no_cargada = 'sinimagen.png';
		//delcaro el nombre de la variable a guardar
		$foto_guardar = "";
		//declaro la variable a trabajar sobre el archivo temporarl
		$foto_tmp = "";
		//declaro la variable con el arreglo de la foto del upload
		$imagen_a_tratar = ($datos['imagen']);
		//declaro la ruta donde voy a guardar las fotos
		$ruta_final = 'img/imagenes/';

		//obtengo la ruta inicial del archivo
		$this->s__path_inicial = toba::proyecto()->get_www($ruta_final);

		//declaro la ruta inicial del archivo
		$ruta_inicial = $this->s__path_inicial['path'];

		$path = $ruta_inicial;

		//pregunto si existe el fichero donde voy a guardar los archivos
		if (!file_exists($path)) {
			//si no existe la ruta, la creo y doy permisos de adm
			mkdir($path);
			//doy peromisos de adm
			chmod($path, 0777);
		}
		//guardo el nombre de la imagen
		$nombre_img = basename($datos['imagen']['name']);
		//hago el if para preguntar si la imagen va vacia
		//guardo el nombre del archivo temporal

		$foto_tmp = $datos['imagen']['tmp_name'];

		if ($nombre_img !== '') {
			//creo un numero aletario para el nombre del archivo
		$num_ram = mt_rand(0, 10000);
		$foto_guardar = $ruta_final . $nombre_img;
		//separo la ruta a partir del punto
		$arreglo = explode(".", $foto_guardar);
		//concateno el numero aleatorio y lo guardo en $foto_guardar
		$foto_guardar = $arreglo[0] . $num_ram . "." . $arreglo[1];
		//pregunto si cargo, no es necesario el if
		}else{
			$datos["foto"] = $img_no_cargada;
		}
		if (move_uploaded_file($foto_tmp, $foto_guardar)) {
			$datos["foto"] = $foto_guardar;
		} else {
			$foto_guardar = $ruta_final . $img_no_cargada;
			$datos["foto"] = $foto_guardar;
		}
		$this->rel()->tabla('libro')->set($datos);
		$this->rel()->tabla('libro')->sincronizar();
		$this->rel()->tabla('libro')->resetear();
		$this->informar_msg('Datos se creo exitosamente ', 'info');
		$this->set_pantalla('pant_seleccion');
	}


	function evt__formulario__modificacion($datos)
	{
		$img_no_cargada = 'sinimagen.png';
		//declaro la variable que va a contener la foto de la base
		$foto_base = "";
		//declaro la foto del formulario
		$foto_form = "";
		//delcaro el nombre de la variable a guardar
		$foto_guardar = "";
		//declaro la variable a trabajar sobre el archivo temporal
		$foto_tmp = "";
		//declaro la variable con el arreglo de la foto del upload
		$imagen_a_tratar = ($datos['imagen']);
		//declaro la ruta donde voy a guardar las fotos
		$ruta_final = 'img/imagenes/';
		//obtengo la ruta inicial del archivo
		$this->s__path_inicial = toba::proyecto()->get_www($ruta_final);
		//declaro la ruta inicial del archivo
		$ruta_inicial = $this->s__path_inicial['path'];
		$path = $ruta_inicial;
		//pregunto si existe el fichero donde voy a guardar los archivos
		if (!file_exists($path)) {
			//si no existe la ruta, la creo y doy permisos de adm
			mkdir($path);
			//doy peromisos de adm
			chmod($path, 0777);
		}
		//guardo el nombre de la imagen
		$nombre_img = basename($datos['imagen']['name']);
		//guardo el nombre del archivo temporal
		//guardo el nombre de la imagen de la base
		$foto_base = toba::db()->consultar("SELECT foto from curlib.libro where id_libro = '$datos[id_libro]'");
		$foto_tmp = $datos['imagen']['tmp_name'];
		//creo un numero aletario para el nombre del archivo
		$num_ram = mt_rand(0, 10000);
		$foto_guardar = $ruta_final . $nombre_img;

		//separo la ruta a partir del punto
		$arreglo = explode(".", $foto_guardar);
		//concateno el numero aleatorio y lo guardo en $foto_guardar
		//pregunto si cargo, no es necesario el if
		if (move_uploaded_file($foto_tmp, $foto_guardar)) {
			$foto_guardar = $arreglo[0] . $num_ram . "." . $arreglo[1];
			$datos["foto"] = $foto_guardar;
			$var = explode("/", $path);
			$path_corto = $var[0]."/".$var[1]."/".$var[2]."/".$var[3]."/";
			if(file_exists($path_corto . $foto_base[0]['foto'])){
			if($foto_base[0]['foto'] !== 'img/imagenes/noimage.png'){
				unlink($path_corto.$foto_base[0]['foto']);
			}
		}
		}elseif($imagen_a_tratar === null){
			$foto_base = toba::db()->consultar("SELECT foto from curlib.libro where id_libro = '$datos[id_libro]'");
			if(is_null($foto_base[0]['foto'])){
				$foto_guardar = $ruta_final . $img_no_cargada;
				$datos["foto"] = $foto_guardar;
			}
		} else {
			$this->informar_msg('No se puede cargar la imagen', 'error');
		}

		$this->rel()->tabla('libro')->set($datos);
		$this->rel()->tabla('libro')->sincronizar();
		$this->rel()->tabla('libro')->resetear();
		$this->informar_msg('Datos se creo exitosamente ', 'info');
		$this->set_pantalla('pant_seleccion');
	}
	//function ssh_
}
