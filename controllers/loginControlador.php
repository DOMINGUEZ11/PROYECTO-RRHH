<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
   session_start();
}

require_once ("./models/loginModelo.php");
require_once "./controllers/emailControlador.php";

class loginUsuarios extends Usuario{

    public function accesoSistema($datos){
        $usuario=ConexionBD::limpiar_cadena(strtolower($datos['usuario']));
        $contrasena=ConexionBD::limpiar_cadena($datos['password']);
        $array=array();
        $hash='';

        //se obtiene el hash de la contraseña para validar el inicio de sesion
		$recuperarHash=new Usuario();
		$hash_BD = $recuperarHash->obtenerContrasenaHash($usuario);
			foreach($hash_BD as $fila){
				$hash=$fila['contrasena'];
			}

		if(password_verify($contrasena, $hash)){
			$verificarDatos = new Usuario(); //se crea una instancia en el archivo modelo de Login
			$respuesta = $verificarDatos->accesoUsuario($usuario, $hash); //datos recibidos del archivo modelo de Login
				
			foreach ($respuesta as $fila) {
				$array['id'] = $fila['id_usuario'];
				$array['usuario'] = $fila['usuario'];
			}
				
			return header("Location:".SERVERURL."home/"); 
		}else{
			$_SESSION['respuesta'] = 'Usuario o contraseña inválida';
			return header("Location:".SERVERURL."login/");
			die();
		}	
	}


   //función que se encarga de validar el usuario ingresado para la recuperacion de contraseña
		public function verificaUsuarioExistente($email){
			$correoEnviado=ConexionBD::limpiar_cadena($email);
			$array=array();

			$verificarUsuario = new Usuario(); //se crea una instancia en el archivo modelo de Login
			$respuesta = $verificarUsuario->verificaUsuarioExistente($correoEnviado);
			foreach ($respuesta as $fila) { 
				$array['usuario'] = $fila['usuario'];
				$array['estado'] = $fila['estado'];
			}

			//Se valida si el usuario no está inactivo para realizar la recuperacion de contraseña
			if (isset($array['usuario'])>0){
				//se revisa la existencia del usuario y el metodo de recuperacion seleccionado
					$_SESSION['usuario_rec']=$array['usuario'];
					$_SESSION['respuesta'] = 'Correo enviado';
					$agg_correo = new Correo(); 
      				$respuesta = $agg_correo->enviarCorreo($correoEnviado);
                  return "<script> window.location.href='".SERVERURL."recuperacion-contrasena/'; </script>";
					die(); 
			}else{
				$_SESSION['respuesta'] = 'Usuario no existe';
				return header("Location:".SERVERURL."recuperacion-contrasena/");
				die();
			}
		}


   //Función para realizar el cambio de contraseña en el sistema
		public function modificarContrasena($datos){
			$contrasena_nueva=ConexionBD::limpiar_cadena($datos['contrasena_nueva']);
			$conf_contrasena_nueva=ConexionBD::limpiar_cadena($datos['conf_contrasena_nueva']);
            $correo=ConexionBD::limpiar_cadena($datos['email']);
			$array=array();


			//se hace un select para obtener la contraseña y el correo del usuario de recuperacion o que ingresa por primera vez
			$cambioContrasena = new Usuario(); 
			$respuesta = $cambioContrasena->verificarContrasenaActual($correo);
			foreach($respuesta as $fila){
				$hash_contrasenaActual=$fila['contrasena'];
            $usuario=$fila['usuario'];
			}

			//verificacion para revisar que la nueva contraseña sea distinta a la que ya está registrada
			$hash_contrasenaNueva=ConexionBD::EncriptaClave($contrasena_nueva);
			if(($hash_contrasenaNueva==$hash_contrasenaActual)){
				$_SESSION['respuesta'] = 'Contraseña nueva igual a la actual';
            return "<script> window.location.href='".SERVERURL."cambio-contrasena/'; </script>";
				die();
			}
			
			//verificacion para revisar que la contraseña y la confirmacion de la contraseña sean iguales
			//de ser así se procede al cambio de contraseña y se envia un correo de confirmación con el usuario y contraseña
			if($contrasena_nueva!=$conf_contrasena_nueva){
				$_SESSION['respuesta'] = 'Contraseñas no coinciden';
            return "<script> window.location.href='".SERVERURL."cambio-contrasena/'; </script>";
				die();
			}else{
				$_SESSION['respuesta'] = 'Cambio de contraseña exitoso';
					$respuesta = $cambioContrasena->cambioContrasena($correo,$hash_contrasenaNueva,$usuario);
					$envioCorreo = new Correo();
					$respuesta = $envioCorreo->CorreoCambioContrasena($correo,$contrasena_nueva);
					return "<script> window.location.href='".SERVERURL."cambio-contrasena/'; </script>";
				die();
			}
					 
		}

    //funcion encargada de redirigir al login siempre que se detecte que no hay una sesion activa
    //o que no esten identificados todos los datos de sesion que deberian estar 
    public function forzarCierreSesionControlador(){
         session_unset();
         session_destroy();
         if(headers_sent()){
            return "<script> window.location.href='".SERVERURL."login/'; </script>";
         }else{
            return header("Location:".SERVERURL."login/");
         }
    }

}