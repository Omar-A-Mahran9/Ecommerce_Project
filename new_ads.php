<?php
session_start();
$title_page ="ADD New Item";

include "ini.php";


if (isset($_SESSION['User'])){
  $stmt=$db->prepare('SELECT * FROM users WHERE Username= ?');
  $stmt->execute(array($sesionUser));
  $data=$stmt->fetch();
  $count=$stmt->rowCount();
          
?>
<h1 class="text-center"><?php echo $title_page?></h1>
 <div class='information block'>
    <div class='container'>
    <div class="card">
  <div class="card-header ">
    <h4><?php echo $title_page?></h4>
    
  </div>
  <div class="card-body ">
   <div class="row">
    <div class="col-md-7">
     
        form
    </div> 
        
        <div class="col-md-5">
<div class="thumbnail card h-100 shadow-sm"> 
<img src="https://www.freepnglogos.com/uploads/notebook-png/download-laptop-notebook-png-image-png-image-pngimg-2.png" class="card-img-top" alt="..."> <div class="card-body"> 
<div class="clearfix mb-3"> 
<span class="float-start badge rounded-pill bg-primary">
Name</span> <span class="float-end price-hp"> price &euro;</span> </div> <h5 class="card-title"> Description</h5> <div class="text-center my-4"> <a href="#" class="btn btn-warning">Check offer</a> </div> </div> </div> </div>

       

</div>
   </div>
   <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
  
</div>
    </div>
 </div>
<?php
}





include $tbl . "footer.php";
?>