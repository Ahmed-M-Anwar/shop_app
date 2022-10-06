<?php
  session_start(); 
  $pagetitle='Dashboard';
  if(isset($_SESSION['myuser'])){
    include 'init.php';
    /*$latestusers =4;
    $theLatestusers=getLatest('*','users','user_id',$latestusers);

    $latestitems =4;
    $theLatestitems=getLatest('*','items','item_id',$latestitems);*/
    ?>

    <div class='home-status'>
      <div class='container text-center'>
        <h1>لوحة التحكم</h1>
        <div class='row'>

         <div class='col-md-3'>
           <div class='stat st-members'>
           <i class='size_i fa fa-users'></i>
              <div class='info'>
              عملاء
              <span><a href='members.php'><?php  if(countItems('user_id','users')!=null){echo countItems('user_id','users');}else{echo 0;} ?></a></span>
              </div>
           </div>
         </div>
         <div class='col-md-3'>
           <div class='stat st-pending'>
           <i class='size_i fa fa-tags'></i>
              <div class='info'>
              جميع السلع
              <span><a href='items.php'><?php if(countItems('item_id','items')!=null){echo countItems('item_id','items');}else{echo 0;}  ?></a></span>
              </div>
           </div>
         </div>
         <div class='col-md-3'>
           <div class='stat st-items'>
           <i class='size_i fa fa-exchange-alt'></i>
              <div class='info'>
              مبيعات
              <span><a href='orders.php'><?php if(countorder('total_price','orders')!=null){echo countorder('total_price','orders');}else{echo 0;}  ?></a></span>
              </div>
           </div>
         </div>
         <div class='col-md-3'>
           <div class='stat st-comments'>
           <i class='size_i fa fa-money-bill-wave'></i>
              <div class='info'>
              الايراد اليومي 
              <span><a href='#'><?php if(sum('total_price','orders')!=null){echo sum('total_price','orders');}else{echo 0;} ?></a></span>
              </div>
           </div>
         </div>
         <div class='col-md-3'>
           <div class='stat st-comments'>
           <i class='size_i fa fa-chart-line'></i>
              <div class='info'>
               تكلفة المحل
              <span><a href='#'><?php if(sumAll('my_price','items')!=null){echo sumAll('my_price','items');}else{echo 0;} ?></a></span>
              </div>
           </div>
         </div>
         <div class='col-md-3'>
           <div class='stat st-items'>
           <i class='size_i fa fa-exchange-alt'></i>
              <div class='info'>
              تكلفة المحل بعد البيع
              <span><a href='#'><?php if(sumAll('customer_price','items')!=null){echo sumAll('customer_price','items');}else{echo 0;} ?></a></span>
              </div>
           </div>
         </div>

        </div>
      </div>
    </div>


    <!--<div class='latest'>
      <div class='container'>

        <div class='row'>

          <div class='col-md-6'>
            <div class='panel panel-default'>
              <div class='panel-heading'>
                <i class='fa fa-users'></i> Latest <?php // echo $latestusers ?> Registerd Users
                <span class='toggle-info pull-right'>
                  <i class='fa fa-plus fa-lg'></i>
                </span>
              </div>
              <div class='panel-body'>
                <ul class='list-unstyled latest-users'>
                <?php
                /* if(!empty($theLatestusers)){
                foreach ($theLatestusers as $user){
                  echo '<li>';
                    echo $user['username'] ;
                    echo '<a href="members.php?do=edit&userid='.$user['user_id'].'">';
                      echo '<span class="btn btn-success pull-right">';
                        echo '<i class="fa fa-edit"></i> Edit';
                        
                      echo '</span>';
                    echo '</a>';
                    if($user['RegStatus'] == 0){
                      echo '<a href="members.php?do=Activate&userid='.$user['user_id'].'" class=" btn btn-info pull-right"><i class="fa fa-check"></i> Activate</a>';
                    }
                  echo '</li>';
                }
              }else{
                echo "There\'s No Member to show";
              }*/
                ?>
                </ul>
              </div>
            </div>
          </div>

          <div class='col-md-6'>
            <div class='panel panel-default'>
              <div class='panel-heading'>
                <i class='fa fa-tags'></i> Latest Items
                <span class='toggle-info pull-right'>
                  <i class='fa fa-plus fa-lg'></i>
                </span>
              </div>
              <div class='panel-body'>
              <ul class='list-unstyled latest-users'>
                <?php
           /* if(!empty($theLatestitems)){
                foreach ($theLatestitems as $item){
                  echo '<li>';
                    echo $item['Name'] ;
                    echo '<a href="items.php?do=Edit&itemid='.$item['item_id'].'">';
                      echo '<span class="btn btn-success pull-right">';
                        echo '<i class="fa fa-edit"></i> Edit';
                        
                      echo '</span>';
                    echo '</a>';
                    if($item['Approve'] == 0){
                      echo '<a href="items.php?do=Approve&itemid='.$item['item_id'].'" class=" btn btn-info pull-right"><i class="fa fa-check"></i> Approve</a>';
                    }
                  echo '</li>';
                }
                }else{
                  echo "There\'s No Items to show";
                }*/
                ?>
                </ul>
              </div>
            </div>
          </div>


        </div>--><!--end row-->

        <!--start latest comment-->
        <!--<div class='row'>

          <div class='col-md-6'>
            <div class='panel panel-default'>
              <div class='panel-heading'>
                <i class='far fa-comments'></i> Latest Comments
                <span class='toggle-info pull-right'>
                  <i class='fa fa-plus fa-lg'></i>
                </span>
              </div>
              <div class='panel-body'>
                <?php /*
                      $stmt = $db->prepare("SELECT 
                      comments.*  , users.username AS user
                    FROM 
                      comments
                    INNER JOIN
                      users
                    ON 
                      users.user_id=comments.user_id
                     ");
                    $stmt->execute();
                    $comments = $stmt->fetchAll();
                 if(!empty($comments)){
                    foreach($comments as $comment){
                      echo '<div class="comment-box">';
                         echo '<span class="member-n">'.$comment['user'].'</span>';
                         echo '<p class="member-c">'.$comment['comment'].'</p>';
                      echo '</div>';
                    }
                  }else{
                    echo "There/'s No comment to show";
                  }*/
                ?>
              </div>
            </div>
          </div>

          

        </div>-->

      </div>
    </div>

    <?php
    include $tpl . "footer.php";
  }else{
      header('Location: index.php');
      exit();
  }
  ?>