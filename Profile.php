<?php
session_start();
$title_page ="My Profile";

include "ini.php";


if (isset($_SESSION['User'])){
  $stmt=$db->prepare('SELECT * FROM users WHERE Username= ?');
  $stmt->execute(array($sesionUser));
  $data=$stmt->fetch();
  $count=$stmt->rowCount();
          
?>
<h1 class="text-center">My Profile</h1>
 <div class='information block'>
    <div class='container'>
    <div class="card">
  <div class="card-header ">
    <h4>My Information</h4>
    
  </div>
  <div class="card-body ">
   <ul class="listt">
  <li><i class='fa fa-unlock-alt fa-fw'> </i><span>Name</span>: <?php echo $data['Username']?></li>
  <li><i class="fa fa-envelope fa-fw"></i><span>Email</span>: <?php echo $data['Email']?></li>
  <li><i class='fa fa-user fa-fw'> </i><span>FullName</span>: <?php echo $data['FullName']?></li>
  <li><i class='fa fa-calendar fa-fw'> </i><span>Date</span>: <?php echo $data['Date']?></li>
  <li><i class="fa fa-heart fa-fw"></i><span>Fav Catigory</span>: <?php echo $data['Date']?></li>

</ul>
    
   </div>
   <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
  
</div>
    </div>
 </div>

 <div class='My_ads block'>
    <div class='container'>
    <div class="card">
  <div class="card-header ">
    <h4>My Ads</h4>
  </div>
  <div class="card-body">
        <?php
      $row=getitem('Member_ID',$data['UserID']);
      ?>
      <div class='row'>
      <?php
      if (!empty($row)){
      foreach($row as $re){

          ?>
      <div class="col-sm-6 col-md-3">
      <div class="thumbnail card h-100 shadow-sm"> 
      <img src="https://www.freepnglogos.com/uploads/notebook-png/download-laptop-notebook-png-image-png-image-pngimg-2.png" class="card-img-top" alt="..."> <div class="card-body"> 
      <div class="clearfix mb-3"> 
      <span class="float-start badge rounded-pill bg-primary">
      <?php echo $re['Name'] ?></span> <span class="float-end price-hp"><?php echo $re['Price'] ?>&euro;</span> </div> <h5 class="card-title"><?php echo $re['Description'] ?></h5> <div class="text-center my-4"> <a href="#" class="btn btn-warning">Check offer</a> </div> </div> </div> </div>

          <?php
      }
    }
    else{
      echo "NOT found Ads immdiatly";
    }
      ?>
      </div>
  
    
  </div>
  <a href="new_ads.php" class="btn btn-primary">Add new Ads</a>
</div>
    </div>
 </div>

 <div class='my_comments block'>
    <div class='container'>
    <div class="card">
  <div class="card-header ">
    <h4>Latest Comments</h4>
  </div>
  <div class="card-body">
    <?php
    
    $stmt=$db->prepare("SELECT * FROM comments WHERE user_id=?");
		$stmt->execute(array($data['UserID']));
		$row=$stmt->fetchAll();
    if(! empty($row)){
    foreach($row as $ri){
      echo $ri['cid'];
    
      echo $ri['comment'];
    }
  }
  else{
    echo "NO Found itemes";
  }
    ?>
    
  </div>
  <a href="#" class="btn btn-primary">Go somewhere</a>
</div>
    </div>
 </div>
 
<?php

}
else{
 header('Location:login.php') ;
}
include $tbl . "footer.php";
?>