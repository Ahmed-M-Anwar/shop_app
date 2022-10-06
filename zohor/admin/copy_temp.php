<?php

  /**
   * manage member bage
   * edit|add|delete members
   */
  ob_start();
  session_start(); 
  $pagetitle='Members';
  if(isset($_SESSION['username'])){
        include 'init.php';
        $do=isset($_GET['do'])? $_GET['do']:'manage';

        if($do == 'manage'){ 

        }elseif($do == 'Add'){

        }elseif($do == 'Insert'){

        }elseif($do == 'Edit'){

        }elseif($do == 'Update'){

        }elseif($do == 'Delete'){

        }
    include $tpl . "footer.php";
    }else{
    header('Location: index.php');
    exit();
    }
    ob_end_flush();
?>    


