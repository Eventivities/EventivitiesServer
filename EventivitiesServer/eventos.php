<?php
include_once('globales.php');
include_once('bdadministrador.php');

class eventos{

	public function getEventos(){
		/*$sql = "SELECT * ";
		$sql .= " FROM Evento ";	*/	
		$sql="SELECT Evento.idEvento as idEvento,Nombre,Descripcion,FechaInicio,FechaFin,idLocal,idTipoEvento,Precio,Director,Interpretes,Duracion, HoraInicio, Coalesce( avg( Puntuacion ), 0 ) as media
		FROM Evento LEFT JOIN Puntuacion on Puntuacion.idEvento=Evento.idEvento 
		GROUP BY Evento.idEvento";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function getEventosLocal($idLocal){
		/*$sql = "SELECT * ";
		$sql .= " FROM Evento WHERE idLocal=".$idLocal;*/
		$sql="SELECT Evento.idEvento as idEvento,Nombre,Descripcion,FechaInicio,FechaFin,idLocal,idTipoEvento,Precio,Director,Interpretes,Duracion, HoraInicio, Coalesce( avg( Puntuacion ), 0 ) as media
		FROM Evento LEFT JOIN Puntuacion on Puntuacion.idEvento=Evento.idEvento
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
				//"yyyy-MM-dd HH:mm"
				/*Comentarios de la tabla: Evento
				
				Columna 	Tipo 	Nulo 	Predeterminado 	Comentarios
				idEvento 	int(11) 	No
				Nombre 	text 	No
				Descripcion 	text 	No
				FechaInicio 	date 	No
				FechaFin 	date 	No
				idLocal 	int(11) 	No
				idTipoEvento 	int(11) 	No
				Precio 	double 	No 	0
				Director 	text 	No
				Interpretes 	text 	Sí 	NULL
				Duracion 	int(11) 	Sí 	NULL 	
				HoraInicio 	time 	Sí 	NULL
				
				SELECT Evento.idEvento,Nombre,Descripcion,FechaInicio,FechaFin,idLocal,idTipoEvento,Precio,Director,
				Interpretes,avg(Puntuacion.Puntuacion) as media
				 FROM Evento LEFT JOIN Puntuacion on Puntuacion.idEvento=Evento.idEvento 
				 GROUP BY Evento.idEvento HAVING idLocal=1
				*/
				
				
				$json .= " { \"idEvento\" : ".$obj->idEvento.", \"nombre\": \"".$obj->Nombre."\", \"descripcion\": \""
						.$obj->Descripcion."\", \"fechaInicio\": \"".$obj->FechaInicio. "\", \"fechaFin\": \"".$obj->FechaFin."\",
								 \"idTipoEvento\": \"".$obj->idTipoEvento."\", \"precio\": \"".$obj->Precio."\",
								 \"director\": \"".$obj->Director."\", \"interpretes\": \"".$obj->Interpretes."\",
								 \"duracion\": \"".$obj->Duracion."\", \"horaInicio\": \"".$obj->HoraInicio."\",								 		
								 \"media\": \"".$obj->media."\",
								 \"idLocal\": \"".$obj->idLocal."\" ";
		
		
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