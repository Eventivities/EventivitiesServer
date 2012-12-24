<?php
include_once('globals.php');

class dbmanager{
 
 public function executeQuery($sql){
  $link = mysqli_connect(config::getBBDDServer(), config::getBBDDUser(), config::getBBDDPwd());
  //$link = mysql_connect(config::getBBDDServer(), config::getBBDDUser(), config::getBBDDPwd());
  if (!$link)
    {
     die('Could not connect: ' . mysql_error());
    }
  
 // mysql_select_db(config::getBBDDName(), $link);
    $link->select_db(config::getBBDDName());
    
  //$result = mysql_query($sql);
    $result = $link->query($sql);
    
  
  $link->close();
  return $result;
 }
}
?>