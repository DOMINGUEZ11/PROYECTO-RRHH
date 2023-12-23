<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="es">
	<?php
		$peticionAjax=false;
		require_once "./controllers/vistasControlador.php";
		$IV = new vistasControlador();

		$vistas=$IV->obtener_vistas_controlador();

		$listaLogin=["login","recuperacion-contrasena","verificar-codigo","cambio-contrasena","404"];
		if(in_array($vistas, $listaLogin)){
			require_once "./views/contenidos/".$vistas.".php";

		}else{
			$pagina=explode("/", $_GET['views']);
			require_once './controllers/loginControlador.php';
			$lc= new loginUsuarios();
			
			/* if(!isset($_SESSION['usuario_login']) || !isset($_SESSION['token_login']) || !isset($_SESSION['id_login'])
			|| !isset($_SESSION['estado']) || !isset($_SESSION['rol']) || !isset($_SESSION['id_rol'])){
				echo $lc->forzarCierreSesionControlador();
				exit;
			} */
	?>
	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		</section>
	</main>
	<?php
	include  $vistas;
		}
		include "./assets/inc/Script.php";
	?>
