<?php
include_once('globales.php');
include_once('bdadministrador.php');

class puntuaciones{

	public function getPuntuaciones(){
		$sql = "SELECT * ";
		$sql .= " FROM Puntuacion ";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function getPuntuacionesEvento($idEvento){
		$sql = "SELECT * ";
		$sql .= " FROM Puntuacion WHERE idEvento=".$idEvento;
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function formateaJSON($result)
	{		
	
		$i = 0;
		$json = "";
		$json .= " { \"exito\" : \"1\" , \"puntuaciones\" : [ ";
		if($result!=null)
		{			
			while($obj = $result->fetch_object()){
				if($i > 0)
					$json .= ",";
				//"yyyy-MM-dd HH:mm"
				$json .= " { \"idPuntuacion\" : \"".$obj->idPuntuacion."\", \"puntuacion\": \"".$obj->Puntuacion."\", \"idUsuario\": \""
						.$obj->idUsuario."\", \"idEvento\": \"".$obj->idEvento."\" ";
		
		
				$json .= "} ";
				$i++;
			}
		
			$json .= " ] ";
			$json .= " } ";
			return $json;
		}
	}
	
	public function getJSONPuntuaciones(){	
		$result = $this->getPuntuaciones();
		$json=$this->formateaJSON($result);
		return $json;		
	}

	public function getJSONPuntuacionesEvento($idEvento){
		$result = $this->getPuntuacionesEvento($idEvento);
		$json=$this->formateaJSON($result);
		return $json;	
	}	
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "exito" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>