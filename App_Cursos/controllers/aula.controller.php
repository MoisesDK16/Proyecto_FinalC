 <?php 
 require_once("../models/aula.model.php");

$aula = new Clase_Aula(); 

switch($_GET["op"]){

    case "insertar":
        $datos = json_decode(file_get_contents("php://input"));

        if(!empty($datos->numero_aula && $datos->capacidad)){
            $aula->registrarAula($datos->numero_aula, $datos->capacidad);
            echo "Aula registrada";
        }else{
            echo "Error al registrar aula";
        }
        
    break;

    case "listar": 
        $aulas = array();
        $dato = $aula->listarAulas();
        while ($fila = mysqli_fetch_assoc($dato)) {
            $aulas[] = $fila;
        }
    
        if (!empty($aulas)) {
            echo json_encode($aulas);
        } else {
            echo json_encode(array("message" => "No hay aulas disponibles"));
        }
    
        break;
    

    case "actualizar":
        $datos = json_decode(file_get_contents("php://input"));
        $aula->actualizarAula($datos->numero_aula, $datos->capacidad, $datos->id_aula);

        if($aula){
            echo "Aula actualizada";
        }else{
            echo "Error al actualizar aula";
        }
    break;

    case "eliminar":
        $datos = json_decode(file_get_contents("php://input"));
        $aula->eliminarAula($datos->numero_aula);
        if($aula){
            echo "Aula eliminada";
        }else{
            echo "Error al eliminar aula";
        }

    break;
}