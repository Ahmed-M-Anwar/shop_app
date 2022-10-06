<?php
  session_start(); 
  $pagetitle='Profile';
  include 'init.php';
  if(isset($_SESSION['user'])){
      $getuser=$db->prepare('SELECT * FROM users WHERE username=?');
      $getuser->execute(array($_SESSION['user']));
      $info =$getuser->fetch();
  }
  ?>
  <h1 class='text-center'>My Profile</h1>
 <div class='information block'>
     <div class='container'>
       <div class='panel panel-primary'>
           <div class='panel-heading'>My Information</div>
           <div class='panel-body'>
            <ul class='list-unstyled'>
              <li>
                <i class='fa fa-unlock-alt fa-fw'></i>
             <span>Name</span>:<?php echo $info['username'] ?> 
              </li>
             <li>
             <i class='far fa-envelope fa-fw'></i>
             <span>Phone</span>:<?php echo $info['phone'] ?> 
             </li>
             
            </ul>
           </div>
       </div>
     </div>
</div>



<div class='my-comments block'>
     <div class='container'>
       <div class='panel panel-primary'>
           <div class='panel-heading'>طلباتي</div>
           <div class='panel-body'>
             <?php
             $stmt=$db->prepare("SELECT * FROM orders WHERE customer_id = ? order by order_id desc");
             $stmt->execute(array($info['user_id']));
             $orders=$stmt->fetchAll();
             if(! empty($orders)){
                foreach($orders as $order){
                   

                    ?>
                  
                                          <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $order['order_id']; ?>">
                        <i class='fa fa-eye'></i> view order
                      </button>
                      
                      <!-- Modal -->
                      <div class="modal fade" id="<?php echo $order['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">My order</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              
                              <?php
                                    
                                   
                                  $arr=explode('-',$order['order_items']);
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
                                $count_2 = count($items);
                                for($i = 0 ;$i <$count_2 ;$i++){
                                  echo $items[$i].' '.$num_item[$i].'<br>';   
                                }
                               echo '<h2>Total Price:<span class="text-center">'.$order['total_price'].'</h2>';
                               ?>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                             
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                    <?Php
                    
                }
             }else{
                 echo 'No order to show.';
             }
             ?>
           </div>
       </div>
     </div>
</div>

<?php
  include $tpl . "footer.php"; 
 
?>