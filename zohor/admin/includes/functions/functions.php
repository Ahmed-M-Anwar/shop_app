<?php

 function getTitle(){

    global $pagetitle;

    if(isset($pagetitle)){

        echo $pagetitle;
        
    }else{
        echo 'Default';
    }
 }

 /*home redirect function v2.0 */
 function redirectHome($theMsg ,$url = null, $seconds = 3){
     
    if($url ===null){
        $url='index.php';
        $link='Homepage';
    }else{
        if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!==''){
            $url=$_SERVER['HTTP_REFERER'];
            $link='Previous Page';
        }else{
            $url='index.php';
            $link='Homepage';
        }
    }
     echo $theMsg;
     echo '<div class="alert alert-info text-center">you will be redirect to '.$link.' after ' .$seconds .' seconds.</div>';
     header("refresh:".$seconds.";url=".$url);
 }

 //function to check items found
 function checkItem($select,$from,$value){
     global $db;
     $statement=$db->prepare("SELECT $select FROM $from WHERE $select = ?");
     $statement->execute(array($value));
     $count = $statement->rowCount();
     return $count;
 }

 //function to count number of items
 function countItems($item , $table){
     global $db;
     $stmt2 = $db->prepare("SELECT count($item) FROM $table ");
     $stmt2->execute();
     return $stmt2->fetchColumn();
 }

 function countorder($item , $table){
    global $db;
    $stmt2 = $db->prepare("SELECT sum($item) FROM $table  ");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

 function sum($item , $table){
    global $db;
    $stmt2 = $db->prepare("SELECT sum($item) FROM $table where order_date='2021-06-27' ");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

function sumAll($item , $table){
    global $db;
    $stmt2 = $db->prepare("SELECT sum($item*num_item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}


 //function to get latest items and comments and members
 function getLatest($select,$from,$order,$limit = 2){
       global $db;
       $getstmt = $db->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit ");
       $getstmt->execute();
       $rows = $getstmt->fetchAll();
       return $rows;
 }