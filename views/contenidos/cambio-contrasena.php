<?php
	//verifica si hay sesiones iniciadas
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	//llamado al controlador de login
    require_once 'controllers/loginControlador.php';
    $usuario = new loginUsuarios(); //se crea nueva instancia de usuario

	//valdacion para ver si se recibieron datos de ingreso
     if (isset($_POST['acceder'])) {
		$datos = array(
          'contrasena_nueva'=> $_POST['password'],
		  'conf_contrasena_nueva'=> $_POST['conf-password'],
          'email'=> $_SESSION['correo']
        );
        $respuesta = $usuario->modificarContrasena($datos); //se envian los datos a la funcion accesoUsuario de modelo Login
    }
	?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Contraseña | Sistema X</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/Login.css">
</head>
<body>
    <div class="box">
        <form action="" method="POST">
         <?php
            if(isset($_SESSION['respuesta'])){
				switch($_SESSION['respuesta']){
					case 'Cambio de contraseña exitoso':
						echo "<script>
                            setTimeout(function(){location.href='".SERVERURL."login/'} , 3500); </script>";
                        echo '
						<style>
                            .box-recuperacion{height: 390px;} 
						</style>
						<div div class="alert alert-success text-center style="font-size: 17px;" role="alert">Contraseña cambiada 
                        exitosamente. Se redirigirá al login en unos segundos...</div>';
                    break;
                    }
                }
            ?>
            <h3>Cambiar Contraseña</h3>
            <div class="inputBox">
                 <input type="password" name="password" id="password" required>
                 <span>Ingrese su nueva contraseña</span>
                 <i></i>
            </div>
            <span id="spanClave" style="color:red; font-size:15px;"></span>
            <div class="inputBox">
                 <input type="password" name="conf-password" id="conf-password" required>
                 <span>Confirme su nueva contraseña</span>
                 <i></i>
            </div>
            <span id="spanConfClave" style="color:white; font-size:15px;"></span>
            <button type="submit" name="acceder" id="btn-enviar">Guardar Cambios</button>
        </form>
    </div>