<?php
ob_start();
session_start();
$title_page="Item Profile";
include 'ini.php';
$itemID= isset($_GET['Itemid']) && is_numeric($_GET['Itemid']) ? intval($_GET['Itemid']):0;
$stmt=$db->prepare('SELECT 
                        items.* ,
                        categories.Name AS CatName , 
                        users.Username AS username
                        FROM 
                            items 
                        INNER JOIN
                            categories 
                            ON
                            categories.catID = items.Cat_id 
                        INNER JOIN
                            users
                            ON
                            users.UserID = items.Member_ID
                         WHERE
                            itemID = ?');


 
$stmt->execute(array($itemID));
$con=$stmt->rowCount();
$as= $stmt->fetch();

if($con==1){ 

    ?>
<div class='container'>
    <h1 class="text-center">Item Profile</h1>
    <div class='row'>
<div class='col col-md-5 center-block'>
<div class="thumbnail card h-100 shadow-sm "> 
<img src="https://www.freepnglogos.com/uploads/notebook-png/download-laptop-notebook-png-image-png-image-pngimg-2.png" class="card-img-top" alt="...">
</div>
</div>


<div class='col col-md-7 item-info'>
<ul>
<h3><?php echo $as['Name'];?></h3>
<p><?php echo $as['Description'];?></p>

<li><i class='fa fa-pen fa-fw'>   </i>
<span>added Date </span> <?php echo $as['add_Date'];?>
       
<li><i class='fa fa-bank fa-fw'>   </i>
<span>Price:      </span> <?php echo $as['Price'];?>
  
<li><i class='fa fa-building fa-fw'>   </i>
<span>Made in:    </span> <?php echo $as['counteryMade'];?>
       
<li><i class='fa fa-tags fa-fw'>   </i>
<span>Category:   </span> <a href="category.php?cat_id=<?php echo $as['Cat_id']?>"> <?php echo $as['CatName'];?></a></li>
       
<li><i class='fa fa-user fa-fw'>   </i>
<span>Add by:     </span><a href=""> <?php echo $as['username'];?></a></li>
</ul>
</div>

</div><!--end of row-->
<hr class="custom">
<div class="row">
<div class="col col-md-5">
imag

</div>
<div class="col col-md-7">

comment
</div>
</div>


</div>
<?php

}
else{
    echo "this id not found";
}



?>





<?php
include $tbl . "footer.php";
?>
