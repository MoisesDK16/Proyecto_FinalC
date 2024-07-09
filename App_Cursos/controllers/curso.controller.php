<?php 

require_once("../models/curso.model.php");

$curso = new Curso_Clase();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
        
    /* Procedimiento para sacar un registro */
    case 'uno':
        if (isset($_GET["id"])) {
            $idCurso = intval($_GET["id"]);
            $datos = $curso->uno($idCurso);
            echo json_encode($datos); // Devuelve los datos del curso en formato JSON
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    case "listar":
        $cursos = array();
        $datos = $curso->listarCurso();
        
        if ($datos !== "Error al listar") {
            while ($row = mysqli_fetch_assoc($datos)) {
                $cursos[] = $row;
            }
            echo json_encode($cursos);
        } else {
            echo json_encode("Error al listar");
        }
    break;
    
    case "insertar":
        $nombre = $_POST["nombre"] ?? null;
        $creditos = $_POST["creditos"] ?? null;

        if (!empty($nombre) && !empty($creditos)) {
            $registro = $curso->registrarCurso($nombre, $creditos);
            echo json_encode($registro);
        } else {
            echo json_encode("Faltan Datos");
        }
    break;

    case "actualizar":
        $datos = json_decode(file_get_contents("php://input"));
        if (!empty($datos->id_curso) && !empty($datos->nombre_curso) && !empty($datos->creditos)) {
            $actualizado = $curso->actualizarCurso($datos->id_curso, $datos->nombre_curso, $datos->creditos);
            if ($actualizado) {
                echo json_encode("Actualizado");
            } else {
                echo json_encode("Error al actualizar");
            }
        } else {
            echo json_encode("Faltan Datos");
        }
    break;

    case "eliminar":
        if (isset($_GET["id"])) {
            $id_curso = $_GET["id"];
            $eliminado = $curso->eliminarCurso($id_curso);
            echo json_encode($eliminado);
        } else {
            echo json_encode("Error al eliminar");
        }
    break;   
}

?>