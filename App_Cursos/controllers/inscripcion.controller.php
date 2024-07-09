<?php 

require_once("../models/inscripcion.model.php");

$inscripcion = new Clase_Inscripcion();

switch($_GET["op"]){
    case "listar":

        $ListaInscripcion = array();
    
        $dato = $inscripcion->listarInscripciones();
    
        while ($fila = mysqli_fetch_assoc($dato)) {
            $ListaInscripcion[] = $fila;
        }
    
        if (!empty($ListaInscripcion)) {
            echo json_encode($ListaInscripcion);
        } else {
            echo json_encode(array("message" => "No hay inscripciones disponibles"));
        }
    break;

    case "insertar":
        $datos = json_decode(file_get_contents("php://input"));

        if($datos->id_estudiante == null || $datos->nombre_curso == null){
            echo json_encode(array("message" => "Todos los campos son obligatorios"));
        } else {
            $respuesta = $inscripcion->registrarInscripcion($datos->id_estudiante, $datos->nombre_curso);
            echo json_encode($respuesta);
        }
    break;

    case "actualizar":
        $datos = json_decode(file_get_contents("php://input"));

        if ($datos->id_inscripcion == null || $datos->id_estudiante == null || $datos->nombre_curso == null) {
            echo json_encode(array("message" => "Todos los campos son obligatorios"));
        } else {
            // Llamar al método de actualización del modelo
            $respuesta = $inscripcion->actualizarInscripcion($datos->id_inscripcion, $datos->id_estudiante, $datos->nombre_curso);
            echo json_encode($respuesta);
        }
    break;

    case "eliminar":
        $datos = json_decode(file_get_contents("php://input"));

        if (!isset($datos->id_inscripcion)) {
            echo json_encode(array("message" => "Se requiere el ID de inscripción para eliminar"));
            break;
        }
    
        $respuesta = $inscripcion->eliminarInscripcion($datos->id_inscripcion);

        echo json_encode($respuesta);
    break; 
    
}