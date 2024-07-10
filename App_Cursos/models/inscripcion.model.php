<?php

require_once("../config/conexion.php");

class Clase_Inscripcion{

    public function listarInscripciones(){

        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "SELECT inc.id_inscripcion, e.id_estudiante, e.nombre, e.apellido, cur.nombre_curso, inc.fecha_inscripcion FROM inscripciones as inc
               INNER JOIN estudiantes as e ON e.id_estudiante = inc.id_estudiante
               INNER JOIN cursos as cur ON CUR.id_curso = inc.id_curso";
        
        $datos = mysqli_query($con, $sql);
        $con->close();
        return $datos;

    }


    public function registrarInscripcion($id_estudiante, $nombre_curso) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
    
        $sql = "INSERT INTO inscripciones (id_estudiante, id_curso, fecha_inscripcion) 
                VALUES (
                    (SELECT e.id_estudiante FROM estudiantes e WHERE e.id_estudiante = ?), 
                    (SELECT c.id_curso FROM cursos c WHERE c.nombre_curso = ?), 
                    CURRENT_DATE
                )";
    
        // Preparar la declaración
        $stmt = $con->prepare($sql);
    
        // Vincular los parámetros
        $stmt->bind_param("ss", $id_estudiante, $nombre_curso);
    
        // Ejecutar la declaración
        $resultado = $stmt->execute();
    
        // Verificar si la inserción fue exitosa
        if ($resultado) {
            $respuesta = array("message" => "Inscripción registrada correctamente");
        } else {
            $respuesta = array("message" => "Error al registrar la inscripción: " . $stmt->error);
        }
    
        // Cerrar la declaración y la conexión
        $stmt->close();
        $con->close();
    
        return $respuesta;
    }
    

    public function actualizarInscripcion($id_inscripcion, $id_estudiante, $nombre_curso) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
    
        // Obtener el ID del curso basado en el nombre proporcionado
        $stmt = $con->prepare("SELECT id_curso FROM cursos WHERE nombre_curso = ?");
        $stmt->bind_param("s", $nombre_curso);
        $stmt->execute();
        $stmt->bind_result($id_curso);
        $stmt->fetch();
        $stmt->close();
    
        // Actualizar la inscripción con los nuevos valores
        $sql = "UPDATE inscripciones 
                SET id_estudiante = ?, id_curso = ?, fecha_inscripcion = CURRENT_DATE 
                WHERE id_inscripcion = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sii", $id_estudiante, $id_curso, $id_inscripcion);
        
        if ($stmt->execute()) {
            $respuesta = array("message" => "Inscripción actualizada correctamente");
        } else {
            $respuesta = array("message" => "Error al actualizar la inscripción: " . $stmt->error);
        }
    
        // Cerrar la declaración y la conexión
        $stmt->close();
        $con->close();
    
        return $respuesta;
    }


    public function eliminarInscripcion($id_inscripcion) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "DELETE FROM inscripciones WHERE id_inscripcion = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_inscripcion);
        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Inscripción eliminada correctamente");
        } else {
            $respuesta = array("message" => "Error al eliminar la inscripción: " . $stmt->error);
        }

        $stmt->close();
        $con->close();
    
        return $respuesta;
    }
    
    
    
    
    
       

}