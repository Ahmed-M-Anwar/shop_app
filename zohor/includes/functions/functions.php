<?php

function getItem(){
    global $db;
    $stmt = $db->prepare("SELECT items.* , 
                                         categories.Name AS cat_name  
                                      FROM 
                                         items
                                      INNER JOIN 
                                          categories
                                      ON
                                          categories.ID=items.cat_id
                                      
                                          
                                    ");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                return $rows;
}

//get categories
function getcat(){
    global $db;
       $getcat = $db->prepare("SELECT * FROM categories ORDER BY ID ASC ");
       $getcat->execute();
       $cats = $getcat->fetchAll();
       return $cats;
}

function getitems($where ,$val){
    global $db;
    
    
       $getcat = $db->prepare("SELECT * FROM items where $where=? ORDER BY item_id DESC ");
       $getcat->execute(array($val));
       $cats = $getcat->fetchAll();
       return $cats;
}


function getAllItem($table,$order){
    global $db;
    $sql=$db->prepare("SELECT * FROM $table ORDER BY $order DESC ");
    $sql->execute();
    $Items = $sql->fetchAll();
    return $Items;
}


//check user status
function checkUserStatus($user){
    global $db;
    $stmt=$db->prepare("SELECT username,RegStatus from users where username=? and RegStatus=0");
    $stmt->execute(array($user));
    
    $status = $stmt->rowCount();
    return $status;

}


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
     echo '<div class="alert alert-info">you will be redirect to '.$link.' after ' .$seconds .' seconds.</div>';
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


 //function to get latest items and comments and members
 function getLatest($select,$from,$order,$limit = 2){
       global $db;
       $getstmt = $db->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit ");
       $getstmt->execute();
       $rows = $getstmt->fetchAll();
       return $rows;
 }