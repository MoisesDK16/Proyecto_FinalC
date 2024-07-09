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
        $aulas= array();
        $dato = $aula->listarAulas();
        if ($fila = mysqli_fetch_assoc($dato)) {
            $aulas[] = $fila;
            echo json_encode($aulas);
        } else {
            $aulas[] = [];
        }

    break;

}