<?php

  /**
   * manage items bage
   * edit|add|delete members
   */
  ob_start();
  session_start(); 
  $pagetitle='Items';
  if(isset($_SESSION['myuser'])){
        include 'init.php';
        $do=isset($_GET['do'])? $_GET['do']:'manage';
        
        if($do == 'manage'){ 
            echo '<h1 class="text-center">ادارة السلع</h1>';
            $stmt=$db->prepare('SELECT * FROM categories');
            echo '<div class="container">';
            $stmt->execute();
            $cats=$stmt->fetchAll();
            if(!empty($cats)){
            foreach($cats as $cat){
                $cat_v=$cat['ID'];
                $stmt = $db->prepare("SELECT items.* , 
                                         categories.Name AS cat_name
                                      FROM 
                                         items
                                      INNER JOIN 
                                          categories
                                      ON
                                          categories.ID=items.cat_id
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
                   <td>تخفيضات</td>
                   <td>تاريخ التسجيل</td>
                   <td>السعر للمستهلك</td>
                   <td>سعر الشراء</td>
                   <td>العدد</td>
                   <td>اسم السلعه</td>
                   
                </tr>
                <?php 
                   foreach($rows as $Row){
                    echo '<tr>';
                        echo '<td>
                        <a href="items.php?do=Edit&itemid='.$Row['item_id'].'" class="btn btn-success"><i class="fas fa-edit"></i>تعديل</a>
                        <a href="items.php?do=Delete&itemid='.$Row['item_id'].'" class="confirm btn btn-danger"><i class="fas fa-trash-alt"></i> حذف</a>
                        </td>';
                       echo '<td>'.$Row['offer'].'</td>';
                       echo '<td>'.$Row['Date'].'</td>';
                       echo '<td>'.$Row['customer_price'].'</td>';
                       echo '<td>'.$Row['my_price'].'</td>';
                       echo '<td>'.$Row['num_item'].'</td>';
                       echo '<td>'.$Row['Name'].'</td>';
                      
                    echo '</tr>';
                   }
                   
                ?>
                 </table>
                 
                </div>
                  
                <?php }else{?>
                         <div class='container'>
                         <h2 ><?php echo $cat['Name'] ;?> -</h2>
                         <div class="alert alert-info text-center">عفوا,لا  يوجد سلع بهذا القسم</div>
                
                     <?php }
                }?>
                <a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة سلعه جديده</a>
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
                <form class='form-horizontal' action='?do=Insert' method='POST' enctype='multipart/form-data'>
                
                    <!--start Name field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>اسم السلعه</label>
                        <div class='col-sm-10'>
                        <input type='text' name='name' class='form-control'  required='required' autocomplete='off' placeholder='ادخل اسم السلعه'>
                        </div>
                    </div>
                    <!--start Name field-->
                    <!--start Description field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>الوصف</label>
                        <div class='col-sm-10'>
                        <input type='text' name='description' class='form-control'  required='required' autocomplete='off' placeholder='ادخل الوصف'>
                        </div>
                    </div>
                    <!--start Description field-->
                    <!--start num-item field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>عدد القطع</label>
                        <div class='col-sm-10'>
                        <input type='text' name='num_item' class='form-control'  required='required' placeholder='ادخل عدد القطع' autocomplete='off'>
                        </div>
                    </div>
                    <!--start num-item field-->
                    <!--start Price field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>السعر عند الشراء</label>
                        <div class='col-sm-10'>
                        <input type='text' name='myprice' class='form-control'  required='required' placeholder='ادخل سعر الشراء' autocomplete='off'>
                        </div>
                    </div>
                    <!--start Price field-->
                    <!--start price field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>السعر للمستهلك</label>
                        <div class='col-sm-10'>
                        <input type='text' name='price' class='form-control'  required='required' placeholder='ادخل سعر البيع' autocomplete='off'>
                        </div>
                    </div>
                    <!--start price field-->
                    <!--start image field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>صورة السلعه</label>
                        <div class='col-sm-10'>
                        <input type='file' name='image' class='form-control'  required='required' >
                        </div>
                    </div>
                    <!--start image field-->
                   <!--start offer field-->
                   <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>تخفيضات</label>
                        <div class='col-sm-10'>
                            <select name='offer'>
                                <option value=''>لا يوجد تخفيض</option>
                                <option value='1'>متاح تخفيض</option>
                            </select>
                        </div>
                    </div>
                    <!--start offer field-->
                    
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
                        <input type='submit' value='Add Item' class='btn btn-primary btn-md'>
                        </div>
                    </div>
                    <!--start submit field-->


                </form>
            </div>
            <?php
        }elseif($do == 'Insert'){
                //insert page
                
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    echo '<h1 class="text-center">حفظ السلعه</h1>';

                    //upload vars
                    $imageName=$_FILES['image']['name'];
                    $imageSize=$_FILES['image']['size'];
                    $imageTmp=$_FILES['image']['tmp_name'];
                    $imageType=$_FILES['image']['type'];
                   $x=explode('.',$imageName);
                   $y=end($x);
                    //image extention
                    $imageAllowedExtension =array('jpeg','jpg','gif','png');
                    $imageExtension=strtolower($y);
                    // get data from post request
                    
                    $name         =$_POST['name'];
                    $desc         =$_POST['description'];
                    $num_item     =$_POST['num_item'];
                    $my_price     =$_POST['myprice'];
                    $price        =$_POST['price'];
                    $offer        =$_POST['offer'];
                    $cat          =$_POST['category'];
                      
                    
                   
                            
                    //validate the form
                    echo '<div class="container">';
                    $formErrors=array();

                    if(empty($name)){
                        $formErrors[]='Name can\'t be <strong>empty</strong>';
                    }

                    if(empty($num_item )){
                        $formErrors[]='number of items can\'t be <strong>empty</strong>';
                    }
 
                    if(empty($my_price)){
                        $formErrors[]='my price can\'t be<strong> empty</strong>';
                    }  

                    if(empty($price)){
                        $formErrors[]='Price can\'t be <strong>empty</strong>';
                    }
                    
                    if($cat == 0){
                        $formErrors[]='you must select <strong>category</strong>';
                    }
                    if(! empty($imageName) && ! in_array($imageExtension,$imageAllowedExtension)){
                        $formErrors[]='this extension is <strong>not allowed</strong>';
                    }
                    if(empty($imageName)){
                        $formErrors[]='image filed is <strong>required</strong>';
                    }

                    
                        
                    foreach($formErrors as $error){
                            echo '<div class="alert alert-danger">'.$error.'</div>' ;
                    }

                    //update the database with this info
                    if(empty($formErrors)){

                        $image=rand(0,10000000000000).'_'.$imageName;
                        $check=checkItem('image','items',$image);
                        if($check >0){
                            $image=rand(0,10000000000000).'_'.rand(0,10000000000000).$imageName; 
                        }
                        move_uploaded_file($imageTmp,'uploade\image\\'.$image);
                        
                        $stmt = $db->prepare("INSERT INTO 
                                                items(Name,Description,num_item,my_price,customer_price,Date,offer,image,cat_id)
                                                VALUES(:zname,:zdesc,:znum_item,:zmy_price,:zprice,now(),:zoffer,:zimage,:zcat)
                                            ");
                        $stmt->execute(array('zname'=>$name,
                                             'zdesc'=>$desc,
                                             'znum_item'=>$num_item,
                                             'zmy_price'=>$my_price,
                                             'zprice'=>$price,
                                             'zoffer'=>$offer,
                                             'zimage'=>$image,
                                             'zcat'=>$cat

                                            ));

                        $theMsg= '<div class="alert alert-success">'. $stmt->rowCount() . ' Record Inserted.</div>';
                        redirectHome($theMsg,'back',0.1);
                        }
                    
                }else{
                    $theMsg='<div class="alert alert-danger">sorry you can"\t browse this page directly</div>' ;
                    redirectHome($theMsg);
                }

        }elseif($do == 'Edit'){
                $itemid=isset($_GET['itemid'])&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
                $stmt=$db->prepare("SELECT * from items where item_id=?");
                $stmt->execute(array($itemid));
                $row=$stmt->fetch();
                $count = $stmt->rowCount();
                if($stmt->rowCount() > 0){
                ?>

            <h1 class='text-center'>تعديل السلعه</h1>
            <div class='container'>
                <form class='form-horizontal' action='?do=Update' method='POST'>
                <input type='hidden' name='ID' value=<?php echo $itemid ?> >
                    <!--start username field-->
                    
                    <!--start Name field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>اسم السلعه</label>
                        <div class='col-sm-10'>
                        <input type='text' name='name' class='form-control'  required='required' placeholder='ادخل اسم السلعه' value='<?php echo $row["Name"]; ?>'>
                        </div>
                    </div>
                    <!--start Name field-->
                     <!--start Description field-->
                     <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>الوصف</label>
                        <div class='col-sm-10'>
                        <input type='text' name='description' class='form-control'   placeholder='ادخل الوصف' value='<?php echo $row["Description"]; ?>'>
                        </div>
                    </div>
                    <!--start Description field-->
                    <!--start num-item field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>عدد القطع</label>
                        <div class='col-sm-10'>
                        <input type='text' name='num_item' class='form-control'  required='required' placeholder='ادخل عدد القطع' value='<?php echo $row["num_item"]; ?>'>
                        </div>
                    </div>
                    <!--start num-item field-->
                    <!--start Price field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>السعر عند الشراء</label>
                        <div class='col-sm-10'>
                        <input type='text' name='myprice' class='form-control'  required='required' placeholder='ادخل سعر الشراء' value='<?php echo $row["my_price"]; ?>'>
                        </div>
                    </div>
                    <!--start Price field-->
                    <!--start price field-->
                    <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>السعر للمستهلك</label>
                        <div class='col-sm-10'>
                        <input type='text' name='price' class='form-control'  required='required' placeholder='ادخل سعر البيع'value='<?php echo $row["customer_price"]; ?>' >
                        </div>
                    </div>
                    <!--start price field-->
                   <!--start offer field-->
                   <div class='form-group form-group-lg' >
                        <label class='col-sm-2 control-label'>تخفيضات</label>
                        <div class='col-sm-10'>
                            <select name='offer'>
                                <option value='' <?php if($row["offer"] == 0){ echo 'selected';} ?>>لا يوجد تخفيض</option>
                                <option value='1' <?php if($row["offer"] == 1){ echo 'selected';} ?>>متاح تخفيض</option>
                            </select>
                        </div>
                    </div>
                    <!--start offer field-->
                   
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
            echo '<h1 class="text-center">تحديث السلع</h1>';
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get data from post request
                $id           =$_POST['ID'];
                $name         =$_POST['name'];
                $desc         =$_POST['description'];
                $num_item     =$_POST['num_item'];
                $my_price     =$_POST['myprice'];
                $price        =$_POST['price'];
                $offer        =$_POST['offer'];
                $cat          =$_POST['category'];
                  
                
               
                        
                //validate the form
                echo '<div class="container">';
                $formErrors=array();

                if(empty($name)){
                    $formErrors[]='Name can\'t be <strong>empty</strong>';
                }

                if(empty($num_item )){
                    $formErrors[]='number of items can\'t be <strong>empty</strong>';
                }

                if(empty($my_price)){
                    $formErrors[]='my price can\'t be<strong> empty</strong>';
                }  

                if(empty($price)){
                    $formErrors[]='Price can\'t be <strong>empty</strong>';
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
                                           items 
                                        SET 
                                           Name = ? ,
                                           Description = ?,
                                           num_item=?,
                                           my_price = ?,
                                           customer_price=?,
                                           Date=now(),
                                           offer = ?,
                                           cat_id=?

                                        WHERE 
                                           item_id = ?");
                  
                    $stmt->execute(array($name,$desc,$num_item,$my_price,$price,$offer,$cat,$id));
                    
                    $theMsg= '<div class="alert alert-success">'. $stmt->rowCount() . 'سلعه تم تحديثها</div>';
                    redirectHome($theMsg,'back',0.1);
                }
              }else{
                $theMsg='<div class="alert alert-danger">' .'sorry you can"/t browse this page directly</div>' ;
                   redirectHome($theMsg);
              }
              echo '</div>';

        }elseif($do == 'Delete'){
            echo '<h1 class="text-center">حذف السلع</h1>';
              echo '<div class="container">';
                  $itemid=isset($_GET['itemid'])&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
                  
                  $chek=checkItem('item_id','Items',$itemid);
                  
                  if($chek > 0){
                    $stmt = $db->prepare('DELETE FROM items WHERE item_id = :zid ');
                    $stmt->bindParam(':zid',$itemid);
                    $stmt->execute();
                     
                    $theMsg='<div class="alert alert-success text-center">'. $stmt->rowCount() . 'سلعه تم حذفها.</div>';
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
    ob_end_flush();
?>    