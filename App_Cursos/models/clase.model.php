<?php 

require_once("../config/conexion.php");

class Clase_Clase {

    public function listarClases(){
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        $sql = "SELECT cla.id_clase, cur.nombre_curso, pro.id_profesor, pro.nombre_profesor, pro.apellido_profesor, dep.nombre_departamento, au.numero_aula, cla.horario 
                FROM clases as cla
                INNER JOIN cursos cur ON cur.id_curso = cla.id_curso
                INNER JOIN profesores pro ON pro.id_profesor = cla.id_profesor
                INNER JOIN departamentos dep ON dep.id_departamento = pro.id_departamento
                INNER JOIN aulas au ON au.id_aula = cla.id_aula";
        $datos = $con->query($sql);
        return $datos;
    }


    public function registrarClase($nombre_curso, $id_profesor, $numero_aula, $horario) {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
    
        // Llamada al procedimiento almacenado
        $sql = "CALL verificaHorario(?, ?, ?, ?)";
    
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssss", $nombre_curso, $id_profesor, $numero_aula, $horario);
    
        $resultado = $stmt->execute();
    
        if ($resultado) {
            $respuesta = array("message" => "Clase registrada correctamente");
        } else {
            $respuesta = array("message" => "Error al registrar la clase: " . $stmt->error);
        }
    
        $stmt->close();
        $con->close();
    
        return $respuesta;
    }
    

    public function actualizarClase($id_clase, $nombre_curso, $id_profesor, $numero_aula, $horario) {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
    
        $sql = "CALL actualizarClase(?, ?, ?, ?, ?)";
    
        $stmt = $con->prepare($sql);
        $stmt->bind_param("issss", $id_clase, $nombre_curso, $id_profesor, $numero_aula, $horario);
    
        $resultado = $stmt->execute();
    
        if ($resultado) {
            $respuesta = array("message" => "Clase actualizada correctamente");
        } else {
            $respuesta = array("message" => "Error al actualizar la clase: " . $stmt->error);
        }
    
        $stmt->close();
        $con->close();
    
        return $respuesta;
    }
    


    public function eliminarClase($id_clase) {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
    
        $sql = "DELETE FROM clases WHERE id_clase = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_clase);
    
        $resultado = $stmt->execute();
    
        if ($resultado) {
            $respuesta = array("message" => "Clase eliminada correctamente");
        } else {
            $respuesta = array("message" => "Error al eliminar la clase: " . $stmt->error);
        }
    
        $stmt->close();
        $con->close();
    
        return $respuesta;
    }


    public function uno($id_clase) {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();

        $sql = "SELECT cla.id_clase, cur.nombre_curso, pro.id_profesor, pro.nombre_profesor, pro.apellido_profesor, dep.nombre_departamento, au.numero_aula, cla.horario
                FROM clases as cla
                INNER JOIN cursos cur ON cur.id_curso = cla.id_curso
                INNER JOIN profesores pro ON pro.id_profesor = cla.id_profesor
                INNER JOIN departamentos dep ON dep.id_departamento = pro.id_departamento
                INNER JOIN aulas au ON au.id_aula = cla.id_aula
                WHERE cla.id_clase = ?";
                
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_clase);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();

        $stmt->close();
        $con->close();

        return $datos;
    }
}