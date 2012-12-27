<?php
include_once('globales.php');
include_once('bdadministrador.php');

class puntuacioneslocal{

	public function getPuntuacionesLocal(){
		$sql = "SELECT * ";
		$sql .= " FROM PuntuacionLocal ";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function getPuntuacionesLocal($idLocal){
		$sql = "SELECT * ";
		$sql .= " FROM PuntuacionLocal WHERE idLocal=".$idLocal;
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function formateaJSON($result)
	{		
	
		$i = 0;
		$json = "";
		$json .= " { \"exito\" : \"1\" , \"puntuacionesLocal\" : [ ";
		if($result!=null)
		{			
			while($obj = $result->fetch_object()){
				if($i > 0)
					$json .= ",";				
				$json .= " { \"idPuntuacionLocal\" : ".$obj->idPuntuacionLocal.", \"puntuacion\": \"".$obj->Puntuacion."\", \"idUsuario\": \""
						.$obj->idUsuario."\", \"idlocal\": \"".$obj->idLocal."\" ";
		
		
				$json .= "} ";
				$i++;
			}
		
			$json .= " ] ";
			$json .= " } ";
			return $json;
		}
	}
	
	public function getJSONPuntuacionesLocal(){	
		$result = $this->getPuntuacionesLocal();
		$json=$this->formateaJSON($result);
		return $json;		
	}

	public function getJSONPuntuacionesLocal($idLocal){
		$result = $this->getPuntuacionesLocal($idLocal);
		$json=$this->formateaJSON($result);
		return $json;	
	}	
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "exito" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>