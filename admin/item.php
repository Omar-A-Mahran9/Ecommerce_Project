<?php

ob_start();
session_start();
$title_page="ITEMS";

if (isset($_SESSION['USERNAME']))
{
	include "ini.php";
	$do=isset($_GET['do'])?$_GET['do']:'Manage';

	if($do=='Manage'){

		$stmt=$db->prepare('SELECT items.* ,categories.Name AS CATEGORYNAME, users.Username AS Name_USER FROM items 
			INNER JOIN categories ON categories.catID = items.Cat_id
			INNER JOIN users ON users.UserID = items.Member_ID
			');
		$stmt->execute();
		$row =$stmt->fetchAll();




		?>
		<h1 class="text-center">Manage ITEM</h1>
	<div class="container">
		<table class=" main_table table table-bordered">
				<tr>
					<td>#ID</td>
					<td>Item Name</td>
					<td>Description</td>
					<td>Date</td>
					<td>Price</td>
					<td>Country Made</td>
					<td>statue</td>
					<td>CategoryID</td>
					<td>memberID</td>
					<td>Control</td>
				</tr>
		<?php		
		if(!empty($row)){
		foreach ($row as $roww){
			?>
<tr>
					<td><?php echo $roww['itemID']?> </td>
					<td><?php echo $roww['Name']?> </td>
					<td><?php echo $roww['Description']?></td>
					<td><?php echo $roww['add_Date']?></td>
					<td><?php echo $roww['Price']?></td>
					<td><?php echo $roww['counteryMade']?></td>
					<td><?php echo $roww['sattus']?></td>
					<td><?php echo $roww['CATEGORYNAME']?></td>
					<td><?php echo $roww['Name_USER']?></td>
					<td>
						<a href="?do=edit&IDItem=<?php echo $roww['itemID']?>" class="btn btn-success"><i class='fa fa-edit'> </i>  Edit</a>
						<a href="?do=delete&iditem=<?php echo $roww['itemID']?>" class="btn btn-danger confirm"><i class='fa fa-close'> </i>  Delete</a>

						<?php
						if($roww['approve']==0){
						?>
						<a href="?do=Aproove&iditem=<?php echo $roww['itemID']?>" class="btn btn-info activate"><i class='fa fa-check'> </i>  Approve</a>
						<?php
						}
						?>


					</td>
				</tr>			
<?php
	}
}

else{

			echo "<div class='container'>";
			echo "<div class='alert nice-mss'> NO RECORD TO SHOW</div>";
			echo"</div>";
			}
	?>			
	</table>	
	<hr>	
			<a href="?do=add" class="btn float-end btn-primary"><i class="fa fa-plus"></i> Add New ITEM </a>
			</div>
	
<?php
}
	elseif ($do=="add"){
			 
		?>
		<div class="container">
		<h1 class="text-center">Add New Item</h1>
		<form class="form-horizontal" action="?do=insert" method="POST">
			<div class="mb-3 mt-3">
				<label class="col-sm-2 control-label" >Name of Item</label>
			<input type="text" name="nameItem" class="form-control"  placeholder="Please insert Item Name" required>
			</div>

			<div class="mb-3 mt-3">
			<label>Description of Item</label>
			<input type="text" name="Description" class="form-control" placeholder="Descripe your Item here"  required>
			</div>

			<div class="mb-3 mt-3">
				<label>Price Your Item</label>
			<input type="text" name="Price" class="form-control"  placeholder="your Price here" required> 
			</div>

			<div class="mb-3 mt-3">
				<label>Countery Made</label>
				<input type="text" name="Country"  class="form-control" placeholder="insrt country made here" required >
			</div>


			<div class="mb-3 mt-3">
				<label >Statue of Item</label>
				<select  aria-label="Default select example" name="Statue" required >
				  <option selected>select Statue</option>
				  <option value="1">NEW</option>
				  <option value="2">LIKE NEW</option>
				  <option value="3">USED</option>
				  <option value="4">Very Old</option>
				</select>		
			</div>
			
			<?php
			$stmt=$db->prepare('SELECT * FROM users ');
			$stmt->execute();
			$row=$stmt->fetchAll();
			?>

			<div class="mb-3 mt-3">
				<label >Select User to add item</label>
				<select  aria-label="Default select example" name="MemberID" required>
				  <option selected>select Statue</option>
			<?php
				  foreach($row as $raw){
				?>
				  <option value="<?php echo $raw['UserID'];?>"><?php echo $raw['Username'];?></option>
				  <?php
				}
				?>
				</select>		
			</div>


			<?php
			$stmt=$db->prepare('SELECT * FROM categories ');
			$stmt->execute();
			$rwow=$stmt->fetchAll();
			?>

			<div class="mb-3 mt-3">
				<label >Select type of category</label>
				<select  aria-label="Default select example" name="CatID" required>
				  <option selected>select Statue</option>
			<?php
				  foreach($rwow as $raaw){
				?>
				  <option value="<?php echo $raaw['catID'];?>"><?php echo $raaw['Name'];?></option>
				  <?php
				}
				?>
				</select>		
			</div>


			<div class="mb-3 mt-3 ">
				<div class="col-sm-offset col-sm-100 ">
				<button type="submit" class="btn btn-primary btn-lg form-control">Add New Item</button>
				</div>
			</div>
					
		</form>
			</div>
		<?php
	}

elseif($do=="insert"){
	?>
	<div class ='container'>
		<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$Name=$_POST['nameItem'];
		$description=$_POST['Description'];
		$price=$_POST['Price'];
		$country=$_POST['Country'];
		$statue=$_POST['Statue'];
		$mem=$_POST['MemberID'];
		$cat=$_POST['CatID'];

		$stmt= $db->prepare('SELECT * FROM items WHERE Name=?' );
		$stmt->execute(array($Name));
		$count=$stmt->rowCount();

		if($count>0){
			$msg='<div class="alert alert-danger">this Name Duplicated please change it </div>';
			redirectMassag($msg,'back');

		}
		else{
			$stmt=$db->prepare('INSERT INTO items(Name , Description , Price , counteryMade , sattus ,add_Date , Cat_id, Member_ID ) VALUES( :zname, :zdesc, :zprice, :zcountry, :zstatue , now() , :zcatid , :zmembid)');
			$stmt->execute(array('zname' =>$Name ,
								 'zdesc' =>$description ,
								 'zprice' =>$price ,
								 'zcountry' =>$country ,
								 'zstatue' =>$statue,
								 'zcatid' =>$cat ,
								 'zmembid' =>$mem
							     
							 	 ));
			$msg='<div class="alert alert-success"> Successful to inser this record into database</div>';
			redirectMassag($msg,'back');


		}
	}
	else{
		$msg='<div class="alert alert-danger">you can not inside here without press ADD New Item</div>';
		redirectMassag($msg,'back');
	}
	?>
	</div>
	<?php
}

elseif($do=='edit'){

	$IDitem = isset($_GET['IDItem'])&&is_numeric($_GET['IDItem'])?$_GET['IDItem']:0;

	if($IDitem>0){
		?>
		<?php
		$stmt=$db->prepare('SELECT * FROM items WHERE itemID=?');
		$stmt->execute(array($IDitem));
		$row=$stmt->fetch();

		
		?>
		<div class="container">
		<h1 class="text-center">Edit Item</h1>
		<form class="form-horizontal" action="?do=Update" method="Post">
			<div class="mb-3 mt-3">
				<label class="col-sm-2 control-label" >Name of Item</label>
				<input type="hidden" name="id" value="<?php echo $row['itemID']; ?>">
			<input type="text" name="nameItem" class="form-control"  placeholder="Please insert Item Name" required='required' value='<?php echo $row['Name']; ?>'>
			</div>

			<div class="mb-3 mt-3">
			<label>Description of Item</label>
			<input type="text" name="Description" class="form-control" placeholder="Descripe your Item here"  required='required'value='<?php echo $row['Description']; ?>'>
			</div>

			<div class="mb-3 mt-3">
				<label>Price Your Item</label>
			<input type="text" name="Price" class="form-control"  placeholder="your Price here" required='required'value='<?php echo $row['Price']; ?> '>
			</div>

			<div class="mb-3 mt-3">
				<label>Countery Made</label>
				<input type="text" name="Country"  class="form-control" placeholder="insrt country made here" required='required'value='<?php echo $row['counteryMade']; ?>'>
			</div>


			<div class="mb-3 mt-3">
				<label >Statue of Item</label>
				<select  aria-label="Default select example" name="Statue" required>
				  <option <?php if($row['sattus']==0){echo 'selected';}?>>select option</option>
				  <option value="1" <?php if($row['sattus']==1){echo 'selected';} ?>>NEW</option>
				  <option value="2" <?php if($row['sattus']==2){echo 'selected';} ?>>LIKE NEW</option>
				  <option value="3" <?php if($row['sattus']==3){echo 'selected';} ?>>USED</option>
				  <option value="4" <?php if($row['sattus']==4){echo 'selected';} ?>>Very Old</option>
				</select>		
			</div>
			
			<?php
			$stmt=$db->prepare('SELECT * FROM users ');
			$stmt->execute();
			$roew=$stmt->fetchAll();
			?>

			<div class="mb-3 mt-3">
				<label >Select User to add item</label>
				<select  aria-label="Default select example" name="MemberID" required>
				  <option <?php if($row['Member_ID']==0){echo 'selected';} ?>>select Statue</option>
			<?php
				  foreach($roew as $raw){
				?>
				  <option value="<?php echo $raw['UserID'];?>" <?php if($row['Member_ID']==$raw['UserID']){echo 'selected';} ?> ><?php echo $raw['Username'];?></option>
				  <?php
				}
				?>
				</select>		
			</div>


			<?php
			$stmt=$db->prepare('SELECT * FROM categories ');
			$stmt->execute();
			$rwow=$stmt->fetchAll();
			?>

			<div class="mb-3 mt-3">
				<label >Select type of category</label>
				<select  aria-label="Default select example" name="CatID" required>
				  <option >select Statue</option>
			<?php
				  foreach($rwow as $raaw){
				?>
				  <option value="<?php echo $raaw['catID'];?>" <?php if($row['Cat_id']==$raaw['catID']){echo 'selected';} ?>><?php echo $raaw['Name'];?></option>
				  <?php
				}
				?>
				</select>		
			</div>


			<div class="mb-3 mt-3 ">
				<div class="col-sm-offset col-sm-100 ">
				<button type="submit" class="btn btn-primary btn-lg form-control">Update Item</button>
				</div>
			</div>
					
		</form>
			
		<?php


	}
	else{
		$msg='<div class="alert alert-danger">Sorry this item not found here </div>';
		redirectMassag($msg,'back');
	}

?>
</div>
<?php
}

elseif($do=='Update'){
	?>
<h1 class="text-center"> Update Member</h1>
<div class="container">
<?php

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$name=$_POST['nameItem'];
		$description=$_POST['Description'];
		$price=$_POST['Price'];
		$country=$_POST['Country'];
		$statue=$_POST['Statue'];
		$mem=$_POST['MemberID'];
		$cat=$_POST['CatID'];
		$id=$_POST['id'];
		
			$stmt = $db->prepare('UPDATE items SET Name=? , Description=? , Price=? ,add_Date= now(), counteryMade=? , sattus=? , Cat_id=?, Member_ID=? WHERE itemID=?');
			$stmt->execute(array($name , $description ,	$price , $country ,	 $statue, $cat , $mem , $id));

			$msg='<div class="alert alert-success"> Successful to Update'. $stmt->rowCount() . 'record into database</div>';
			redirectMassag($msg,'back');

	}
	else{
		$msg='<div class="alert alert-danger">you can not inside here without press ADD New Item</div>';
		redirectMassag($msg,'back');
	}

?>
</div>
<?php

}

