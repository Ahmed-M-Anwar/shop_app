<?php

  /**
   * manage member bage
   * edit|add|delete members
   */
  ob_start();
  session_start(); 
  $pagetitle='تخفيضات';
  if(isset($_SESSION['myuser'])){
        include 'init.php';
        $do=isset($_GET['do'])? $_GET['do']:'manage';

        if($do == 'manage'){ 
            echo '<h1 class="text-center">ادارة العروض</h1>';
            $stmt=$db->prepare('SELECT * FROM categories');
            echo '<div class="container">';
            $stmt->execute();
            $cats=$stmt->fetchAll();
            if(!empty($cats)){
            foreach($cats as $cat){
                $cat_v=$cat['ID'];
                $stmt = $db->prepare("SELECT offers.* , 
                                         categories.Name AS cat_name
                                      FROM 
                                         offers
                                      INNER JOIN 
                                          categories
                                      ON
                                          categories.ID=offers.cat_id
                                      where
                                        cat_id=$cat_v
                                          
                                    ");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                
                if(!empty($rows)){
                ?>
                
                
                <h2 ><?php echo $cat['Name'] ;?> -</h2>
                <div class='table-responsive'>
               <table class='main-table text-center table table-bordered'>
                <tr>
                   <td>Control</td>
                   <td>السعر بعد التخفيض</td>
                   <td>اسم السلعه</td>
                   
                </tr>
                <?php 
                   foreach($rows as $Row){
                    echo '<tr>';
                        echo '<td>
                        <a href="items.php?do=Edit&offerid='.$Row['offer_id'].'" class="btn btn-success"><i class="fas fa-edit"></i>تعديل</a>
                        <a href="items.php?do=Delete&offerid='.$Row['offer_id'].'" class="confirm btn btn-danger"><i class="fas fa-trash-alt"></i> حذف</a>
                        </td>';
                       echo '<td>'.$Row['offer_price'].'</td>';
                       echo '<td>'.$Row['offer_name'].'</td>';
                      
                    echo '</tr>';
                   }
                   
                ?>
                 </table>
                 
                </div>
                  
                <?php }else{?>
                         <div class='container'>
                         <h2 ><?php echo $cat['Name'] ;?> -</h2>
                         <div class="alert alert-info text-center">عفوا,لا  يوجد تخفيضات بهذا القسم</div>
                         </div>
                
                     <?php }
                }?>
                <a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> اضافة عرض جديد </a>
                </div>
                <?php 
                 }else{
                    echo '<div class="container">';
                    echo '<div class="alert alert-info">لا يوجد اصناف اذهب لملئ الاصناف اولا .</div>';
                    echo ' <a href="categories.php" class="btn btn-primary"><i class="fa fa-plus"></i> اضافة اصناف</a>';
                    echo '</div>';
                }
        }elseif($do == 'Add'){
            ?>
            <h1 class='text-center'>تسجيل سلعه جديده</h1>
            <div class='container'>
                <form class='form-horizontal' action='?do=Insert' method='POST'>
                
                    <!--start Name field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>اسم السلعه</label>
                        <div class='col-sm-10'>
                        <select  name='name'>
                                <option value='0'>...</option>
                                <?php
                                  $stmt=$db->prepare('SELECT * FROM items where offer=1');
                                  $stmt->execute();
                                  $cats=$stmt->fetchAll();
                                  foreach($cats as $cat){
                                    echo "<option value='".$cat['item_id']."'>".$cat['Name']."</option>";
                                  }
                                 
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--start Name field-->
                    
                    <!--start Price field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>السعر بعد الخصم</label>
                        <div class='col-sm-10'>
                        <input type='text' name='myprice' class='form-control'  required='required' placeholder='ادخل السعر ' autocomplete='off'>
                        </div>
                    </div>
                    <!--start Price field-->
                    <!--start Category field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>الصنف</label>
                        <div class='col-sm-10' >
                            <select  name='category'>
                                <option value='0'>...</option>
                                <?php
                                  $stmt=$db->prepare('SELECT * FROM categories');
                                  $stmt->execute();
                                  $cats=$stmt->fetchAll();
                                  foreach($cats as $cat){
                                    echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                                  }
                                 
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--start Category field-->
                    
                    <!--start submit field-->
                    <div class='form-group form-group-lg' >
                        <div class='col-sm-12'>
                        <input type='submit' value='اضافه' class='btn btn-primary btn-md'>
                        </div>
                    </div>
                    <!--start submit field-->


                </form>
            </div>
            <?php
        }elseif($do == 'Insert'){
              
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class="text-center">حفظ العرض</h1>';
                // get data from post request
                
                $id_offer         =$_POST['name'];
                $stmt=$db->prepare("SELECT * FROM items where item_id=$id_offer");
                                  $stmt->execute();
                                  $cats=$stmt->fetch();
               
                $name         =$cats['Name'];
                $my_price     =$_POST['myprice'];
                
                $cat          =$_POST['category'];
                
               
                        
                //validate the form
                echo '<div class="container">';
                $formErrors=array();

               
                if(empty($my_price)){
                    $formErrors[]='my price can\'t be<strong> empty</strong>';
                }  

                
                if($id_offer == 0){
                    $formErrors[]='you must select <strong>name</strong>';
                }

                if($cat == 0){
                    $formErrors[]='you must select <strong>category</strong>';
                }
                    
                foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">'.$error.'</div>' ;
                }

                //update the database with this info
                if(empty($formErrors)){
                    
                    $stmt = $db->prepare("INSERT INTO 
                                            offers(offer_name,offer_price,cat_id)
                                            VALUES(:zname,:zprice,:zcat)
                                        ");
                    $stmt->execute(array('zname'=>$name,
                                         
                                         'zprice'=>$my_price,
                                         
                                         'zcat'=>$cat

                                        ));

                    $theMsg= '<div class="alert alert-success text-center">'. $stmt->rowCount() . ' عرض تم اضافته.</div>';
                    redirectHome($theMsg,'back');
                    }
                
            }else{
                $theMsg='<div class="alert alert-danger">sorry you can"\t browse this page directly</div>' ;
                redirectHome($theMsg);
            }
        }elseif($do == 'Edit'){
            $offerid=isset($_GET['offerid'])&is_numeric($_GET['offerid'])?intval($_GET['offerid']):0;
            $stmt=$db->prepare("SELECT * from offers where offer_id=?");
            $stmt->execute(array($offerid));
            $row=$stmt->fetch();
            $count = $stmt->rowCount();
            if($stmt->rowCount() > 0){
            ?>

        <h1 class='text-center'>تعديل العرض</h1>
        <div class='container'>
            <form class='form-horizontal' action='?do=Update' method='POST'>
            <input type='hidden' name='ID' value=<?php echo $offerid ?> >
                <!--start username field-->
                 <!--start Name field-->
                 <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>اسم السلعه</label>
                        <div class='col-sm-10'>
                        <select  name='name'>
                                <option value='0'>...</option>
                                <?php
                                  $stmt=$db->prepare('SELECT * FROM items where offer=1');
                                  $stmt->execute();
                                  $cats=$stmt->fetchAll();
                                  
                                  foreach($cats as $cat){
                                    echo "<option value='".$cat['item_id']."'";
                                    if($row["Name"] == $cat['Name']){ echo 'selected';} 
                                    echo ">".$cat['Name']."</option>";
                                  }
                                 
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--start Name field-->
                    
                    <!--start Price field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>السعر بعد الخصم</label>
                        <div class='col-sm-10'>
                        <input type='text' name='myprice' class='form-control'  required='required' placeholder='ادخل السعر ' autocomplete='off' value='<?php echo $row["offer_price"]; ?>'>
                        </div>
                    </div>
                    <!--start Price field-->
                    <!--start Category field-->
                  <div class='form-group form-group-lg' >
                    <label class='col-sm-2 control-label'>الصنف</label>
                    <div class='col-sm-10'>
                        <select name='category'>
                            <option value='0'>...</option>
                            <?php
                              $stmt=$db->prepare('SELECT * FROM categories');
                              $stmt->execute();
                              $cats=$stmt->fetchAll();
                              foreach($cats as $cat){
                                echo "<option value='".$cat['ID']."'";
                                if($row["cat_id"] == $cat['ID']){ echo 'selected';} 
                                echo ">".$cat['Name']."</option>";
                              }
                             
                            ?>
                        </select>
                    </div>
                </div>
                <!--start Category field-->
                
                
                <!--start submit field-->
                <div class='form-group form-group-lg' >
                    <div class='col-sm-12'>
                    <input type='submit' value='تعديل' class='btn btn-primary btn-md'>
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

        }elseif($do == 'Update'){
            echo '<h1 class="text-center">تحديث العرض</h1>';
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
              // get data from post request
              $id           =$_POST['ID'];
              $id_offer         =$_POST['name'];
              $stmt=$db->prepare("SELECT * FROM items where item_id=$id_offer");
                                $stmt->execute();
                                $cats=$stmt->fetch();
             
              $name         =$cats['Name'];
              $my_price     =$_POST['myprice'];
              
              $cat          =$_POST['category'];
              
             
                      
              //validate the form
              echo '<div class="container">';
              $formErrors=array();

             
              if(empty($my_price)){
                  $formErrors[]='my price can\'t be<strong> empty</strong>';
              }  

              
              if($id_offer == 0){
                  $formErrors[]='you must select <strong>name</strong>';
              }

              if($cat == 0){
                  $formErrors[]='you must select <strong>category</strong>';
              }
                  
              foreach($formErrors as $error){
                      echo '<div class="alert alert-danger">'.$error.'</div>' ;
              }

              //update the database with this info
              if(empty($formErrors)){
                  
                  $stmt=$db->prepare("UPDATE 
                                         offers 
                                      SET 
                                         offer_name = ? ,
                                         
                                         offer_price = ?,
                                         
                                         cat_id=?

                                      WHERE 
                                         offer_id = ?");
                
                  $stmt->execute(array($name,$my_price,$cat,$id));
                  
                  $theMsg= '<div class="alert alert-success">'. $stmt->rowCount() . 'عرض تم تحديثها</div>';
                  redirectHome($theMsg,'back');
              }
            }else{
              $theMsg='<div class="alert alert-danger">' .'sorry you can"/t browse this page directly</div>' ;
                 redirectHome($theMsg);
            }
            echo '</div>';

        }elseif($do == 'Delete'){
            echo '<h1 class="text-center">حذف عرض</h1>';
            echo '<div class="container">';
                $offerid=isset($_GET['offerid'])&is_numeric($_GET['offerid'])?intval($_GET['offerid']):0;
                
                $chek=checkItem('offer_id','offers',$offerid);
                
                if($chek > 0){
                  $stmt = $db->prepare('DELETE FROM offers WHERE offer_id = :zid ');
                  $stmt->bindParam(':zid',$offerid);
                  $stmt->execute();
                   
                  $theMsg='<div class="alert alert-success text-center">'. $stmt->rowCount() . 'عرض تم حذفها.</div>';
                  redirectHome($theMsg,'back');

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
    ob_end_flush();
?>    