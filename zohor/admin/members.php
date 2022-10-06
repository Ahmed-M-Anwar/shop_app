<?php

  /**
   * manage member bage
   * edit|add|delete members
   */
  session_start(); 
  $pagetitle='Members';
  if(isset($_SESSION['myuser'])){
    include 'init.php';
    $do=isset($_GET['do'])? $_GET['do']:'manage';

    if($do == 'manage'){  


      $stmt = $db->prepare("SELECT * FROM users WHERE groupID != 1 ");
      $stmt->execute();
      $rows = $stmt->fetchAll();
      if(!empty($rows)){
      ?>

      <h1 class='text-center'>قائمة العملاء</h1>
      <div class='container'>
      <div class='table-responsive'>
         <table class='main-table text-center table table-bordered '>
          <tr>
             <td>Control</td>
             <td>رقم التليفون</td>
             <td>اسم العميل</td>
             <td>#ID</td>
          </tr>
          <?php 
             foreach($rows as $Row){
              echo '<tr>';
              echo '<td>
                          <a href="members.php?do=edit&userid='.$Row['user_id'].'" class="btn btn-success"><i class="fas fa-edit"></i>تعديل</a>
                          <a href="members.php?do=Delete&userid='.$Row['user_id'].'" class="confirm btn btn-danger"><i class="fas fa-trash-alt"></i> حذف</a>'.
                      '</td>';
                 echo '<td>'.$Row['phone'].'</td>';
                 echo '<td>'.$Row['username'].'</td>';
                 echo '<td>'.$Row['user_id'].'</td>';
                 
              echo '</tr>';
             }
             
          ?>
          
          
         </table>
      </div>
      <a href="?do=Add" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>  اضافة عميل</a> 
      <?php }else{
                    echo '<div class="container">';
                    echo '<div class="alert alert-info text-center">.لا يوجد عملاء لدينا </div>';
                    echo ' <a href="?do=Add" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> اضافة عميل</a>';
                    echo '</div>';
                } ?>
           
      </div>
    <?php 
      
      }elseif($do == 'Add'){ ?>

<h1 class='text-center'>اضافة عميل جديد</h1>
    <div class='container'>
         <form class='form-horizontal' action='?do=Insert' method='POST'>
         
             <!--start username field-->
             <div class='form-group form-group-lg' >
                 <label class='col-sm-2 control-label'>اسم العميل</label>
                 <div class='col-sm-10'>
                   <input type='text' name='username' class='form-control' autocomplete='off' required='required' placeholder='ادخل اسم العميل'>
                 </div>
             </div>
             <!--start username field-->
           
             <!--start full name field-->
             <div class='form-group form-group-lg' >
                 <label class='col-sm-2 control-label'>رقم التليفون</label>
                 <div class='col-sm-10'>
                   <input type='text' name='phone' autocomplete='off' class='form-control' required='required' placeholder='اخل رقم التليفون'>
                 </div>
             </div>
             <!--start full name field-->
             <!--start submit field-->
             <div class='form-group form-group-lg' >
                 <div class='col-sm-12'>
                   <input type='submit' value='اضافه' class='btn btn-primary btn-lg'>
                 </div>
             </div>
             <!--start submit field-->


         </form>
    </div>

    <?php
    
    }elseif($do == 'Insert'){
        
      //insert page
      
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        echo '<h1 class="text-center">ادخال عميل</h1>';
        // get data from post request
          
           $user     =$_POST['username'];
           $phone     =$_POST['phone'];
           
           
           
                   
           //validate the form
          echo '<div class="container">';
           $formErrors=array();

           if(strlen($user) > 20){
                $formErrors[]='اسم العميل لا يكون اكبر من <strong>عشرون حرف</strong>';
           }

           if(strlen($user) < 4){
            $formErrors[]='اسم العميل لا يكون اقل من <strong>اربع حروف </strong>';
           }

           if(empty($user)){
            $formErrors[]=' اسم العميل لا يمكن ان يكون  <strong>فارغا</strong>';
           }

           if(empty($phone)){
            $formErrors[]='  رقم التليفون لا يمكن ان يكون  <strong>فارغا</strong>';
           }
 
           foreach($formErrors as $error){
                echo '<div class="alert alert-danger text-center">'.$error.'</div>' ;
           }

        //update the database with this info
        if(empty($formErrors)){
           
          $check = checkItem('phone','users',$phone);
          if($check == 1){
                echo '<div class="alert alert-danger text-center">هذا العميل مسجل بالفعل .</div>';
          }else{
            
              $stmt = $db->prepare("INSERT INTO 
                                      users(username,phone)
                                      VALUES(:zuser,:zphone)
                                ");
              $stmt->execute(array('zuser'=>$user,
                                    'zphone'=>$phone
                                    ));

              $theMsg= '<div class="alert alert-success text-center">'. $stmt->rowCount() . 'عميل تم اضافته</div>';
              redirectHome($theMsg,'back',0.1);
            }
        }
      }else{
           $theMsg='<div class="alert alert-danger text-center">sorry you can"\t browse this page directly</div>' ;
           redirectHome($theMsg);
      }

    }
    elseif($do == 'edit'){ 
        
              $userid=isset($_GET['userid'])&is_numeric($_GET['userid'])?intval($_GET['userid']):0;
              $stmt=$db->prepare("SELECT * from users where user_id=? LIMIT 1");
              $stmt->execute(array($userid));
              $row=$stmt->fetch();
              $count = $stmt->rowCount();
              if($count > 0){
              ?>

          <h1 class='text-center'>تعديل معلومات العميل</h1>
          <div class='container'>
              <form class='form-horizontal' action='?do=update' method='POST'>
              <input type='hidden' name='ID' value=<?php echo $userid ?> >
                  <!--start username field-->
                  <div class='form-group form-group-lg' >
                      <label class='col-sm-2 control-label'>اسم العميل</label>
                      <div class='col-sm-10'>
                        <input type='text' name='username' value='<?php echo $row['username'] ?>' class='form-control' autocomplete='off' required='required'>
                      </div>
                  </div>
                  <!--start username field-->
                  <!--start full name field-->
                  <div class='form-group form-group-lg' >
                      <label class='col-sm-2 control-label'>رقم التليفون</label>
                      <div class='col-sm-10'>
                        <input type='text' name='phone' value='<?php echo $row['phone'] ?>'  class='form-control'  autocomplete='off' required='required'>
                      </div>
                  </div>
                  <!--start full name field-->
                  <!--start submit field-->
                  <div class='form-group form-group-lg' >
                      <div class='col-sm-12'>
                        <input type='submit' value='تعديل' class='btn btn-primary btn-lg'>
                      </div>
                  </div>
                  <!--start submit field-->


              </form>
          </div>

            <?php
              }else{
                echo '<div class="container">';
                $theMsg= '<div class="alert alert-danger">there is no id</div>';
                redirectHome($theMsg);
                echo '</div>';
              }
            }elseif($do == 'update'){
              echo '<h1 class="text-center">تحديث بيانات العميل</h1>';
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get data from post request
                   $id       =$_POST['ID'];
                   $user     =$_POST['username'];
                   $phone    =$_POST['phone'];
                   
                   
                   //validate the form
                      echo '<div class="container">';
                      $formErrors=array();

                      if(strlen($user) > 20){
                          $formErrors[]='اسم العميل لا يكون اكبر من <strong>عشرون حرف</strong>';
                      }

                      if(strlen($user) < 4){
                      $formErrors[]='اسم العميل لا يكون اقل من <strong>اربع حروف </strong>';
                      }

                      if(empty($user)){
                      $formErrors[]=' اسم العميل لا يمكن ان يكون  <strong>فارغا</strong>';
                      }

                      if(empty($phone)){
                      $formErrors[]='  رقم التليفون لا يمكن ان يكون  <strong>فارغا</strong>';
                      }

                      foreach($formErrors as $error){
                          echo '<div class="alert alert-danger text-center">'.$error.'</div>' ;
                      }


                //update the database with this info
                if(empty($formErrors)){
                    $stmt=$db->prepare("UPDATE users SET username = ? ,phone = ? WHERE user_id = ?");
                  
                    $stmt->execute(array($user,$phone,$id));
                    
                    $theMsg= '<div class="alert alert-success text-center">'. $stmt->rowCount() . 'عميل تم تعديله</div>';
                    redirectHome($theMsg,'back',0.1);
                }
              }else{
                $theMsg='<div class="alert alert-danger">' .'sorry you can"/t browse this page directly</div>' ;
                   redirectHome($theMsg);
              }
              echo '</div>';
            }elseif($do == 'Delete'){
              echo '<h1 class="text-center">حذف عميل</h1>';
              echo '<div class="container">';
                  $userid=isset($_GET['userid'])&is_numeric($_GET['userid'])?intval($_GET['userid']):0;
                  
                  $chek=checkItem('user_id','users',$userid);
                  
                  if($chek > 0){
                    $stmt = $db->prepare('DELETE FROM users WHERE user_id = :zid ');
                    $stmt->bindParam(':zid',$userid);
                    $stmt->execute();
                     
                    $theMsg= '<div class="alert alert-success text-center">'. $stmt->rowCount() . 'عميل تم حذفه</div>';
                    redirectHome($theMsg,'back',0.1);

                  }else{
                    $theMsg= '<div class="alert alert-danger">' ."no member to deleted</div>" ;
                    redirectHome($theMsg);
                  }
                  echo '</div>';
            }
                     

    include $tpl . "footer.php";
  }else{
      header('Location: index.php');
      exit();
  }