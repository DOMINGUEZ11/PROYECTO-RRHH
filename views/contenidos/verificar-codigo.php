<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

    //llamado al controlador de login
    require_once 'controllers/emailControlador.php';
    $enviarCodigo = new Correo(); //se crea nueva instancia de usuario

    //valdacion para ver si se recibieron datos de ingreso
    if (isset($_POST['acceder'])) {
        $codigo =  $_POST['text'];
        $respuesta = $enviarCodigo->verificaCodigoToken($codigo); //se envian los datos a la funcion accesoUsuario de modelo Login
    }
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código de Seguridad | Sistema X</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/Login.css">
</head>
<body>
    <div class="box-recuperacion">
        <form action="" method="POST">
         <?php
            if(isset($_SESSION['respuesta'])){
				switch($_SESSION['respuesta']){
					case 'codigo valido':
						echo "<script>
                            setTimeout(function(){location.href='".SERVERURL."cambio-contrasena/'} , 2500); </script>";
                        echo '
						<style>
                            .box-recuperacion{height: 390px;} 
						</style>
						<div div class="alert alert-success text-center style="font-size: 17px;" role="alert">¡Código válido!</div>';
                    break;
                    case 'codigo invalido':
						echo '
						    <style>
                                .box-recuperacion{height: 390px;} 
							</style>
							<div div class="alert alert-danger text-center style="font-size: 17px;" role="alert">El código es inválido</div>';
					break;
                    case 'token vencido':
						echo '
						    <style>
                                .box-recuperacion{height: 390px;} 
							</style>
							<div div class="alert alert-danger text-center style="font-size: 17px;" role="alert">El código ya expiró</div>';
					break;
                    }
                }
            ?> 
            <h3>Verificar Código de Seguridad</h3>
            <div class="inputBox">
                 <input type="number" name="text" style="text-align: center" required>
                 <span>Ingrese el código de seguridad</span>
                 <i></i>
            </div>
            <button type="submit" name="acceder">Enviar Código</button>
        </form>
    </div>
