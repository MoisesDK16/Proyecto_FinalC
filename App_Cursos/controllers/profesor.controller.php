<?php

require_once("../models/profesor.model.php");

$profesor = new Clase_Profesor();

switch($_GET["op"]) {

    case "listar":
        $ListaProfesores = array();
        $dato = $profesor->listarProfesores();

        while($fila = mysqli_fetch_assoc($dato)) {
            $ListaProfesores[] = $fila;
        }

        if (!empty($ListaProfesores)) {
            $json = json_encode($ListaProfesores);
            echo $json;
        } else {
            echo "No hay profesores registrados";
        }
    break;

    case "insertar":
        $datos = json_decode(file_get_contents("php://input"));

        if (isset($datos->id_profesor) && isset($datos->nombre_profesor) && isset($datos->apellido_profesor) && isset($datos->nombre_departamento)) {
            $profesor = new Clase_Profesor();        
            $respuesta = $profesor->registrarProfesor($datos->id_profesor, $datos->nombre_profesor, $datos->apellido_profesor, $datos->nombre_departamento);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("message" => "Todos los campos son obligatorios"));
        }
    break;

    case "actualizar":
        $datos = json_decode(file_get_contents("php://input"));

        if (isset($datos->id_profesor) && isset($datos->nombre_profesor) && isset($datos->apellido_profesor) && isset($datos->nombre_departamento)) {
            $profesor = new Clase_Profesor();
            $respuesta = $profesor->actualizarProfesor($datos->id_profesor, $datos->nombre_profesor, $datos->apellido_profesor, $datos->nombre_departamento);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("message" => "Todos los campos son obligatorios"));
        }
    break;


    case "eliminar":
        $datos = json_decode(file_get_contents("php://input"));

        if (isset($datos->id_profesor)) {
            $profesor = new Clase_Profesor();
            $respuesta = $profesor->eliminarProfesor($datos->id_profesor);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("message" => "El ID del profesor es obligatorio"));
        }
    break;

}
