<?php
require_once("../config/conexion.php");

class Departamento_Clase {

    public function listarDepartamento() {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT * FROM departamentos";
        $datos = mysqli_query($con, $sql);
    
        if ($datos === false) {
            return "Error al listar";
        }
    
        $con->close(); 
        return $datos;
    }
    
    public function uno($idDepartamento)
    {
        $con = new Clase_Conectar();
        $con = $con->conectar();

        $cadena = "SELECT id_departamento, nombre_departamento FROM departamentos WHERE id_departamento  = ?";
        $stmt = $con->prepare($cadena);
        $stmt->bind_param('i', $idDepartamento);
        $stmt->execute();
        $datos = $stmt->get_result()->fetch_assoc(); 
        return $datos;
        $con->close(); 
    }

    public function registrarDepartamento($nombre_departamento){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "INSERT INTO departamentos (nombre_departamento) VALUES (?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $nombre_departamento);
        if($stmt->execute()){
            return "Registro exitoso";
        }else{
            return "Error al registrar";
        }
        $con->close();
    }
    
    public function actualizarDepartamento($id_departamento, $nombre_departamento){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "UPDATE departamentos SET nombre_departamento = ? WHERE id_departamento = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $nombre_departamento, $id_departamento);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        $con->close();
    }
    
    public function eliminarDepartamento($id_departamento){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        
        $sql = "DELETE FROM departamentos WHERE id_departamento =?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_departamento);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $con->close();
    }

    public function buscarDepartamento($nombre){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT * FROM departamentos WHERE nombre_departamento=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $con->close();
        return $resultado;
    }
    
}