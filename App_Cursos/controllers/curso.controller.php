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
            echo json_encode($datos); 
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
        $nombre_curso = $_POST["nombre_curso"] ?? null;
        $creditos = $_POST["creditos"] ?? null;

        if (!empty($nombre_curso) && !empty($creditos)) {
            $registro = $curso->registrarCurso($nombre_curso, $creditos);
            echo json_encode($registro);
        } else {
            echo json_encode("Faltan Datos");
        }
    break;

    case "actualizar":
        
        $id_curso = $_POST["EditCursoId"] ?? null;
        $nombre_curso = $_POST["Editnombre"] ?? null;
        $creditos = $_POST["Editcreditos"] ?? null;

        if (!empty($id_curso) && !empty($nombre_curso) && !empty($creditos)) {
            $actualizado = $curso->actualizarCurso($id_curso, $nombre_curso, $creditos);
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
        if (isset($_POST["id_curso"])) {
            $id_curso = intval($_POST["id_curso"]);
            $eliminado = $curso->eliminarCurso($id_curso);
            if ($eliminado) {
                echo json_encode("Eliminado correctamente");
            } else {
                echo json_encode("Error al eliminar");
            }
        } else {
            echo json_encode("Error: No se recibió el ID del curso");
        }
    break;
    

    case "listarCursos":
        $cursos = array();
        $datos = $curso->listarCursos();

        while ($row = mysqli_fetch_assoc($datos)) {
            $cursos[] = $row;
        }
        echo json_encode($cursos);

    break;
    
    default:
        echo json_encode(array("message" => "Operación no válida"));
        break;
}

?>