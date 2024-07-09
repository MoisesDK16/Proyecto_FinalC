<?php
require_once("../config/conexion.php");

class Curso_Clase {

    public function listarCurso() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT * FROM cursos";
        $datos = mysqli_query($con, $sql);
    
        if ($datos === false) {
            return "Error al listar";
        }
    
        $con->close(); 
        return $datos;
    }
    
    public function registrarCurso($nombre_curso, $creditos){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "INSERT INTO cursos (nombre_curso, creditos) VALUES (?,?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $nombre_curso, $creditos);
        if($stmt->execute()){
            return "Registro exitoso";
        }else{
            return "Error al registrar";
        }
        $con->close();
    }
    
    public function actualizarCurso($id_curso, $nombre_curso, $creditos){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "UPDATE cursos SET nombre_curso = ?, creditos = ? WHERE id_curso = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sii", $nombre_curso, $creditos, $id_curso);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        $con->close();
    }
    
    public function eliminarCurso($id_curso){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "DELETE FROM cursos WHERE id_curso =?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_curso);
        if($stmt->execute()){
            return "Eliminado exitoso";
        }else{
            return "Error al eliminar";
        }
        $con->close();
    }

    public function buscarCurso($nombre){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT * FROM cursos WHERE nombre_curso=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $con->close();
        return $resultado;
    }
    
}