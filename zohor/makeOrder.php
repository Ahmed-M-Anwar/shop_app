<?php
  session_start(); 
  $pagetitle='Make Order';
  include 'init.php';
  if(isset($_SESSION['user'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(isset($_POST['paid'])){
              $paid=$_POST['paid'];
              $content=$_POST['content'];
              $cust_id=$_SESSION['userId'];
              $total=$_POST['total'];
              $arr=explode('-',$content);
              array_pop($arr);
              $count = count($arr);
              $items=array();
              $num_item=array();
              for($i = 0 ;$i <$count ;$i+=2){
                 $num_item[]=$arr[$i];
              }
              for($i = 1 ;$i <$count ;$i+=2){
                $items[]=$arr[$i];
             }
             $count_item = count($items);
             $formErrors = array();
             for($i = 0 ;$i <$count_item ;$i++){
                    
                    $stmt=$db->prepare('SELECT * FROM items WHERE Name=?');
                    $stmt->execute(array($items[$i]));
                    $row=$stmt->fetch();
                    //echo $row['Name'] .' '.$row['num_item'].' '.$row['customer_price'].'<br>';
                    $new_num_item=$row['num_item']-$num_item[$i];
                    $formErrors = array();
                    if($new_num_item < 0){
                      $formErrors[] ='عفوا لا يوجد كميه كافيه من ال '.$row['Name'].' '.'لا يوجد الا '.$row['num_item'].'قطعه';
                    }
             }

             if(empty($formErrors)){
              for($i = 0 ;$i <$count_item ;$i++){
                    
                $stmt=$db->prepare('SELECT * FROM items WHERE Name=?');
                $stmt->execute(array($items[$i]));
                $row=$stmt->fetch();
                //echo $row['Name'] .' '.$row['num_item'].' '.$row['customer_price'].'<br>';
                $new_num_item=$row['num_item']-$num_item[$i];
                $formErrors = array();
                if($new_num_item == 0){
                  $stmt = $db->prepare('DELETE FROM items WHERE Name = ? ');
                  $stmt->execute(array($items[$i]));
                  $stmt->execute();
                }else{
                  $stmt=$db->prepare("UPDATE 
                                         items 
                                      SET 
                                          num_item=?

                                          WHERE 
                                          Name = ?");

                                          $stmt->execute(array($new_num_item,$items[$i]));
                }
              }
              $stmt = $db->prepare("INSERT INTO 
                                                orders(total_price,order_items,order_date,not_paid,customer_id)
                                                VALUES(:ztotal,:zorder_items,now(),0,:zmember)
                                            ");
                        $stmt->execute(array('ztotal'=>$total,
                                             'zorder_items'=>$content,
                                             'zmember'=>$cust_id

                                            ));
                            $successmsg = 'تمت العمليه بنجاح';
                            header('Location: index.php');
             }
            

       }else{
         
        $paid=$_POST['paid'];
        $content=$_POST['content'];
        $cust_id=$_SESSION['userId'];
        $total=$_POST['total'];
        $arr=explode('-',$content);
        array_pop($arr);
        $count = count($arr);
        $items=array();
        $num_item=array();
        for($i = 0 ;$i <$count ;$i+=2){
           $num_item[]=$arr[$i];
        }
        for($i = 1 ;$i <$count ;$i+=2){
          $items[]=$arr[$i];
       }
       $count_item = count($items);
       $formErrors = array();
       for($i = 0 ;$i <$count_item ;$i++){
              
              $stmt=$db->prepare('SELECT * FROM items WHERE Name=?');
              $stmt->execute(array($items[$i]));
              $row=$stmt->fetch();
              //echo $row['Name'] .' '.$row['num_item'].' '.$row['customer_price'].'<br>';
              $new_num_item=$row['num_item']-$num_item[$i];
              $formErrors = array();
              if($new_num_item < 0){
                $formErrors[] ='عفوا لا يوجد كميه كافيه من ال '.$row['Name'].' '.'لا يوجد الا '.$row['num_item'].'قطعه';
              }
       }

       if(empty($formErrors)){
        for($i = 0 ;$i <$count_item ;$i++){
              
          $stmt=$db->prepare('SELECT * FROM items WHERE Name=?');
          $stmt->execute(array($items[$i]));
          $row=$stmt->fetch();
          //echo $row['Name'] .' '.$row['num_item'].' '.$row['customer_price'].'<br>';
          $new_num_item=$row['num_item']-$num_item[$i];
          $formErrors = array();
          if($new_num_item == 0){
            $stmt = $db->prepare('DELETE FROM items WHERE Name = ? ');
            $stmt->execute(array($items[$i]));
            $stmt->execute();
          }else{
            $stmt=$db->prepare("UPDATE 
                                   items 
                                SET 
                                    num_item=?

                                    WHERE 
                                    Name = ?");

                                    $stmt->execute(array($new_num_item,$items[$i]));
          }
        }
        $stmt = $db->prepare("INSERT INTO 
                                          orders(total_price,order_items,order_date,not_paid,customer_id)
                                          VALUES(:ztotal,:zorder_items,now(),1,:zmember)
                                      ");
                  $stmt->execute(array('ztotal'=>$total,
                                       'zorder_items'=>$content,
                                       'zmember'=>$cust_id

                                      ));
                      $successmsg = 'تمت العمليه بنجاح';
                      header('Location: index.php');
       }
      

       }
  }
?>
  <div class='container'>
    <!-----------الاصناف--------->
      <div class='row'>
      <?php
                foreach(getcat() as $cat){
      ?>
         <div class='col-md-1 text-center cat_show' >
            <div ><?php echo $cat['Name'] ;?></div>
         </div>
      <?php            
                }
      ?>
      </div>
      <!-----------الاصناف--------->
      <div class='row'>
        <div class='col-md-8'>
          <div class='row'>
              <?php foreach(getItem() as $item){ ?>
                
              <div class='col-md-4 <?php echo $item['cat_name'] ?> item_sel' style='display:none'>
                <div class="thumbnail item-box">
                 <?php if($item['offer'] == 0){?>
                  <span class="price-tag"><?php echo $item['customer_price'];?></span>
                  <img class="img-responsive img_control" src="admin/uploade/image/<?php echo $item['image']; ?>" alt=""/>
                  <div class="caption">
                       <h3><a href="items.php?itemid='.$item['item_id'].'"><?php echo $item['Name'];?></a></h3>
                       <p><?php echo $item['Description'];?></p>
                       <div class="date"><?php echo $item['Date'];?></div>
                  </div>
                 <?php }else{
                           $stmt=$db->prepare('SELECT offer_price FROM offers WHERE offer_name=? ');
                           $stmt->execute(array($item['Name']));
                           $row=$stmt->fetch(); ?>
                           <span class="price-tag"><?php echo $row['offer_price'];?></span>
                           <span class="price-tag-2"><?php echo $item['customer_price'].' بدلا من ';?></span>
                            <img class="img-responsive img_control" src="admin/uploade/image/<?php echo $item['image']; ?>" alt=""/>
                            <div class="caption">
                                <h3><a href="items.php?itemid='.$item['item_id'].'"><?php echo $item['Name'];?></a></h3>
                                <p><?php echo $item['Description'];?></p>
                                <div class="date"><?php echo $item['Date'];?></div>
                            </div>

                            <?php } ?>
                </div>
                  
              </div>
              <?php } ?>
          </div>
        </div>
        <div class='col-md-4'>
        <div class="card">
              <div class="card_title">Your Card</div>
              <div class="card_nocontent">
                <span class="glyphicon glyphicon-shopping-cart"></span>
                <br>no item in your card
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
              
              <div class="card_content"  style="display: none">
             <h3 style="padding-BOTTOM: 8px;margin-top: 0;">zohor-eltawhed</h3>
                  
                  <div class='select_item' style=" text-align: left;background-color: #EEEEEE; margin:10px; padding:10px; border-top: 2px solid #F30B74;border-bottom: 2px solid #F30B74">
                    
                  </div >
                  
                  <hr>
                  <p style="font-weight: 600; font-size: 20px; text-align: left; margin-left: 10px;"> Total : <span class="total"> </span> EGT</p>
                  <hr>
                  <form method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                  <input type='hidden' name='total' class='input_total'>
                  <input type='hidden' name='content' class='input_content'>
                  <input type='submit' name='paid' value='تم الدفع' class='btn btn-success paid'>
                  <input type='submit' name='not_paid' value='خرج' class='btn btn-danger not_paid'>
                  </form>
                  
              </div>
              </div>
        </div>
      </div>
  </div>

<?php
}else{
    header('Location: index.php');
}
  include $tpl . "footer.php"; 
 
?>