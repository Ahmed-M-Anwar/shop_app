<?php
  session_start(); 
  $pagetitle='Homepage';
  include 'init.php';
  ?>
  <div class='container'>
    <h1 class='text-center'> All Items</h1>
    <div class='row'>
    <?php foreach(getItem() as $item){ ?>
                
                <div class='col-md-3 col-sm-6 <?php echo $item['cat_name'] ?> item_sel' >
                  <div class="thumbnail item-box">
                   <?php if($item['offer'] == 0){?>
                    <span class="price-tag"><?php echo $item['customer_price'];?></span>
                    <img class="img-responsive img_control" src="admin/uploade/image/<?php echo $item['image']; ?>" alt=""/>
                    <div class="caption">
                         <h3><a href="items.php?itemid='<?php echo $item['item_id'];?>'"><?php echo $item['Name'];?></a></h3>
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
                                  <h3><a href="items.php?itemid='<?php echo $item['item_id'];?>'"><?php echo $item['Name'];?></a></h3>
                                  <p><?php echo $item['Description'];?></p>
                                  <div class="date"><?php echo $item['Date'];?></div>
                              </div>
  
                              <?php } ?>
                  </div>
                    
                </div>
                <?php } ?>
    </div>
  </div>
  
  <?php
  include $tpl . "footer.php"; 
 
?>