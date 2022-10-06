<?php

  /**
   * manage member bage
   * edit|add|delete members
   */
  ob_start();
  session_start(); 
  $pagetitle='المبيعات';
  if(isset($_SESSION['myuser'])){
        include 'init.php';
        $do=isset($_GET['do'])? $_GET['do']:'manage';

        if($do == 'manage'){ 
              
            $stmt = $db->prepare("SELECT orders.* ,
                                     users.username
                                  FROM 
                                       orders 
                                  INNER JOIN
                                         users
                                  ON
                                        users.user_id=orders.customer_id
                         ");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
            ?>

            <h1 class='text-center'>قائمة المبيعات</h1>
            <div class='container'>
            <div class='table-responsive'>
                <table class='main-table text-center table table-bordered '>
                <tr>
                    <td>Control</td>
                    <td>اسم العميل</td>
                    <td>حالة الدفع</td>
                    <td>تاريخ العمليه</td>
                    <td>عرض الطلب</td>
                    <td>سعر الطلب</td>
                    <td>#ID</td>
                </tr>
                <?php 
                    foreach($rows as $Row){
                    echo '<tr>';
                    echo '<td>
                                <a href="members.php?do=edit&userid='.$Row['order_id'].'" class="btn btn-success"><i class="fas fa-edit"></i>تعديل</a>
                                <a href="members.php?do=Delete&userid='.$Row['order_id'].'" class="confirm btn btn-danger"><i class="fas fa-trash-alt"></i> حذف</a>'.
                            '</td>';
                        echo '<td>'.$Row['username'].'</td>';
                        echo '<td>';
                          if($Row['not_paid']==0){echo  'تم الدفع';}else{echo  'لم يتم الدفع';}
                        echo '</td>';
                        echo '<td>'.$Row['order_date'].'</td>';
                        echo '<td>';?>
                           
                                          <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $Row['order_id']; ?>">
                        <i class='fa fa-eye'></i> عرض
                      </button>
                      
                      <!-- Modal -->
                      <div class="modal fade" id="<?php echo $Row['order_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    
                                   
                                  $arr=explode('-',$Row['order_items']);
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
                                
                               echo '<h2>السعر الكلي:<span class="text-center">'.$Row['total_price'].'</h2>';
                               ?>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                             
                            </div>
                          </div>
                        </div>
                      </div>
                        <?php echo '</td>';
                        echo '<td>'.$Row['total_price'].'</td>';
                        echo '<td>'.$Row['order_id'].'</td>';
                        
                    echo '</tr>';
                    }
                    
                ?>
                
                
                </table>
            </div>
            
            <?php }else{
                            echo '<div class="container">';
                            $theMsg='<div class="alert alert-info text-center">.لا يوجد مبيعات حاليا </div>';
                            redirectHome($theMsg,'back');
                            echo '</div>';
                        } ?>
                
            </div>
            <?php 
            
        }elseif($do == 'Delete'){
            echo '<h1 class="text-center">حذف الطلب</h1>';
            echo '<div class="container">';
                $order_id=isset($_GET['order_id'])&is_numeric($_GET['order_id'])?intval($_GET['order_id']):0;
                
                $chek=checkItem('order_id','orders',$order_id);
                
                if($chek > 0){
                  $stmt = $db->prepare('DELETE FROM orders WHERE order_id = :zid ');
                  $stmt->bindParam(':zid',$order_id);
                  $stmt->execute();
                   
                  $theMsg='<div class="alert alert-success text-center">'. $stmt->rowCount() . 'طلب تم حذفه.</div>';
                  redirectHome($theMsg,'back');

                }else{
                  $theMsg= '<div class="alert alert-danger">' ."no order to deleted</div>" ;
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


