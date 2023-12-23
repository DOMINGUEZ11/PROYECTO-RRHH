<?php
//llamado al controlador de login
require_once 'controllers/loginControlador.php';
$usuario = new loginUsuarios(); //se crea nueva instancia de usuario

//valdacion para ver si se recibieron datos de ingreso
if (isset($_POST['acceder'])) {
    $userEnviado=filter_var($_POST['text'], FILTER_SANITIZE_STRING);
    $claveEnviada=filter_var($_POST['clave'], FILTER_SANITIZE_STRING);
    $datos = array(
        'usuario'=> $userEnviado,
        'password'=> $claveEnviada,
    );
    $respuesta = $usuario->accesoSistema($datos); //se envian los datos a la funcion accesoUsuario de Logincontrolador
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Iniciar Sesión | Sistema X</title>
    <link rel="stylesheet" href="<?php echo SERVERURL; ?>/assets/css/Login.css">
</head>
<body>
    <div class="box">
        <form action="" method="POST">
        <?php
            if(isset($_SESSION['respuesta'])){
				switch($_SESSION['respuesta']){
					case 'Usuario o contraseña inválida':
                        echo '
						<style>
                            .box{height: 500px;} 
						</style>
						<div div class="alert alert-danger text-center style="font-size: 17px;" role="alert">Usuario y/o contraseña inválidos</div>';
                    break;
                    
                    }
                }
            ?> 
            <h2>Login</h2>
            <div class="inputBox">
                 <input type="text" name="text" required>
                 <span>Usuario</span>
                 <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="clave" required>
                <span>Clave</span>
                <i></i>
           </div>
           <a href="<?php echo SERVERURL?>recuperacion-contrasena/" id="olvido-contrasena">¿Olvidaste tu contraseña?</a>
           <input type="submit" name="acceder" value="Ingresar">
        </form>
    </div>
