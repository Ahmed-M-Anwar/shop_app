<!DOCTYPE html>
<html>
     <head>
         <meta charset='UTF-8'>
         <title><?php getTitle(); ?></title>
         
         <link rel='stylesheet' href='<?php echo $css; ?>bootstrap.css'>
         <link rel='stylesheet' href='<?php echo $css; ?>front.css'>
         <link rel='stylesheet' href='<?php echo $css; ?>fontawesome.min.css'>
         <link rel='stylesheet' href='<?php echo $css; ?>jquery-ui.css'>
         <link rel='stylesheet' href='<?php echo $css; ?>jquery.selectBoxIt.css'>
         <link href="<?php echo $css; ?>fontawesome.css" rel="stylesheet">
         <link href="<?php echo $css; ?>brands.css" rel="stylesheet">
         <link href="<?php echo $css; ?>solid.css" rel="stylesheet">
         <script defer src="<?php echo $js; ?>all.js"></script>
     </head>
     <body>
     <div class='upper-bar'>
         <div class='container'>
             <?php 
               if(isset($_SESSION['user'])){?>
               
               <img class='my-image  img-thumbnail img-circle' src="images.jpg" alt=''>
               <div class='btn-group my-info'>
                   <span class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                       <?php echo $_SESSION['user']; ?>
                       <span class='caret'></span>
                   </span>
                   <ul class='dropdown-menu'>
                       <li><a href='profile.php'>My Profile</a></li>
                       <li><a href='makeOrder.php'>Make Order</a></li>
                       <li><a href='Logout.php'>Logout</a></li>
                   </ul>
               </div>
                   
                   <?php
               }else{
             ?>
           <a href='login.php'>
               <span class='pull-right'>Login/SignUp</span>
           </a>
            <?php } ?>
         </div>
     </div>
     <nav class="navbar navbar-inverse">
        <div class="container">
            
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">ZOHOR<span>.ELTAWHED<span></a>
            </div>

            
            <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav navbar-right">
               <?php
                foreach(getcat() as $cat){
                    echo '<li><a href="categories.php?catid='.$cat['ID'].'&pagename='.str_replace(' ','-',$cat['Name']).'">'.$cat['Name'].'</a></li>';
                }
                ?>
            </ul>
            
            </div>
        </div><!-- /.container-fluid -->
        </nav>