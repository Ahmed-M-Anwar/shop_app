<?php
session_start();
$pagetitle='Login';
if(isset($_SESSION['user'])){
    header('Location:index.php');
  }
  include 'init.php';
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(isset($_POST['signup'])){
        
        $formErrors = array();

        if(isset($_POST['username'])){
            $filteruser=filter_var($_POST['username'],FILTER_SANITIZE_STRING);
            
            if(strlen($filteruser) < 4){
              $formErrors[] = 'Username Must Be Larger Than 4 Characters'; 
            }
        }

        if(isset($_POST['phone'])){
            $filterphone=filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
            
            if(strlen($filterphone) < 11){
              $formErrors[] = 'phone Must Be 11 number'; 
            }

            if(filter_var($_POST['phone'] ,FILTER_SANITIZE_STRING) != true){
              $formErrors[] = 'This phone Is Not Valid'; 
            }
        }


        if(empty($formErrors)){
            //insert user
           $check =checkItem('phone','users',$_POST['phone']);

           if($check == 1){
             $formErrors[] = 'This User Is Exists';
           }else{

              $stmt = $db->prepare("INSERT INTO 
              users(username,phone)
              VALUES(:zuser,:zphone)
              ");
              $stmt->execute(array('zuser'=>$_POST['username'],
              'zphone'=>$_POST['phone'],
              
              ));

              $successmsg = 'Congrats You Are Now Registerd User.';

           }
        }

       }else{
         
          $user=$_POST['username'];
          $phone=$_POST['phone'];

          $stmt=$db->prepare("SELECT user_id,username,phone from users where username=? and phone=?");
          $stmt->execute(array($user,$phone));
          $get = $stmt->fetch();
          $count = $stmt->rowCount();
          
          if($count >0){
          $_SESSION['user']=$user;
          $_SESSION['userId']=$get['user_id'];
          header('Location:index.php');
          exit();
          }
       }
  }
?>
<div class='container login-page'>
     <h1 class='text-center'>
        <span class='selected' data-class='login'>Login</span> | <span data-class='signup'>SignUp</span>
     </h1>
     <form class='login' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
         <div class='input-container'>
         <input type='text' name='username' autocomplete='off' class='form-control' placeholder='ادخل اسم المستخدم' required>
         </div>
         <div class='input-container'>
         <input type='text' name='phone' class='form-control' placeholder='ادخل رقم التليفون' required>
         </div>
         <input type='submit' value='Login' name='login' class='btn btn-primary btn-block'>
     </form>
     <form class='signup' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
         <div class='input-container'>
         <input pattern='.{4,8}' title='Username Must Be Bettwen 4 & 8 chars' type='text' name='username' autocomplete='off' class='form-control' placeholder=' اسم المستخدم' required>
         </div>
         <div class='input-container'>
         <input type='text' name='phone' class='form-control' placeholder=' رقم التليفون' required>
         </div>
       
         <input type='submit' value='SignUp' name='signup' class='btn btn-success btn-block' >
     </form>
     <div class='the-errors text-center'>
        <?php 
        if(!empty($formErrors)){
          foreach ($formErrors as $err) {
             echo '<div class="msg error">'.$err.'</div>';
          }
        }
        if(isset($successmsg)){
          echo '<div class="msg success">'.$successmsg.'</div>';
        }
        ?>
     </div>
</div>
<?php
  include $tpl . "footer.php"; 
?>