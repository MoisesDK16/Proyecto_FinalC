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


    case "insertar":
        $datos = json_decode(file_get_contents("php://input"));

        if (isset($datos->nombre_curso) && isset($datos->id_profesor) && isset($datos->numero_aula) && isset($datos->horario)) {
            $clase = new Clase_Clase();
            $respuesta = $clase->registrarClase($datos->nombre_curso, $datos->id_profesor, $datos->numero_aula, $datos->horario);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("message" => "Todos los campos son obligatorios"));
        }
    break;

    case "actualizar":
        $datos = json_decode(file_get_contents("php://input"));

        if (isset($datos->id_clase) && isset($datos->nombre_curso) && isset($datos->id_profesor) && isset($datos->numero_aula) && isset($datos->horario)) {
            $clase = new Clase_Clase();
            $respuesta = $clase->actualizarClase($datos->id_clase, $datos->nombre_curso, $datos->id_profesor, $datos->numero_aula, $datos->horario);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("message" => "Todos los campos son obligatorios"));
        }
    break;

    case "eliminar":
        $datos = json_decode(file_get_contents("php://input"));

        if(isset($datos->id_clase)) {
            $clase = new Clase_Clase();
            $respuesta = $clase->eliminarClase($datos->id_clase);
            echo json_encode($respuesta);
        } else {
            echo json_encode(array("message" => "El ID de la clase es obligatorio"));
        }
    break;
}
