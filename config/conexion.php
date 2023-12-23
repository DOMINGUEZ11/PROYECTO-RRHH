<?php

class ConexionBD{
    protected $manejador = "mysql";
    private static $servidor = "localhost";
    private static $usuario = "root";
    private static $pass = "";
    protected $db_name = "sistema_rrhh";
    protected $conexion;

    protected function getConexion(){
        try{
            $parametros=array(PDO::ATTR_EMULATE_PREPARES=>false,PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
            $this->conexion=new PDO($this->manejador.":host=".self::$servidor.";dbname=".$this->db_name,self::$usuario,self::$pass,$parametros);
            return $this->conexion;
        }
        catch(PDOException $e){
            echo 'Error en la conexion a la BD :'.$e->getMessage();
        }
    }
    
	/*--------- Funcion para encriptar la contraseña ---------*/
	public function EncriptaClave($string){
		return password_hash($string, PASSWORD_DEFAULT, ['cost' => 12]);
	}

	/*--------- Funcion ejecutar consultas simples ---------*/
	protected function consultaComprobacion($consulta){
		$sql=self::getConexion()->prepare($consulta);
		$sql->execute();
		return $sql;
	}

    /*--------- Funcion limpiar cadena ---------*/

		protected static function limpiar_cadena($cadena){
			$cadena=trim($cadena);
			$cadena=stripslashes($cadena);
			$cadena=str_ireplace("<script>", "", $cadena);
			$cadena=str_ireplace("</script>", "", $cadena);
			$cadena=str_ireplace("<script src", "", $cadena);
			$cadena=str_ireplace("<script type=", "", $cadena);
			$cadena=str_ireplace("SELECT * FROM", "", $cadena);
			$cadena=str_ireplace("DELETE FROM", "", $cadena);
			$cadena=str_ireplace("INSERT INTO", "", $cadena);
			$cadena=str_ireplace("DROP TABLE", "", $cadena);
			$cadena=str_ireplace("DROP DATABASE", "", $cadena);
			$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
			$cadena=str_ireplace("SHOW TABLES", "", $cadena);
			$cadena=str_ireplace("SHOW DATABASES", "", $cadena);
			$cadena=str_ireplace("<?php", "", $cadena);
			$cadena=str_ireplace("?>", "", $cadena);
			$cadena=str_ireplace("--", "", $cadena);
			$cadena=str_ireplace(">", "", $cadena);
			$cadena=str_ireplace("<", "", $cadena);
			$cadena=str_ireplace("[", "", $cadena);
			$cadena=str_ireplace("]", "", $cadena);
			$cadena=str_ireplace("^", "", $cadena);
			$cadena=str_ireplace("==", "", $cadena);
			$cadena=str_ireplace(";", "", $cadena);
			$cadena=str_ireplace("::", "", $cadena);
			$cadena=stripslashes($cadena);
			$cadena=trim($cadena);
			return $cadena;
		}


		/*--------- Funcion verificar datos ---------*/
		protected static function verificar_datos($filtro,$cadena){
			if(preg_match("/^".$filtro."$/", $cadena)){
				return false;
			}else{
				return true;
			}
		}


		function disconnect () {
			/* $this->_pdoStat->closeCursor();
			$this->_pdoStat = null; */
			$this->conexion = null;
		}
    
}