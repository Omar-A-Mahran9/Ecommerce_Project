<?php

session_start();
if(isset($_SESSION['USERNAME'])){
$title_page="Comment";
include "ini.php";
	$do=isset($_GET['do'])?$_GET['do']:'Manage';

	if($do=="Manage"){

		$stmt=$db->prepare('SELECT comments.*, users.Username AS MemberName, items.Name AS ItemName FROM comments 
			INNER JOIN users ON comments.user_id = users.UserID 
			INNER JOIN items ON comments.itme_id = items.itemID ORDER BY cid ASC');
		$stmt->execute();
		$row=$stmt->fetchAll();



?>
		<h1 class="text-center">Comments Mange</h1>
	<div class="container">
		<table class=" main_table table table-bordered">
				<tr>
					<td>#ID</td>
					<td>Comments</td>
					<td>statue</td>
					<td>Date</td>
					<td>Item Name</td>
					<td>Member Name</td>
					<td>Control</td>
					</tr>
				<?php
				if(!empty($row)){	
			foreach($row as $rrw){
				?>
				<tr>
					<td><?php echo $rrw['cid'];?></td>
					<td><?php echo $rrw['comment'];?></td>
					<td><?php echo $rrw['statue'];?></td>
					<td><?php echo $rrw['date'];?></td>
					<td><?php echo $rrw['ItemName'];?></td>
					<td><?php echo $rrw['MemberName'];?></td>

					<td>
						<a href="?do=edit&comid=<?php echo $rrw['cid']?>" class="btn btn-success"><i class='fa fa-edit'> </i>  Edit</a>
						<?php
							if($rrw['statue']==0){
						?>
						<a href="?do=approve&comid=<?php echo $rrw['cid']?>" class="btn btn-info"><i class='fa-regular fa-bell'> </i>  Approve</a>
						<?php
						}
						?>
						<a href="?do=delete&comid=<?php echo $rrw['cid']?>" class="btn btn-danger confirm"><i class='fa fa-close'> </i>  Delete</a>
						
						


					</td>


				</tr>
				<?php
			}

		}
		else{

			echo "<div class='container'>";
			echo "<div class='alert nice-mss'> Sorry NO RECORD TO SHOW</div>";
			echo"</div>";
			}
?>

		</table>
	</div>
	<?php
	}

elseif($do=='edit'){

$commentID=isset($_GET['comid'])&& is_numeric($_GET['comid'])?$_GET['comid']:0;

$stmt=$db->prepare('SELECT comments.*,items.Name AS ItemName FROM comments
					INNER JOIN items ON items.itemID =comments.itme_id WHERE cid=?');
$stmt->execute(array($commentID));
$count=$stmt->rowcount();
$rww=$stmt->fetch();
if($count>0){

	?>
<h1 class="text-center"> Edit Comments</h1>
<div class="container">
	<form class="form" action="?do=Update" method="Post" >
		<input type="hidden" name="IID" value="<?php echo $rww['cid']?>">
	<div class="mb-3 mt-3">
		<label class="col-sm-2 control-label">Comment on Item <strong> <?php echo $rww['ItemName']?></strong></label>
	
       <textarea type="text-area" name="com" class="form-control"><?php echo $rww['comment']?></textarea>
  		</div>

  		<div class="mb-3 mt-3 ">
		<div class="col-sm-offset col-sm-100 ">
		<button type="submit" class="btn btn-primary btn-lg form-control">Save</button>
		</div>
		</div>
</form>


	</div>
<?php
}

else{
$msg="<div class='alert alert-danger'> this User Not Found</div";
redirectMassag($msg,'back');

}

}



elseif($do=='Update'){
	?>

<h1 class="text-center"> UPDATE Comments</h1>
<div class="container">
<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
$IID=$_POST["IID"];
$comment=$_POST["com"];



$stmt=$db->prepare("UPDATE comments SET comment=?  WHERE cid=?");
$stmt->execute(array($comment,$IID));


$msg="<div class='alert alert-success'> UPDATE SUCCESSFUL</div>";
redirectMassag($msg,'back');
}
else{
$msg="<div class='alert alert-danger'> Can't Inside to this Page Direct Please Press Button Save</div";
redirectMassag($msg,'back');

}
?>
</div>
<?php	
}

elseif($do=='delete'){
?>

<h1 class="text-center"> Delete Comments</h1>
<div class="container">
<?php

$id=isset($_GET['comid'])&&is_numeric($_GET['comid'])?$_GET['comid']:0;

$stmt=$db->prepare('SELECT * FROM comments WHERE cid=?');
$stmt->execute(array($id));
$count=$stmt->rowcount();

if($count>0){

	$stmt=$db->prepare('DELETE FROM comments WHERE cid=?');
	$stmt->execute(array($id));

	$msg="<div class='alert alert-success'> Delete SUCCESSFUL</div>";
redirectMassag($msg,'back');
}
else{
$msg="<div class='alert alert-danger'> Can't Inside to this Page Direct Please Press Button Save</div";
redirectMassag($msg,'back');

}


}



elseif($do=='approve'){
?>

<h1 class="text-center"> approve Comments</h1>
<div class="container">
<?php

$id=isset($_GET['comid'])&&is_numeric($_GET['comid'])?$_GET['comid']:0;

$stmt=$db->prepare('SELECT * FROM comments WHERE cid=?');
$stmt->execute(array($id));
$count=$stmt->rowcount();

if($count>0){

	$stmt=$db->prepare('UPDATE comments SET statue=1 WHERE cid=?');
	$stmt->execute(array($id));

	$msg="<div class='alert alert-success'> Approved</div>";
redirectMassag($msg,'back');
}
else{
$msg="<div class='alert alert-danger'> Can't Inside to this Page Direct Please Press Button Save</div";
redirectMassag($msg,'back');

}


}





?>
</div>
<?php
}

include $tbl . "footer.php";
?>