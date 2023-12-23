<?php

require_once("./config/conexion.php");

class Usuario extends ConexionBD{
        private $user;
        private $password;
        private $email;
        private $code;

        function getUsuario() {
            return $this->user;
        }

        function getContrasena() {
            return $this->password;
        }

        function getCorreo() {
            return $this->email;
        }

        function getCodigo() {
            return $this->code;
        }

        function setUsuario($user) {
            $this->user = $user;
        }

        function setContrasena($password) {
            $this->password = $password;
        }

        function setCorreo($email) {
            $this->email = $email;
        }

        function setCodigo($code) {
            $this->code = $code;
        }

    public function obtenerContrasenaHash($user) {
		$this->getConexion();
        $sql="SELECT contrasena FROM usuarios WHERE BINARY usuario = '$user' LIMIT 1";
		$resultado=$this->conexion->query($sql) or die ($sql);
        return $resultado;
	}

    public function accesoUsuario($user,$password){
        $this->getConexion();
        $sql="SELECT * FROM usuarios WHERE BINARY usuario='$user' AND contrasena='$password' LIMIT 1";
        $resultado=$this->conexion->query($sql) or die ($sql);
        return $resultado;
    }

    public function verificaUsuarioExistente($email) {
		$this->getConexion();
		$sql="SELECT * FROM usuarios WHERE BINARY correo_electronico = '$email' LIMIT 1";
        $resultado=$this->conexion->query($sql) or die ($sql);
        return $resultado;
	}

    public function verificaCodigoToken($email,$code){
        $this->getConexion();
		$sql="SELECT * FROM restablece_clave_email where email='$email' and codigo='$code' limit 1";
        $resultado=$this->conexion->query($sql) or die ($sql);
        return $resultado;
	}


    public function verificarContrasenaActual($email) {
        $this->getConexion();
		$sql="SELECT * FROM usuarios where correo_electronico='$email' LIMIT 1";
        $resultado=$this->conexion->query($sql) or die ($sql);
        return $resultado;
	}


    //Función que actualiza la contraseña del usuario
	public function cambioContrasena($email,$password,$user) {
        $this->getConexion();
		$sql="UPDATE usuarios set contrasena='$password',modificado_por='$user', fecha_modificacion=now()
        where correo_electronico='$email'";
        $resultado=$this->conexion->query($sql) or die ($sql);
        return $resultado;
	}
}