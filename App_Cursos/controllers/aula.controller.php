<?php

require_once('../models/aula.model.php');

$aula = new Clase_Aula();

switch ($_GET["op"]) {
    /* Procedimiento para listar todos los registros */
    case 'listar':
        $datos = array();
        $datos = $aula->listarAulas();
        $aulas = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $aulas[] = $row;
        }
        echo json_encode($aulas);
        break;
        
    /* Procedimiento para sacar un registro */
    case 'uno':
        if (isset($_GET["id"])) {
            $idAula = intval($_GET["id"]);
            $datos = $aula->uno($idAula);
            echo json_encode($datos); // Devuelve los datos del aula en formato JSON
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    /* Procedimiento para insertar */
    case 'insertar':
        $NumAula = $_POST["NumAula"] ?? null;
        $Capacidad = $_POST["Capacidad"] ?? null;
        
        if ($NumAula && $Capacidad) {
            $insertar = $aula->registrarAula($NumAula, $Capacidad);
            if ($insertar) {
                echo json_encode(array("message" => "Aula registrada correctamente"));
            } else {
                echo json_encode(array("message" => "Error al registrar aula"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;
        
    /* Procedimiento para actualizar */
    case 'actualizar':

        // $datos = json_decode(file_get_contents("php://input"));

        // if(!empty($datos->id_aula) && !empty($datos->numero_aula) && !empty($datos->capacidad)){
        //     $aula->actualizarAula($datos->numero_aula,$datos->capacidad,$datos->id_aula);
        //     echo json_encode(array("message" => "Aula actualizada correctamente"));
 
        // }else{
        //     echo json_encode(array("message" => "Error, faltan datos"));
        // }


        $id_aula = $_POST["EditarAulaId"] ?? null;
        $numero_aula = $_POST["NumAulaE"] ?? null;
        $capacidad = $_POST["CapacidadE"] ?? null;
        
        if ($id_aula && $numero_aula && $capacidad) {
            $actualizar = $aula->actualizarAula($numero_aula, $capacidad, $id_aula);
            if ($actualizar) {
                echo json_encode(array("message" => "Aula actualizada correctamente"));
            } else {
                echo json_encode(array("message" => "Error al actualizar aula"));
            }
        } else {
            echo json_encode(array("message" => "Error, faltan datos"));
        }
        break;
        
    /* Procedimiento para eliminar */
    case 'eliminar':
        if (isset($_POST["id_aula"])) {
            $id_aula = $_POST["id_aula"];
            $eliminar = $aula->eliminarAula($id_aula);
            if ($eliminar) {
                echo json_encode(array("message" => "Eliminado exitoso"));
            } else {
                echo json_encode(array("message" => "Error al eliminar aula"));
            }
        } else {
            echo json_encode(array("message" => "ID no proporcionado"));
        }
        break;

    case "listarComboAulas":

        $aulas = array();
        $dato = $aula->listarComboAulas();

        while ($row = mysqli_fetch_assoc($dato)) {
            $aulas[] = $row;
        }
        echo json_encode($aulas);

    break;

    default:
        echo json_encode(array("message" => "Operación no válida"));
    break;
}
?>
