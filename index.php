<?php
	
	require_once "./config/app.php";
	require_once "./controllers/vistasControlador.php";

	$plantilla = new vistasControlador();
	$plantilla->obtener_plantilla_controlador();