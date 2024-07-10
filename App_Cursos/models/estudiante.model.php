<?php

require_once("../config/conexion.php");

class Clase_Estudiante{

    public function uno($id_estudiante) {
        $conexion = new Clase_Conectar();
        $con = $conexion->conectar();
    
        $sql = "SELECT id_estudiante, nombre, apellido, fecha_nacimiento FROM estudiantes WHERE id_estudiante = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id_estudiante);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id_estudiante, $nombre, $apellido, $fecha_nacimiento);
        mysqli_stmt_fetch($stmt);
    
        $datos = array(
            'id_estudiante' => $id_estudiante,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'fecha_nacimiento' => $fecha_nacimiento
        );
    
        mysqli_stmt_close($stmt);
        $con->close();
        
        return $datos;
    }
    

    public function listar_estudiantes(){
        $conexion= new Clase_Conectar();
        $con = $conexion->conectar();
        $sql="SELECT * FROM estudiantes";
        $result= mysqli_query($con,$sql);
        return $result;
    }

    public function registrarEstudiante($id_estudiante, $nombre, $apellido, $fecha_nacimiento){
        $conexion= new Clase_Conectar();
        $con = $conexion->conectar();
        $sql="INSERT INTO estudiantes (id_estudiante, nombre, apellido, fecha_nacimiento)  VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("ssss", $id_estudiante, $nombre, $apellido, $fecha_nacimiento);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        
        $con->close();
    }
    

    public function actualizarEstudiante($id_estudiante, $nombre, $apellido, $fecha_nacimiento){
        $conexion= new Clase_Conectar();
        $con = $conexion->conectar();
        $sql="UPDATE estudiantes SET nombre=?, apellido=?, fecha_nacimiento=? WHERE id_estudiante=?";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $fecha_nacimiento, $id_estudiante);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

        $con->close();
    }

    public function eliminarEstudiante($id_estudiante){
        $conexion= new Clase_Conectar();
        $con = $conexion->conectar();
        $sql="DELETE FROM estudiantes WHERE id_estudiante=?";
        $stmt = mysqli_prepare($con, $sql);
        $stmt->bind_param("s", $id_estudiante);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

        $con->close();
    }

}