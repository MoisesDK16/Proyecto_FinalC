<?php

require_once("../config/conexion.php");

class Clase_Aula{

    public function registrarAula($numero_aula, $capacidad){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "INSERT INTO aulas (numero_aula, capacidad) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $numero_aula, $capacidad);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

        $con->close();
    }

    public function listarAulas(){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "SELECT * FROM aulas";
        $result = $con->query($sql);
        $con->close();
        return $result;
    }

    public function actualizarAula($numero_aula, $capacidad, $id_aula){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "UPDATE aulas SET numero_aula = ?, capacidad = ? WHERE id_aula = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sii", $numero_aula, $capacidad, $id_aula);
        $stmt->execute();
    }

    public function eliminarAula($id_aula){
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
        $sql = "DELETE FROM aulas WHERE numero_aula = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_aula);
        $stmt->execute();
        $con->close();
    }   
}


