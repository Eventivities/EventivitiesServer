<?php
include_once('globals.php');
include_once('dbmanager.php');

class libros{

	public function getLibros(){
		$sql = "SELECT l.* ";
		$sql .= " FROM libros AS l ";
		$db = new dbmanager();
		return $db->executeQuery($sql);
	}

	public function getJSONLibros(){
		$json = "";
		$i = 0;
		$result = $this->getLibros();
		$json .= " { \"libros\" : [ ";
		if($result!=null)
		{
			while($obj = $result->fetch_object()){
				if($i > 0)
					$json .= ",";
	
				$json .= " { \"id\" : ".$obj->idlibro.", \"libro\": \"".$obj->libro."\", \"isbn\": \"".$obj->isbn."\" ";
				$json .= "} ";
				$i++;
			}
	
			$json .= " ] ";
			$json .= " } ";
			return $json;
		}
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
		$response = array("tag" => $tag, "success" => 0, "error" => 1, "error_msg" => $errormsg);
		return json_encode($response);
	}
}
?>