<?php 

require_once("../models/clase.model.php");

$clase = new Clase_Clase();

switch($_GET["op"]) {

    case "listar":
        $ListaClases = array();
        $dato = $clase->listarClases();

        while($fila = mysqli_fetch_assoc($dato)) {
            $ListaClases[] = $fila;
        }

        if (!empty($ListaClases)) {
            $json = json_encode($ListaClases);
            echo $json;
        } else {
            echo "No hay clases registradas";
        }
    break;

    case "uno":
        if(isset($_GET["id"])) {
            $id_clase = intval($_GET["id"]);
            $respuesta = $clase->uno($id_clase);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("message" => "El ID de la clase es obligatorio"));
        }

    break;


    case "insertar":      
       
        $nombre_curso = $_POST["Curso"];
        $id_profesor = $_POST["ID_Profesor"];
        $numero_aula = $_POST["Aula"];
        $horario = $_POST["Horario"];

        if(!empty($nombre_curso && $id_profesor && $numero_aula && $horario)){
            $respuesta = $clase->registrarClase($nombre_curso, $id_profesor, $numero_aula, $horario);
            echo json_encode($respuesta);
        }else{  
            echo "Faltan datos";
        }

        // $datos = json_decode(file_get_contents("php://input"));

        // if (isset($datos->nombre_curso) && isset($datos->id_profesor) && isset($datos->numero_aula) && isset($datos->horario)) {
        // $clase = new Clase_Clase();
        // $respuesta = $clase->registrarClase($datos->nombre_curso, $datos->id_profesor, $datos->numero_aula, $datos->horario);
        // echo json_encode($respuesta);
        // } else {
        // echo json_encode(array("message" => "Todos los campos son obligatorios"));
        // }

    break;

    case "actualizar":
        $id_clase = $_POST["EditarClaseId"];
        $nombre_curso = $_POST["EditarClaseCurso"];
        $id_profesor = $_POST["EditarClaseProfesor"];
        $numero_aula = $_POST["EditarClaseAula"];
        $horario = $_POST["EditarClaseHorario"];

        if(!empty($id_clase && $nombre_curso && $id_profesor && $numero_aula && $horario)){
            $respuesta = $clase->actualizarClase($id_clase, $nombre_curso, $id_profesor, $numero_aula, $horario);
            echo json_encode($respuesta);
        }else{
            echo json_encode("Faltan datos");
        }

        // $datos = json_decode(file_get_contents("php://input")


        // if (isset($datos->id_clase) && isset($datos->nombre_curso) && isset($datos->id_profesor) && isset($datos->numero_aula) && isset($datos->horario)) {
        //     $clase = new Clase_Clase();
        //     $respuesta = $clase->actualizarClase($datos->id_clase, $datos->nombre_curso, $datos->id_profesor, $datos->numero_aula, $datos->horario);
        //     echo json_encode($respuesta);
        // } else {
        //     echo json_encode(array("message" => "Todos los campos son obligatorios"));
        // }
    break;

    case "eliminar":
        $id_clase = $_POST["id_clase"] ?? null;

        if (!empty($id_clase)) {
            $eliminado = $clase->eliminarClase($id_clase);
            if ($eliminado) {
                echo json_encode("Clase eliminado");
            } else {
                echo json_encode("Error al eliminar clase");
            }
        } else {
            echo json_encode(array("message" => "El ID de la clase es obligatorio"));
        }
    break;

}
