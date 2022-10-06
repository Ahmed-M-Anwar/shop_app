<?php

  /**
   * manage member bage
   * edit|add|delete members
   */
  ob_start();
  session_start(); 
  $pagetitle='الاصناف';
  if(isset($_SESSION['myuser'])){
        include 'init.php';
        $do=isset($_GET['do'])? $_GET['do']:'manage';

        if($do == 'manage'){ 
          $sort = 'ASC';
          $sort_array=array('ASC','DESC');

          if(isset($_GET['order']) && in_array($_GET['order'],$sort_array)){
            $sort=$_GET['order'];
          }

          $stmt = $db->prepare("SELECT * FROM categories ORDER BY ID $sort");
          $stmt->execute();
          $cats = $stmt->fetchAll(); 
          if(!empty($cats)){
          ?>

          <h1 class='text-center'>ادارة الاصناف</h1>
          <div class='container categories'>
             <div class='panel panel-default'>
               <div class='panel-heading'>
                  <div class='option'>
                   [<a href='?order=DESC' class='<?PHP if($sort == 'DESC') {echo 'active';} ?>'> الاحدث </a> | <a href='?order=ASC' class='<?PHP if($sort == 'ASC') {echo 'active';} ?>'> الاقدم </a>]
                    ترتيب
                    <i class="fa fa-sort-amount-up-alt"></i> 
                  </div>
                  <span class='pull-right' style='margin-top: -21px;'>
                   ادارة الاصناف
                   <i class='fa fa-edit'></i>
                  </span>

                  </div>
                  <div class='panel-body'>
                  <?php
                      foreach($cats as $cat){
                        echo '<div class="cat">';
                            echo '<div class="hidden-buttons  pull-left">';
                              echo '<a href="categories.php?do=Edit&catid='.$cat['ID'].'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> تعديل</a>';
                              echo '<a href="categories.php?do=Delete&catid='.$cat['ID'].'" class="confirm btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i> حذف</a>';
                            echo '</div>';
                            echo '<h3>'.$cat['Name'].'</h3>';
                            echo '<div class="full-view  pull-right">';
                                echo '<p>'; if($cat['Description'] == ''){echo 'this category has no description';}else{echo $cat['Description'];} echo '</p>';
                                
                            echo '</div>';
                        
                        echo '</div>';
                        echo '<hr>';
                      }
                  ?>
                  </div>
             </div>
             <a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة صنف جديد</a>
             <?php }else{
                    echo '<div class="container">';
                    echo '<div class="alert alert-info text-center"> لا يوجد اصناف ليتم عرضها ادخل الاصناف اولا</div>';
                    echo ' <a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة صنف جديد</a>';
                    echo '</div>';
                } ?>
            
          </div>

         <?php
        }elseif($do == 'Add'){?>
          <h1 class='text-center'>اضافة صنف جديد</h1>
            <div class='container'>
                <form class='form-horizontal' action='?do=Insert' method='POST'>
                
                    <!--start Name field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>اسم الصنف</label>
                        <div class='col-sm-10'>
                        <input type='text' name='name' class='form-control' autocomplete='off' required='required' placeholder='اسم الصنف'>
                        </div>
                    </div>
                    <!--start Name field-->
                    <!--start Description field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>الوصف</label>
                        <div class='col-sm-10'>
                        <input type='text' name='description' class='form-control' autocomplete='off'  placeholder='وصف الصنف' >
                        </div>
                    </div>
                    <!--end Description field-->
                    
                    <!--start submit field-->
                    <div class='form-group form-group-lg' >
                        <div class='col-sm-offset-2 col-sm-10'>
                        <input type='submit' value='اضافة الصنف' class='btn btn-primary btn-lg'>
                        </div>
                    </div>
                    <!--start submit field-->


                </form>
            </div>
        <?php
        }elseif($do == 'Insert'){
          //insert page
      
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

              echo '<h1 class="text-center">تسجيل الصنف</h1>';
              // get data from post request
                
                $name      =$_POST['name'];
                $desc      =$_POST['description'];
                
                        
                //validate the form
                echo '<div class="container">';
                
                $check = checkItem('Name','categories',$name);
                if($check == 1){
                      echo '<div class="alert alert-danger text-center">ناسف هذا الصنف موجود بالفعل</div>';
                }else{
                  
                    $stmt = $db->prepare("INSERT INTO 
                                            categories(Name,Description)
                                            VALUES(:zname,:zdesc)
                                      ");
                    $stmt->execute(array('zname'=>$name,
                                          'zdesc'=>$desc
                                          ));

                    $theMsg= '<div class="alert alert-success text-center">'. $stmt->rowCount() . ' صنف تم تسجيله</div>';
                    redirectHome($theMsg,'back',0.1);
                  }
              
            }else{
                $theMsg='<div class="alert alert-danger">sorry you can"\t browse this page directly</div>' ;
                redirectHome($theMsg);
            }

        }elseif($do == 'Edit'){
            $catid=isset($_GET['catid'])&is_numeric($_GET['catid'])?intval($_GET['catid']):0;
            $stmt=$db->prepare("SELECT * from categories where ID=?");
            $stmt->execute(array($catid));
            $cat=$stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0){
            ?>

                <h1 class='text-center'>تعديل صنف</h1>
                <div class='container'>
                    <form class='form-horizontal' action='?do=Update' method='POST'>
                    <input type='hidden' name='ID' value='<?php echo $catid ?>' >
                        <!--start Name field-->
                        <div class='form-group form-group-lg' >
                            <label class='col-sm-2 control-label'>اسم الصنف</label>
                            <div class='col-sm-10'>
                            <input type='text' name='name' class='form-control' autocomplete='off' required='required' value='<?php echo $cat['Name']; ?>' placeholder='ادخل اسم الصنف'>
                            </div>
                        </div>
                        <!--start Name field-->
                        <!--start Description field-->
                        <div class='form-group form-group-lg' >
                            <label class='col-sm-2 control-label'>الوصف</label>
                            <div class='col-sm-10'>
                            <input type='text' name='description' class='form-control'  placeholder='ادخل الوصف' value='<?php  echo $cat['Description']; ?>'>
                            </div>
                        </div>
                        <!--end Description field-->
                        
                        <!--start submit field-->
                        <div class='form-group form-group-lg' >
                            <div class='col-sm-offset-2 col-sm-10'>
                            <input type='submit' value='تعديل الصنف' class='btn btn-primary btn-lg'>
                            </div>
                        </div>
                        <!--start submit field-->


                    </form>
                </div>

            <?php
            }else{
              echo '<div class="container">';
              $theMsg= '<div class="alert alert-danger text-center">خطأ اختر صنف محدد</div>';
              redirectHome($theMsg);
              echo '</div>';
            }

        }elseif($do == 'Update'){
              echo '<h1 class="text-center">تحديث الصنف</h1>';
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get data from post request
                   $id       =$_POST['ID'];
                   $name     =$_POST['name'];
                   $desc     =$_POST['description'];
                
                   
                  echo '<div class="container">';
                   

                    $stmt=$db->prepare("UPDATE categories
                                        SET 
                                            Name = ? ,
                                            Description = ?
                                        WHERE ID = ? ");
                  
                    $stmt->execute(array($name,$desc,$id));
                    
                    $theMsg= '<div class="alert alert-success text-center">'. $stmt->rowCount() . 'صنف تم تحديثه</div>';
                    redirectHome($theMsg,'back',0.1);
                
              }else{
                $theMsg='<div class="alert alert-danger">' .'sorry you can"/t browse this page directly</div>' ;
                   redirectHome($theMsg);
              }
              echo '</div>';

        }elseif($do == 'Delete'){
          echo '<h1 class="text-center">حذف صنف</h1>';
          echo '<div class="container">';
              $catid=isset($_GET['catid'])&is_numeric($_GET['catid'])?intval($_GET['catid']):0;
              
              $chek=checkItem('ID','categories',$catid);
              
              if($chek > 0){
                $stmt = $db->prepare('DELETE FROM categories WHERE ID = :zid ');
                $stmt->bindParam(':zid',$catid);
                $stmt->execute();
                 
                $theMsg='<div class="alert alert-success">'. $stmt->rowCount() . ' صنف تم حذف.</div>';
                redirectHome($theMsg,'back',0.1);

              }else{
                $theMsg= '<div class="alert alert-danger">' ."no category to deleted</div>" ;
                redirectHome($theMsg);
              }
              echo '</div>';
        }
    include $tpl . "footer.php";
    }else{
    header('Location: index.php');
    exit();
    }
    ob_end_flush();
?>    