elseif($do=='delete'){
	?>
		<h1 class='text-center'>Delete Member</h1>
		<div class='container'>
	<?php
	
	$idi=isset($_GET['iditem'])&&is_numeric($_GET['iditem'])?$_GET['iditem']:0;
	

	$chech=checkitem('itemID', 'items', $idi);


	if($chech>0){
		$stmt=$db->prepare('DELETE FROM items WHERE itemID=?');
		$stmt->execute(array($idi));
		$msg="<div class='alert alert-success'>Successful" .$chech ."Deleted</div>";
		redirectMassag($msg,'back');	
	}
	else{
		$msg="<div class='alert alert-danger'>this Item not found</div>";
		redirectMassag($msg,'back');
	}
	


	?>
</div>
<?php
}



elseif($do=='Aproove'){
	?>
	<h1 class="text-center"> Approve Member</h1>
	<div class="container">
	<?php
	$Id=isset($_GET['iditem'])&&is_numeric($_GET['iditem'])?$_GET['iditem']:0;

	$chech=checkitem('itemID', 'items',$Id);

	$approve=0;
	if($chech>0){
		$approve=1;
		$stmt=$db->prepare('UPDATE items SET approve=? WHERE itemID=?');
		$stmt->execute(array($approve,$Id));
		$msg="<div class='alert alert-success'>Approved Done</div>";
		redirectMassag($msg,'back');
	}
	
	else{
		$msg="<div class='alert alert-danger'>this Item not found</div>";
		redirectMassag($msg,'back');
	}
	?>
</div>
<?php
}


}




include $tbl . "footer.php";
ob_end_flush();
?>