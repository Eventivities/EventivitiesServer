<?php
include_once('globales.php');
include_once('bdadministrador.php');

class usuario{
	/*OKEY*/
	private function comprobarLogin($alias, $clave){
		$sql = "SELECT count(*) AS devuelto ";
		$sql .= "FROM Usuario ";
		$sql .= "WHERE Alias LIKE '".$alias."' AND Contrasenya LIKE '".$clave."'";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	private function comprobarRegistro($alias, $clave){
		$sql = "SELECT count(*) AS devuelto ";
		$sql .= "FROM Usuario ";
		$sql .= "WHERE Alias LIKE '".$alias."'";
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	
	
		
	public function getJSONLogin($user, $pass){
		$result = $this->comprobarLogin($user, $pass);
		$json = $this->formateaJSON($result);
		return $json;
	}
	
	public function getJSONRegistro($alias, $clave){
		
		$db = new bdadministrador();
		$link=$db->obtenerEnlace();		
		$sql ="INSERT INTO Usuario (Alias, Contrasenya) VALUES ('".$alias."','".$clave."')";				
		$resultado=null;	
		if (mysqli_query($link, $sql) === TRUE) {						
			$resultado=$this->formateaJSONRegistro(true);			
		}
		else
		{
			//1062(duplicado); Entrada duplicada
			if(mysqli_errno($link)==1062)
			{
				echo mysqli_error($link);
				$resultado=$this->formateaJSONRegistro(false);
			}
			else					
				$resultado=$this->getJSONError('mysql', 'error en la insercion');
		}
		$link->close();
		return $resultado;
	}

	public function formateaJSON($result)
	{	
		$i = 0;
		$json = "";
		
		if($result!=null)
		{
  		        $json .= " { \"exito\" : \"1\"";
                	while($obj = $result->fetch_object()){				
				$json .=" , \"usuario\" : \"".$obj->devuelto."\" ";
				$i++;
			}			
			$json .= " } ";
			return $json;
		}
	}
	
	//Si el registro es un éxito y no hay entradas duplicadas recibe true, si hay entradas duplicadas, un false.
	public function formateaJSONRegistro($exito)
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