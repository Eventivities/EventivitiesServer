<?php
include_once('globales.php');
include_once('bdadministrador.php');

class comentarios{

	/*public function getComentarios(){
		$sql = "SELECT * ";
		$sql .= " FROM Comentario ";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}*/
	
	public function getComentariosEvento($idEvento){
		/*$sql = "SELECT * ";
		$sql .= " FROM Comentario WHERE idEvento=".$idEvento;	*/
		$sql .="SELECT idComentario,Comentario,Comentario.idUsuario,idEvento,Alias FROM Comentario NATURAL JOIN Usuario WHERE idEvento=".$idEvento;		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	/*public function insertarComentarioYPuntuacion($idUsuario, $comentario, $puntuacion, $idEvento){		
		$sql .="INSERT idComentario,Comentario,Comentario.idUsuario,idEvento,Alias FROM Comentario NATURAL JOIN Usuario WHERE idEvento=".$idEvento;
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}*/
	
	
	/*
	 * Columna 	Tipo 	Nulo 	Predeterminado 	Comentarios
	idComentario 	int(11) 	No 		
	Comentario 	char(255) 	No 		
	idUsuario 	int(11) 	No 		
	idEvento 	int(11) 	No
	 *
	Table comments: Usuario
	
	Column 	Type 	Null 	Default 	Comments
	idUsuario 	int(11) 	No
	Nombre 	char(30) 	No
	Email 	char(30) 	Yes 	NULL
	Alias 	char(10) 	No
	Contrasenya 	char(30) 	No
	 */
	
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
				$json .= " { \"idComentario\" : \"".$obj->idComentario."\", \"comentario\": \"".$obj->Comentario."\", \"idUsuario\": \""
						.$obj->idUsuario."\", \"alias\": \"".$obj->Alias."\", \"idEvento\": \"".$obj->idEvento."\" ";
		
		
				$json .= "} ";
				$i++;
			}
		
			$json .= " ] ";
			$json .= " } ";
			
			return $json;
		}
	}
	
	/*public function getJSONComentarios(){	
		$result = $this->getComentarios();
		$json=$this->formateaJSON($result);
		return $json;		
	}*/

	public function getJSONComentariosEvento($idEvento){
		$result = $this->getComentariosEvento($idEvento);
		$json=$this->formateaJSON($result);
		return $json;	
	}

	//El motor myisam de mysql no es transaccional por lo que tenemos q controlar manualmente la atomicidad de la acción
	public function getJSONComentarioYPuntuacion($idUsuario, $comentario, $puntuacion, $idEvento){
		$db = new bdadministrador();
		$link=$db->obtenerEnlace();		
		$sql ="INSERT INTO Comentario (idUsuario, Comentario,idEvento) VALUES (".$idUsuario.",'".$comentario."',".$idEvento.")";				
		$resultado=null;	
		if (mysqli_query($link, $sql) === TRUE) {			
			/**/
			/*idPuntuacion 	Puntuacion 	idEvento 	idUsuario */			
			$sql ="INSERT INTO Puntuacion (idUsuario, Puntuacion,idEvento) VALUES (".$idUsuario.",".$puntuacion.",".$idEvento.")";
			if (mysqli_query($link, $sql) === TRUE) 					
			{	$resultado=$this->formateaJSONRegistroComentarioYPuntuacion(true);			
			}
			//Si se ha insertado el comentario pero no la puntuación, se elimina el comentario
			else
			{
				//1062(duplicado); Entrada duplicada
				if(mysqli_errno($link)==1062)
					$resultado=$this->formateaJSONRegistroComentarioYPuntuacion(false);
				else
					$resultado=$this->getJSONError('mysql', 'error en la insercion');
				
				$sql ="DELETE FROM Comentario WHERE idUsuario=".$idUsuario." AND idEvento=".$idEvento;				
				mysqli_query($link, $sql);				
			}				
		}
		else
		{
			
			//1062(duplicado); Entrada duplicada
			if(mysqli_errno($link)==1062)							
				$resultado=$this->formateaJSONRegistroComentarioYPuntuacion(false);			
			else					
				$resultado=$this->getJSONError('mysql', 'error en la insercion');
		}
		$link->close();
		return $resultado;
	}
	
	
	//Si el registro es un éxito y no hay entradas duplicadas recibe true, si hay entradas duplicadas, un false.
	public function formateaJSONRegistroComentarioYPuntuacion($exito)
	{
		$duplicado=1;
		if($exito)
			$duplicado=0;
		$json = "";
		$json .= " { \"exito\" : \"1\"";
		$json .=" , \"duplicado\" : \"".$duplicado."\" ";
		$json .= " } ";
		return $json;
	}
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "exito" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>