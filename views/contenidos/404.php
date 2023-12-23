<?php
//verifica si hay sesiones iniciadas
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

?>
<title>Error 404</title>

<div class="full-box container-404">
	<div class="error-404">
		<br>
		<h1 class="text-center">ERROR 404</h1>
		<p class="text-center">Página no encontrada</p>
	 	<img src="<?php echo SERVERURL?>vistas/assets/images/komi-removebg-preview.png" witdh="400" height="400">
		<br>
		<h3 class="text-center">"Komi-san se pregunta por qué la página que seleccionó no existe..."</h3>
		<br> 
		<br>
		
	</div>
</div>