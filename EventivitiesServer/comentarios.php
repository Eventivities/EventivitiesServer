<?php
include_once('globales.php');
include_once('bdadministrador.php');

class comentarios{

	public function getComentarios(){
		$sql = "SELECT * ";
		$sql .= " FROM Comentario ";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function getComentariosEvento($idEvento){
		$sql = "SELECT * ";
		$sql .= " FROM Comentario WHERE idEvento=".$idEvento;
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	
	
	/*
	 * Columna 	Tipo 	Nulo 	Predeterminado 	Comentarios
idComentario 	int(11) 	No 		
Comentario 	char(255) 	No 		
idUsuario 	int(11) 	No 		
idEvento 	int(11) 	No
	 * */
	public function formateaJSON($result)
	{		
	
		$i = 0;
		$json = "";
		$json .= " { \"exito\" : \"1\" , \"comentarios\" : [ ";
		if($result!=null)
		{			
			while($obj = $result->fetch_object()){
				if($i > 0)
					$json .= ",";				
				$json .= " { \"idComentario\" : ".$obj->idComentario.", \"comentario\": \"".$obj->Comentario."\", \"idUsuario\": \""
						.$obj->idUsuario."\", \"idEvento\": \"".$obj->idEvento."\" ";
		
		
				$json .= "} ";
				$i++;
			}
		
			$json .= " ] ";
			$json .= " } ";
			return $json;
		}
	}
	
	public function getJSONComentarios(){	
		$result = $this->getComentarios();
		$json=$this->formateaJSON($result);
		return $json;		
	}

	public function getJSONComentariosEvento($idEvento){
		$result = $this->getComentariosEvento($idEvento);
		$json=$this->formateaJSON($result);
		return $json;	
	}	
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "exito" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>