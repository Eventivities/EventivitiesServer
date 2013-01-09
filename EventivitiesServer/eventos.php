<?php
include_once('globales.php');
include_once('bdadministrador.php');

class eventos{

	public function getEventos(){
		/*$sql = "SELECT * ";
		$sql .= " FROM Evento ";	*/	
		$sql="SELECT Evento.idEvento as idEvento,Nombre,Descripcion,FechaInicio,FechaFin,idLocal,idTipoEvento,Precio,Director,Interpretes,
		Duracion, HoraInicio, Coalesce( avg( Puntuacion ), 0 ) as media, Evento.idImagen, Imagen.NombreImg, Imagen.FechaImg				
		FROM Evento LEFT JOIN Puntuacion on Puntuacion.idEvento=Evento.idEvento LEFT JOIN Imagen ON Evento.idImagen=Imagen.idImagen 
		GROUP BY Evento.idEvento";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function getEventosLocal($idLocal){
		/*$sql = "SELECT * ";
		$sql .= " FROM Evento WHERE idLocal=".$idLocal;*/
		$sql="SELECT Evento.idEvento as idEvento,Nombre,Descripcion,FechaInicio,FechaFin,idLocal,idTipoEvento,Precio,Director,Interpretes,
		Duracion, HoraInicio, Coalesce( avg( Puntuacion ), 0 ) as media , Evento.idImagen, Imagen.NombreImg, Imagen.FechaImg
		FROM Evento LEFT JOIN Puntuacion on Puntuacion.idEvento=Evento.idEvento LEFT JOIN Imagen ON Evento.idImagen=Imagen.idImagen
		GROUP BY Evento.idEvento HAVING idLocal=".$idLocal;	
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function formateaJSON($result)
	{		
	
		$i = 0;
		$json = "";
		$json .= " { \"exito\" : \"1\" , \"eventos\" : [ ";
		if($result!=null)
		{			
			while($obj = $result->fetch_object()){
				if($i > 0)
					$json .= ",";
				//"yyyy-MM-dd HH:mm:ss"
				
				
				$json .= " { \"idEvento\" : ".$obj->idEvento.", \"nombre\": \"".$obj->Nombre."\", \"descripcion\": \""
				.$obj->Descripcion."\", \"fechaInicio\": \"".$obj->FechaInicio. "\", \"fechaFin\": \"".$obj->FechaFin."\",
				 \"idTipoEvento\": \"".$obj->idTipoEvento."\", \"precio\": \"".$obj->Precio."\",
				 \"director\": \"".$obj->Director."\", \"interpretes\": \"".$obj->Interpretes."\",
				 \"duracion\": \"".$obj->Duracion."\", \"horaInicio\": \"".$obj->HoraInicio."\",								 		
				 \"media\": \"".$obj->media."\",";
				 
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
	
	public function getJSONEventos(){	
		$result = $this->getEventos();
		$json=$this->formateaJSON($result);
		return $json;		
	}

	public function getJSONEventosLocal($idLocal){
		$result = $this->getEventosLocal($idLocal);
		$json=$this->formateaJSON($result);
		return $json;	
	}	
	
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "exito" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>