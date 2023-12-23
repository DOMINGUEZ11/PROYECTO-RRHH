<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$peticionAjax=true;
require_once "../config/app.php";

class oficialControlador{
}


/* Esta parte del código se encarga de realizar los llamados a las funciones contenidas
en la clase premioControlador
Funciones para la inserción, consulta, modificación y eliminación de registros 
*/

//Insertar, actualizar o eliminar
		/*--------- Instancia al controlador ---------*/
		$ins_premio = new oficialControlador();


		if(isset($_POST['sorteo_nuevo'])){
			echo $ins_premio->agregarPremio();
			die();
		}
		

		if(isset($_POST['sorteo_act'])){
			echo $ins_premio->actualizarPremio();
			die();
		}
		

		if(isset($_POST['premio_imagen_id'])){
			echo $ins_premio->cambiarFotoPremio();
			die();
		}


		if(isset($_POST['premio_id']) ){
			echo $ins_premio->eliminarPremio();
			die();
		}



	//Consultar
if(isset($_POST['query'])){
	/*--------- Instancia al controlador ---------*/
	include("../models/DatosTablas/obtenerDatos.php"); 
	$ins_premio = new obtenerDatosTablas();

	echo $ins_premio->datosOficiales();
	die();	
}


