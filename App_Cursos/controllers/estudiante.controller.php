<?php

require_once("../models/estudiante.model.php");
$estudiante = new Clase_Estudiante();

switch($_GET["op"]){

    case "listar":
        $estudiantes = array();
        $dato = $estudiante->listar_estudiantes();
        while ($row = mysqli_fetch_assoc($dato)) {
            $estudiantes[] = $row;
        }
        
        if (!empty($estudiantes)) {
            echo json_encode($estudiantes);
        } else {
            echo json_encode(array("message" => "No hay estudiantes"));
        }
    
        break;
    

    case "insertar":

        $datos = json_decode(file_get_contents("php://input"));
        $estudiante = $estudiante->registrarEstudiante($datos->id_estudiante, $datos->nombre, $datos->apellido, $datos->fecha_nacimiento);

        if($estudiante){
            echo json_encode("Estudiante registrado");
        }else{
            echo json_encode("Error al registrar estudiante");
        }

    break;

    case "actualizar":
        $datos = json_decode(file_get_contents("php://input"));
        $estudiante = $estudiante->actualizarEstudiante($datos->id_estudiante, $datos->nombre, $datos->apellido, $datos->fecha_nacimiento);

        if($estudiante){
            echo json_encode("Estudiante actualizado");
        }else{
            echo json_encode("Error al actualizar estudiante");
        }
        
    break;

    case "eliminar":
        $datos = json_decode(file_get_contents("php://input"));
        $estudiante = $estudiante->eliminarEstudiante($datos->id_estudiante);

        if($estudiante){
            echo json_encode("Estudiante eliminado");
        }else{
            echo json_encode("Error al eliminar estudiante");
        }      
    break;
}