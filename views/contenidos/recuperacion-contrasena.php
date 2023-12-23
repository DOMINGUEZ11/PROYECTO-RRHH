<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
 }

 //llamado al controlador de login
 require_once './controllers/loginControlador.php';
 $usuario = new loginUsuarios(); //se crea nueva instancia de usuario

 //valdacion para ver si se recibieron datos de ingreso
 if (isset($_POST['acceder'])) {
       $email = $_POST['text'];
   $respuesta = $usuario->verificaUsuarioExistente($email); //se envian los datos a la funcion accesoUsuario de modelo Login
 }
 ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña | Sistema X</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/Login.css">
</head>
<body>
    <div class="box-recuperacion">
        <form action="" method="POST">
        <?php
            if(isset($_SESSION['respuesta'])){
				switch($_SESSION['respuesta']){
					case 'Correo enviado':
						echo "<script>
                            setTimeout(function(){location.href='".SERVERURL."verificar-codigo/'} , 2500); </script>";
                        echo '
						<style>
                            .box-recuperacion{height: 390px;} 
						</style>
						<div div class="alert alert-success text-center style="font-size: 17px;" role="alert">Usuario si existe</div>';
                    break;
                    case 'Usuario no existe':
						echo '
						    <style>
                                .box-recuperacion{height: 390px;} 
							</style>
							<div div class="alert alert-danger text-center style="font-size: 17px;" role="alert">Usuario no existe</div>';
					break;
                    }
                }
            ?>
            <h3>Recuperación de Contraseña</h3>
            <div class="inputBox">
                 <input type="email" name="text" required>
                 <span>Ingrese su correo electrónico</span>
                 <i></i>
            </div>
            <button type="submit" name="acceder">Enviar Correo</button>
        </form>
    </div>
