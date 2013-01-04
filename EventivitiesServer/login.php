<?php
include_once('globales.php');
include_once('bdadministrador.php');

class login{
	/*OKEY*/
	public function comprobarLogin($user, $pass){
		$sql = "SELECT count(*) AS devuelto ";
		$sql .= "FROM Usuario ";
		$sql .= "WHERE Alias LIKE '".$user."' AND Contrasenya LIKE '".$pass."'";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	/*OKEY*/
	public function getJSONLogin($user, $pass){
		$result = $this->comprobarLogin($user, $pass);
		$json = $this->formateaJSON($result);
		return $json;
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
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "success" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>