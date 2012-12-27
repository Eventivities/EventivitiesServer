<?php
include_once('globales.php');
include_once('bdadministrador.php');

class locales{

	public function getLocales(){
		$sql = "SELECT * ";
		$sql .= " FROM Local ";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function getLocalesCiudad($ciudad){
		$sql = "SELECT * ";
		$sql .= " FROM Local WHERE ciudad='".$ciudad."'";
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function formateaJSON($result)
	{		
	
		$i = 0;
		$json = "";
		$json .= " { \"exito\" : \"1\" , \"locales\" : [ ";
		if($result!=null)
		{	
/*Columna 	Tipo 	Nulo 	Predeterminado 	Comentarios
idLocal 	int(11) 	No 		
NombreLocal 	char(30) 	Sí 	NULL 	
Direccion 	char(30) 	No 		
Latitud 	char(30) 	Sí 	NULL 	
Longitud 	char(30) 	Sí 	NULL 	
idCategoria 	char(10) 	No 		
Ciudad 	char(30) 	No 		
Pais 	char(20) 	No 		
Telefono 	char(9) 	No */
			
			while($obj = $result->fetch_object()){
				if($i > 0)
					$json .= ",";				
				$json .= " { \"nombreLocal\" : ".$obj->NombreLocal.", \"direccion\": \"".$obj->Direccion."\", \"latitud\": \""
						.$obj->Latitud."\", \"longitud\": \"".$obj->Longitud. "\", \"idCategoria\": \"".$obj->idCategoria."\",
								\"ciudad\": \"".$obj->Ciudad. "\", \"pais\": \"".$obj->Pais."\", \"telefono\": \"".$obj->Telefono."\",								
								 \"idLocal\": \"".$obj->idLocal."\" ";		
		
				$json .= "} ";
				$i++;
			}
		
			$json .= " ] ";
			$json .= " } ";
			return $json;
		}
	}
	
	public function getJSONLocales(){	
		$result = $this->getLocales();
		$json=$this->formateaJSON($result);
		return $json;		
	}

	public function getJSONLocalesCiudad($ciudad){
		$result = $this->getLocalesCiudad($ciudad);
		$json=$this->formateaJSON($result);
		return $json;	
	}
	
	
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "exito" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>