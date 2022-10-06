<?php
  session_start(); 
  $noNavbar='';
  $pagetitle='Login';
  if(isset($_SESSION['myuser'])){
    header('Location:dashboard.php');
  }
  include 'init.php';
  

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $username=$_POST['user'];
     $password=$_POST['pass'];
     

     $stmt=$db->prepare("SELECT user_id,username,phone from users where username=? and phone=?");
     
     $stmt->execute(array($username,$password));
     $row=$stmt->fetch();
     $count = $stmt->rowCount();
     
     if($count >0){
       $_SESSION['myuser']=$username;
       $_SESSION['id']=$row['user_id'];
       header('Location:dashboard.php');
       exit();
     }
   }
 ?>
           <form class='login' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
             <h4 class='text-center'>تسجيل دخول المسؤول</h4>
             <input class='form-control input-lg' type='text' name='user' placeholder='اسم المسؤول' autocomplete='off' />
             <input class='form-control input-lg' type='password' name='pass' placeholder='كلمة المرور' outocomplete='new-password' />
             <input class='btn btn-primary btn-block btn-sub' type='submit' value='تسجيل دخول'/>
           </form>

<?php include $tpl . "footer.php"; ?>