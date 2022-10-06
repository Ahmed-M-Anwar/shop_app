<?php

  /**
   * manage member bage
   * edit|add|delete members
   */
  ob_start();
  session_start(); 
  $pagetitle='احصائيات';
  if(isset($_SESSION['myuser'])){
        include 'init.php';
        $do=isset($_GET['do'])? $_GET['do']:'manage';

        if($do == 'manage'){ 
               $stmt=$db->prepare('SELECT my_price , customer_price , num_item from items ');
               $stmt->execute();
               $items=$stmt->fetchAll();
               $sum=0;
               $sum2=0;
               foreach($items as $item){
                   $sum+=$item['my_price']*$item['num_item'];
                   $sum2+=$item['customer_price']*$item['num_item'];
               }
               echo $sum .','.$sum2;
        }elseif($do == 'Delete'){

        }
    include $tpl . "footer.php";
    }else{
    header('Location: index.php');
    exit();
    }
    ob_end_flush();
?>    


