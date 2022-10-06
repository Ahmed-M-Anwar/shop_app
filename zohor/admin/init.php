<?php 

 //routes
 $tpl='includes/templates/';
 $func='includes/functions/';
 $css='layout/css/';
 $js='layout/js/';
 
 
 //db connect
 include 'connect.php';

 //important route
 include $func . 'functions.php';
 include $tpl . "header.php";

 //add navbar
 if(!isset($noNavbar)){ include $tpl . 'navbar.php';}
  