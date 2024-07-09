<?php 

require_once("../models/departamento.model.php");

$departamento = new Departamento_Clase();

switch($_GET["op"]){
    
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
        $datos = json_decode(file_get_contents("php://input"));
        if (!empty($datos->nombre_departamento)) {
            $registro = $departamento->registrarDepartamento($datos->nombre_departamento);
            echo json_encode($registro);
        } else {
            echo json_encode("Faltan Datos");
        }
    break;

    case "actualizar":
        $datos = json_decode(file_get_contents("php://input"));
        if (!empty($datos->id_departamento) && !empty($datos->nombre_departamento)) {
            $actualizado = $departamento->actualizarDepartamento($datos->id_departamento, $datos->nombre_departamento);
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
            $id_departamento = $_GET["id"];
            $eliminado = $departamento->eliminarDepartamento($id_departamento);
            echo json_encode($eliminado);
        } else {
            echo json_encode("Error al eliminar");
        }
    break;
}

?>