<?php 

require_once("../config/conexion.php");

class Clase_Profesor{

    public function listarProfesores() {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        $sql = "SELECT pro.id_profesor, pro.nombre_profesor, pro.apellido_profesor, d.nombre_departamento 
                FROM profesores AS pro
                INNER JOIN departamentos AS d ON d.id_departamento = pro.id_departamento;";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();    
        return $result;
    }

    public function registrarProfesor($id_profesor, $nombre_profesor, $apellido_profesor, $nombre_departamento) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "INSERT INTO profesores (id_profesor, nombre_profesor, apellido_profesor, id_departamento) 
                VALUES (?, ?, ?, (SELECT id_departamento FROM departamentos WHERE nombre_departamento = ?))";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssss", $id_profesor, $nombre_profesor, $apellido_profesor, $nombre_departamento);

        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Profesor registrado correctamente");
        } else {
            $respuesta = array("message" => "Error al registrar el profesor: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function actualizarProfesor($id_profesor, $nombre_profesor, $apellido_profesor, $nombre_departamento) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();

        $sql = "UPDATE profesores 
                SET nombre_profesor = ?, apellido_profesor = ?, 
                    id_departamento = (SELECT id_departamento FROM departamentos WHERE nombre_departamento = ?)
                WHERE id_profesor = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssss", $nombre_profesor, $apellido_profesor, $nombre_departamento, $id_profesor);

        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Profesor actualizado correctamente");
        } else {
            $respuesta = array("message" => "Error al actualizar el profesor: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function eliminarProfesor($id_profesor) {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        $sql = "DELETE FROM profesores WHERE id_profesor = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $id_profesor);
        $resultado = $stmt->execute();

        if ($resultado) {
            $respuesta = array("message" => "Profesor eliminado correctamente");
        } else {
            $respuesta = array("message" => "Error al eliminar el profesor: " . $stmt->error);
        }

        $stmt->close();
        $con->close();

        return $respuesta;
    }

    public function uno($id_profesor){
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        
        $sql = "SELECT pro.id_profesor, pro.nombre_profesor, pro.apellido_profesor, d.nombre_departamento FROM profesores pro 
        INNER JOIN departamentos d ON d.id_departamento = pro.id_departamento
        WHERE pro.id_profesor = ? ";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $id_profesor);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }

    public function listarDepartamentos() {
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        $sql = "SELECT * FROM departamentos";
        $result = $con->query($sql);
        return $result;
    }

    public function listarComboProfesores(){
        $conectar = new Clase_Conectar();
        $con = $conectar->conectar();
        $sql = "SELECT pro.id_profesor, pro.nombre_profesor, pro.apellido_profesor FROM profesores pro";
        $result = $con->query($sql);
        return $result;
    }

}