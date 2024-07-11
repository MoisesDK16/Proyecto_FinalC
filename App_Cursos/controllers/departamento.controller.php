<?php 

require_once("../models/departamento.model.php");

$departamento = new Departamento_Clase();
$metodo = $_SERVER['REQUEST_METHOD'];

switch($_GET["op"]){
    
    case 'uno':
        if (isset($_GET["id"])) {
            $idDepartamento = intval($_GET["id"]);
            $datos = $departamento->uno($idDepartamento);
            echo json_encode($datos);
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
        $id_departamento = $_POST["EditarDepartamentoId"] ?? null;
        $nombre_departamento = $_POST["EditarNombre"] ?? null;

        if (!empty($id_departamento) && !empty($nombre_departamento)) {
            $actualizado = $departamento->actualizarDepartamento($id_departamento, $nombre_departamento);
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
            $id_departamento = intval($_POST["id_departamento"]);
            $eliminado = $departamento->eliminarDepartamento($id_departamento);
            if ($eliminado) {
                echo json_encode(array("message" => "Eliminado correctamente"));
            }else {
                echo json_encode(array("message" => "Error al eliminar"));
            }
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
    break;

}

?>