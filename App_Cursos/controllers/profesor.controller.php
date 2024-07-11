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
            echo json_encode($ListaProfesores);
        } else {
            echo json_encode(['message' => 'No hay profesores registrados']);
        }
        
    break;

    case "uno":

        if(isset($_GET["id"])){
            $dato = $profesor->uno($_GET["id"]);
            if($dato){
                echo json_encode($dato);
            }else{
                echo json_encode(['message' => 'El profesor no existe']);
            }
        }

        // $datos = json_decode(file_get_contents("php://input"));

        // if(isset($datos->id_profesor)) {
        //     $dato = $profesor->uno($datos->id_profesor);
        //     if($dato){
        //         echo json_encode($dato);
        //     }else{
        //         echo json_encode(['message' => 'El profesor no existe']);
        //     }
        // } else {
        //     echo json_encode(['message' => 'El ID del profesor es obligatorio']);
        // }

    break;
    

    case "insertar":
        
        $id_profesor = $_POST["ProfesoresId"];
        $nombre_profesor = $_POST["Nombre"];
        $apellido_profesor = $_POST["Apellido"];
        $nombre_departamento = $_POST["Departamento"];

        if (!empty($id_profesor) && !empty($nombre_profesor) && !empty($apellido_profesor) && !empty($nombre_departamento)) {
            $respuesta = $profesor->registrarProfesor($id_profesor, $nombre_profesor, $apellido_profesor, $nombre_departamento);
            echo json_encode($respuesta);
        } else {
            echo json_encode(['message' => 'Todos los campos son obligatorios']);
        }

        // $datos = json_decode(file_get_contents("php://input"));

        // if (isset($datos->id_profesor) && isset($datos->nombre_profesor) && isset($datos->apellido_profesor) && isset($datos->nombre_departamento)) {
        //     $profesor = new Clase_Profesor();        
        //     $respuesta = $profesor->registrarProfesor($datos->id_profesor, $datos->nombre_profesor, $datos->apellido_profesor, $datos->nombre_departamento);
        //     echo json_encode($respuesta);
        // } else {
        //     echo json_encode(array("message" => "Todos los campos son obligatorios"));
        // }
    break;

    case "actualizar":

        $id_profesor = $_POST["EditarProfesoresId"];
        $nombre_profesor = $_POST["EditarNombre"];
        $apellido_profesor = $_POST["EditarApellido"];
        $nombre_departamento = $_POST["EditarDepartamento"];

        if($id_profesor && $nombre_profesor && $apellido_profesor && $nombre_departamento){
            $respuesta = $profesor->actualizarProfesor($id_profesor, $nombre_profesor, $apellido_profesor, $nombre_departamento);
            echo json_encode($respuesta);
        }else{
            echo json_encode(['message' => 'Todos los campos son obligatorios']);
        }

        // $datos = json_decode(file_get_contents("php://input"));

        // if (isset($datos->id_profesor) && isset($datos->nombre_profesor) && isset($datos->apellido_profesor) && isset($datos->nombre_departamento)) {
        //     $profesor = new Clase_Profesor();
        //     $respuesta = $profesor->actualizarProfesor($datos->id_profesor, $datos->nombre_profesor, $datos->apellido_profesor, $datos->nombre_departamento);
        //     echo json_encode($respuesta);
        // } else {
        //     echo json_encode(array("message" => "Todos los campos son obligatorios"));
        // }
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

    case "listarDepartamentos":

        $listaDepartamentos = array();
        $dato = $profesor->listarDepartamentos();

        while($fila = mysqli_fetch_assoc($dato)) {
            $listaDepartamentos[] = $fila;
        }

        echo json_encode($listaDepartamentos);

    break;

    case "listarComboProfesores":
        $listaProfesores = array();
        $dato = $profesor->listarComboProfesores();

        while($fila = mysqli_fetch_assoc($dato)){
            $listaProfesores[] = $fila;
        }
        echo json_encode($listaProfesores);
    
    break;

}
