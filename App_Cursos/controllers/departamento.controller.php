<?php 

require_once("../models/departamento.model.php");

$departamento = new Departamento_Clase();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    
    case 'uno':
        if (isset($_GET["id_departamento"])) {
            $idDepartamento = intval($_GET["id_departamento"]);
            $datos = $departamento->uno($idDepartamento);
            echo json_encode($datos); // Devuelve los datos del usuario en formato JSON
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    case "listar":
        $departamentos = array();
        $datos = $departamento->listarDepartamento();
        
        if ($datos !== "Error al listar") {
            while ($row = mysqli_fetch_assoc($datos)) {
                $departamentos[] = $row;
            }
            echo json_encode($departamentos);
        } else {
            echo json_encode("Error al listar");
        }
    break;
    
    case "insertar":
        $Nombre = $_POST["Nombre"] ?? null;
        if (!empty($Nombre)) {
            $registro = $departamento->registrarDepartamento($Nombre);
            echo json_encode($registro);
        } else {
            echo json_encode("Faltan Datos");
        }
    break;

    case "actualizar":
        $DepartamentoId = $_POST["DepartamentoId"] ?? null;
        $Nombre = $_POST["Nombre"] ?? null;

        if (!empty($DepartamentoId) && !empty($Nombre)) {
            $actualizado = $departamento->actualizarDepartamento($DepartamentoId, $Nombre);
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
        if (isset($_POST["id_departamento"])) {
            $id_departamento = $_POST["id_departamento"];
            $eliminado = $departamento->eliminarDepartamento($id_departamento);
            echo json_encode($eliminado);
        } else {
            echo json_encode("Error al eliminar");
        }
    break;
    
    default:
        echo json_encode(array("message" => "Operación no válida"));
        break;

}

?>