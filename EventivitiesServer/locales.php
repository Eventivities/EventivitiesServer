<?php
include_once('globales.php');
include_once('bdadministrador.php');

class locales{

	/*public function getLocales(){
		$sql = "SELECT * ";
		$sql .= " FROM Local ";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}*/
	
	public function getLocalesCiudad($ciudad, $categoria){
		/*$sql = "SELECT * ";
		$sql .= " FROM Local WHERE ciudad='".$ciudad."'";	*/
		if ($categoria == "0")
			$sql="SELECT * FROM Local LEFT JOIN Imagen ON Local.idImagen=Imagen.idImagen WHERE ciudad='".$ciudad."'";
		else
			$sql="SELECT * FROM Local LEFT JOIN Imagen ON Local.idImagen=Imagen.idImagen WHERE ciudad='".$ciudad."' AND idCategoria='".$categoria."'";
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
/*Comentarios de la tabla: Local

Columna 	Tipo 	Nulo 	Predeterminado 	Comentarios
idLocal 	int(11) 	No 		
NombreLocal 	char(30) 	Sí 	NULL 	
Direccion 	char(30) 	No 		
Latitud 	char(30) 	Sí 	NULL 	
Longitud 	char(30) 	Sí 	NULL 	
idCategoria 	char(10) 	No 		
Ciudad 	char(30) 	No 		
Pais 	char(20) 	No 		
Telefono 	char(15) 	No 		
idImagen 	int(11) 	No 		*/			
/*			Comentarios de la tabla: Imagen
			
			Columna 	Tipo 	Nulo 	Predeterminado 	Comentarios
			idImagen 	int(11) 	No
			Nombre 	char(100) 	No
			FECHA 	timestamp 	No 	CURRENT_TIMESTAMP*/
			while($obj = $result->fetch_object()){						
				if($i > 0)
					$json .= ",";				
				$json .= " { \"nombreLocal\" : \"".$obj->NombreLocal."\", \"direccion\": \"".$obj->Direccion."\", \"latitud\": \""
				.$obj->Latitud."\", \"longitud\": \"".$obj->Longitud. "\", \"idCategoria\": \"".$obj->idCategoria."\",
				\"ciudad\": \"".$obj->Ciudad. "\", \"pais\": \"".$obj->Pais."\", \"telefono\": \"".$obj->Telefono."\",";							
				
				//Si la idImagen es nula, lo serán también todos los campos de la tabla Imagen
				if($obj->idImagen==null)	
					$json.="\"idImagen\": null, \"nombreImg\": null, \"fechaImg\": null,";
				else								
					$json.="\"idImagen\": \"".$obj->idImagen. "\", \"nombreImg\": \"".$obj->NombreImg."\", \"fechaImg\": \"".$obj->FechaImg."\",";
				
				$json.="\"idLocal\": \"".$obj->idLocal."\" ";
				$json .= "} ";
				$i++;
				
			}
		
			$json .= " ] ";
			$json .= " } ";
			return $json;
		}
	}
	/*
	public function getJSONLocales(){	
		$result = $this->getLocales();
		$json=$this->formateaJSON($result);
		return $json;		
	}*/

	public function getJSONLocalesCiudad($ciudad, $categoria){
		$result = $this->getLocalesCiudad($ciudad, $categoria);
		$json=$this->formateaJSON($result);
		return $json;	
	}
	
	
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "exito" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>