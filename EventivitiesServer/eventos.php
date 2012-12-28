<?php
include_once('globales.php');
include_once('bdadministrador.php');

class eventos{

	public function getEventos(){
		/*$sql = "SELECT * ";
		$sql .= " FROM Evento ";	*/	
		$sql="SELECT Evento.idEvento as idEvento,Nombre,Descripcion,FechaInicio,FechaFin,idLocal,idTipoEvento,Precio,Director,Interpretes,Coalesce( avg( Puntuacion ), 0 ) as media
		FROM Evento LEFT JOIN Puntuacion on Puntuacion.idEvento=Evento.idEvento 
		GROUP BY Evento.idEvento";		
		$db = new bdadministrador();
		return $db->executeQuery($sql);
	}
	
	public function getEventosLocal($idLocal){
		/*$sql = "SELECT * ";
		$sql .= " FROM Evento WHERE idLocal=".$idLocal;*/
		$sql="SELECT Evento.idEvento as idEvento,Nombre,Descripcion,FechaInicio,FechaFin,idLocal,idTipoEvento,Precio,Director,Interpretes,Coalesce( avg( Puntuacion ), 0 ) as media
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
				
				SELECT Evento.idEvento,Nombre,Descripcion,FechaInicio,FechaFin,idLocal,idTipoEvento,Precio,Director,
				Interpretes,avg(Puntuacion.Puntuacion) as media
				 FROM Evento LEFT JOIN Puntuacion on Puntuacion.idEvento=Evento.idEvento 
				 GROUP BY Evento.idEvento HAVING idLocal=1
				*/
				
				
				$json .= " { \"idEvento\" : ".$obj->idEvento.", \"nombre\": \"".$obj->Nombre."\", \"descripcion\": \""
						.$obj->Descripcion."\", \"fechaInicio\": \"".$obj->FechaInicio. "\", \"fechaFin\": \"".$obj->FechaFin."\",
								 \"idTipoEvento\": \"".$obj->idTipoEvento."\", \"precio\": \"".$obj->Precio."\",
								 \"director\": \"".$obj->Director."\", \"interpretes\": \"".$obj->Interpretes."\",
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
	
	private function insertLibro($libro, $isbn){
		$sql = sprintf("INSERT INTO libros (libro, isbn) VALUES ('%s', '%s') ",mysql_real_escape_string($libro), mysql_real_escape_string($isbn));
	
		$db = new dbmanager();
		$result = $db->executeQuery($sql);
		if($result){
			$idlibro = mysql_insert_id();
			$sql = "SELECT * FROM libros WHERE id_libro = " . $idlibro;
			$result = $db->executeQuery($sql);
			return mysql_fetch_array($result,MYSQL_BOTH);
		} else {
			return false;
		}
	}
	
	public function getJSONInsertLibros($libro, $isbn){
		$response = array("tag" => "insert", "success" => 0, "error" => 0);
		$libro = $this->insertLibro($libro, $isbn);
		if($libro != false){
			$response["success"] = 1;
	
			$response["libro"]["id"] = $libro['id_libro'];
			$response["libro"]["titulo"] = $libro['libro'];
			$response["libro"]["isbn"] = $libro['isbn'];
	
			return json_encode($response);
		} else {
			$response["error"] = 1;
			$response["error_msg"] = "No se insertó el libro";
			return json_encode($response);
		}
	}
	
	public function getJSONError($tag, $errormsg){
		$response = array("tag" => $tag, "exito" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>