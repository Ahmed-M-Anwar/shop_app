<?php
  $dsn='mysql:host=localhost;dbname=eltawheed';
  $user='root';
  $password='';
  $option=array(
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
  );
  
  try{
    $db = new PDO($dsn,$user,$password,$option);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    /*echo 'you are connected';*/
  }catch(PDOException $e){
      echo 'failed to connect' . $e->getMessage();
      
  }
?>