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

        $id_estudiante = $_POST["Estudiante"];
        $nombre_curso = $_POST["Curso"];

        if(!empty($id_estudiante) && !empty($nombre_curso)){
            $respuesta = $inscripcion->registrarInscripcion($id_estudiante, $nombre_curso);
            echo json_encode($respuesta);  
        }else{
            echo json_encode(array("message" => "Todos los campos son obligatorios"));
        }
        
        // $datos = json_decode(file_get_contents("php://input"));

        // if($datos->id_estudiante == null || $datos->nombre_curso == null){
        //     echo json_encode(array("message" => "Todos los campos son obligatorios"));
        // } else {
        //     $respuesta = $inscripcion->registrarInscripcion($datos->id_estudiante, $datos->nombre_curso);
        //     echo json_encode($respuesta);
        // }
    break;

    case "actualizar":

        $id_inscripcion = $_POST["EditarInscripcionesId"];
        $id_estudiante = $_POST["EditarCedula_Estudiante"];
        $nombre_curso = $_POST["EditarCurso"];
    
        if (!empty($id_inscripcion) && !empty($id_estudiante) && !empty($nombre_curso)) {
            $respuesta = $inscripcion->actualizarInscripcion($id_inscripcion, $id_estudiante, $nombre_curso);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("message" => "Todos los campos son obligatorios"));
        }

        // $datos = json_decode(file_get_contents("php://input"));
        // if (!empty($datos->id_inscripcion) && !empty($datos->id_estudiante) && !empty($datos->nombre_curso)) {
        //     $respuesta = $inscripcion->actualizarInscripcion($datos->id_inscripcion, $datos->id_estudiante, $datos->nombre_curso);
        //     echo json_encode($respuesta);
        // }else{
        //     echo json_encode(array("message" => "Todos los campos son obligatorios"));
        // }

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

    case "uno":
        if(isset($_GET["id"])){
            $id = intval($_GET["id"]);
            $dato = $inscripcion->uno($id);
            echo json_encode($dato);
        } else {
            echo json_encode(array("message" => "Se requiere el ID de inscripción para obtener los datos"));
        } 

    break;       
}