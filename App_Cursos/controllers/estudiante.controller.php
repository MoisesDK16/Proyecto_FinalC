<?php

require_once("../models/estudiante.model.php");
$estudiante = new Clase_Estudiante();

switch($_GET["op"]){

    case "uno":

        // $datos = json_decode(file_get_contents('php://input')); 

        // if(!empty($datos->id_estudiante)) {
        //     $id_estudiante = intval($datos->id_estudiante);
        //     $datos = $estudiante->uno($id_estudiante);
        //     echo json_encode($datos);
        // } else {
        //     echo json_encode(array("message" => "ID no proporcionado"));
        // }

        if (isset($_GET["id"])) {
            $id_estudiante = intval($_GET["id"]);
            $datos = $estudiante->uno($id_estudiante);
            echo json_encode($datos);
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        
        break;

    default:
        echo json_encode(array("message" => "Operación no válida"));
        break;
    
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
            
            $id_estudiante = $_POST["EstudiantesId"] ?? null;
            $nombre = $_POST["Nombre"] ?? null;
            $apellido = $_POST["Apellido"] ?? null;
            $fecha_nacimiento = $_POST["FechaNacimiento"] ?? null;
        
            if (!empty($id_estudiante) && !empty($nombre) && !empty($apellido) && !empty($fecha_nacimiento)) {
                $registro = $estudiante->registrarEstudiante($id_estudiante, $nombre, $apellido, $fecha_nacimiento);
                echo json_encode($registro);
            } else {
                echo json_encode("Faltan Datos");
            }
        break;

        case "actualizar":
            $id_estudiante = $_POST["EditarEstudianteId"] ?? null;
            $nombre = $_POST["NombreE"] ?? null;
            $apellido = $_POST["ApellidoE"] ?? null;
            $fecha_nacimiento = $_POST["FechaNacimientoE"] ?? null;
        
            if (!empty($id_estudiante) && !empty($nombre) && !empty($apellido) && !empty($fecha_nacimiento)) {
                $actualizado = $estudiante->actualizarEstudiante($id_estudiante, $nombre, $apellido, $fecha_nacimiento);
                if ($actualizado) {
                    echo json_encode("Estudiante actualizado");
                } else {
                    echo json_encode("Error al actualizar estudiante");
                }
            } else {
                echo json_encode("Faltan Datos");
            }
        break;
        

        case "eliminar":
            $id_estudiante = $_POST["id_estudiante"] ?? null;
        
            if (!empty($id_estudiante)) {
                $eliminado = $estudiante->eliminarEstudiante($id_estudiante);
                if ($eliminado) {
                    echo json_encode("Estudiante eliminado");
                } else {
                    echo json_encode("Error al eliminar estudiante");
                }
            } else {
                echo json_encode("Faltan Datos");
            }
        break;
        
}