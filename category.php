<?php
include "ini.php";
?>
<div class='container'>
<h1 class='text-center'>
<?php

echo 'Welcom' ."    ".$_GET['cat_name']
?>
</h1>

<?php
$row=getitem('Cat_id',$_GET['cat_id']);
?>
<div class='row'>
<?php
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
?>
</div>
<?php
include $tbl . "footer.php";
?>