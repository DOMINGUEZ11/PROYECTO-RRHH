<?php
require_once("../config/conexion.php");

class obtenerDatosTablas extends ConexionBD{

    public function datosTablas($tabla){
        $sql=ConexionBD::getConexion()->prepare("SELECT * FROM $tabla");
        $sql->execute();
        return $sql;
    }


    public function datosOficiales(){
        $json=array();

        $queryReferidos=ConexionBD::getConexion()->prepare("SELECT * FROM oficiales");
        $queryReferidos->execute();

        if($queryReferidos->rowCount()>0){
            foreach ($queryReferidos as $fila){
                 $json[]=array(
                    'id_oficial'=>$fila['id_oficial'],
                    'nombre_completo'=>$fila['nombre_completo'],
                    'grado'=>$fila['grado'],
                    'fecha_nacimiento'=>$fila['fecha_nacimiento'],
                    'ruta_carpeta'=>$fila['ruta_carpeta']
                 );
            }
            $queryReferidos=ConexionBD::disconnect(); 
        
            echo json_encode($json);
        }
    }


    public function datosDocentes(){
        $json=array();

        $queryReferidos=ConexionBD::getConexion()->prepare("SELECT * FROM docentes");
        $queryReferidos->execute();

        if($queryReferidos->rowCount()>0){
            foreach ($queryReferidos as $fila){
                 $json[]=array(
                    'id_docente'=>$fila['id_docente'],
                    'nombre_completo'=>$fila['nombre_completo'],
                    'dni'=>$fila['dni'],
                    'fecha_nacimiento'=>$fila['fecha_nacimiento'],
                    'ruta_carpeta'=>$fila['ruta_carpeta']
                 );
            }
            $queryReferidos=ConexionBD::disconnect(); 
        
            echo json_encode($json);
        }
    }

    
    public function datosBitacora(){
        $sql=ConexionBD::getConexion()->prepare("SELECT b.id_modulo, b.fecha, b.id_usuario, b.accion,
         b.descripcion, m.modulo, u.usuario FROM bitacora b
        inner join modulos m on m.id_modulo=b.id_modulo
        inner join usuarios u on u.id_usuario=b.id_usuario
        order by fecha desc");
        $sql->execute();
        return $sql;
    }
    
}