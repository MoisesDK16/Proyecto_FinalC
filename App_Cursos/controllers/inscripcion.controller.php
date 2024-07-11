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
    
        if (!empty($id_estudiante) && !empty($nombre_curso)) {
            $respuesta = $inscripcion->registrarInscripcion($id_estudiante, $nombre_curso);
            if ($respuesta) {
                echo json_encode("Inscripcion insertada");
            } else {
                echo json_encode("Error insertar inscripcion");
            }
        } else {
            //echo json_encode(array("status" => "error", "message" => "Todos los campos son obligatorios"));
            echo json_encode("ERROR");
        }
    break;

    break;

    case "actualizar":
        $id_inscripcion = $_POST["EditarInscripcionesId"];
        $id_estudiante = $_POST["EditarCedula_Estudiante"];
        $nombre_curso = $_POST["EditarCurso"];
    
        if (!empty($id_inscripcion) && !empty($id_estudiante) && !empty($nombre_curso)) {
            $respuesta = $inscripcion->actualizarInscripcion($id_inscripcion, $id_estudiante, $nombre_curso);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("status" => "error", "message" => "Todos los campos son obligatorios"));
        }
    break;        
    
    case "eliminar":
        $id_inscripcion = $_POST["id_inscripcion"] ?? null;

        if (!empty($id_inscripcion)) {
            $eliminado = $inscripcion->eliminarInscripcion($id_inscripcion);
            if ($eliminado) {
                echo json_encode("Inscripcion eliminado");
            } else {
                echo json_encode("Error al eliminar inscripcion");
            }
        } else {
            echo json_encode(array("message" => "El ID de inscripcion es obligatorio"));
        }
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
    
    case "unoEstudiante":

        // $datos = json_decode(file_get_contents("php://input"));
        
        // if($datos->id){
        //     $id = intval($datos->id);
        //     $inscripciones = $inscripcion->unoEstudiante($id);
        //     echo json_encode($inscripciones);
        // }else{
        //     echo json_encode(array("message" => "Se requiere el ID de estudiante para obtener los datos"));
        // }

        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $inscripciones = $inscripcion->unoEstudiante($id);
    
            echo json_encode($inscripciones);
        } else {
            echo json_encode(array("message" => "Se requiere el ID de estudiante para obtener los datos"));
        }
        
    break;
    
}