 <?php
session_start();

if(isset($_SESSION['USERNAME'])){

	$NAME=$_SESSION['USERNAME'];

	$title_page="Welcome  $NAME";
	
	include "ini.php";


	$do=isset($_GET['do'])?$_GET['do']:"Manage";
	/*
	$do='';
	if(isset($_GET['do'])){

		$do = $_GET['do'];

	}
	else{

		$do ="Manage";

	}
	*/


	//Mange Pagee....................................................................................
if ($do=="Manage"){?>

	<h1 class="text-center">Manage Member</h1>
	<div class="container">
		<div class="table"> 
			<?php 


			//importannnnnnnt for change sql query 
		$query="";
		if (isset ($_GET['Page'])&&$_GET['Page']=="Pending"){
			$query='AND RegStatus= 1';

		}
		//..........................
			$stmt=$db->prepare("SELECT *  FROM users WHERE GroupID != 1 $query");
			
			//execute the statment
			$stmt -> execute();
			//assign to variable
			$row=  $stmt->fetchAll();

			
			
			?>
			<table class=" main_table table table-bordered">
				<tr>
					<td>#ID</td>
					<td>User Name</td>
					<td>Email</td>
					<td>Full Name</td>
					<td>Registerd Data</td>
					<td>Control</td>
				</tr>
		<?php
		if(!empty($row)){		
		foreach($row as $roe){?>
			<tr>
					<td><?php echo $roe['UserID']?> </td>
					<td><?php echo $roe['Username']?> </td>
					<td><?php echo $roe['Email']?></td>
					<td><?php echo $roe['FullName']?></td>
					<td><?php echo $roe['Date']?></td>
					<td>
						<a href="?do=edit&userid=<?php echo $roe['UserID']?>" class="btn btn-success"><i class='fa fa-edit'> </i>  Edit</a>
						<a href="?do=delete&userid=<?php echo $roe['UserID']?>" class="btn btn-danger confirm"><i class='fa fa-close'> </i>  Delete</a>
						<?php
						if ($roe['RegStatus'] == 1){?>
						<a href="?do=Pending&userid=<?php echo $roe['UserID']?>" class="btn btn-info"><i class='fa-solid fa-arrows-to-eye'> </i>  Active</a>		
						
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

		</div>
		<a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member </a>
	</div>

	
	 

 	<?php
	}



//add member page...............................................................................................
elseif($do=="Add"){
	?>
	<h1 class="text-center">Add New Member</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=insert" method="Post">
			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label">Username</label>
			<div class="  ">
			<input type="text" name="username"  class="form-control" placeholder="Username to login on site" required ="true" >
		</div>
			</div>

			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label">Password</label>
			<div class="  ">
			 
			<input type="password" name="password" class="password form-control" placeholder="Password must be complxed to login on site" required ="true" autocomplete="new-password" placeholder="">
			<i class="show-pass fa fa-eye fa-2x"></i>
		</div>
			</div>

			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label">Email</label>
			<div class="  ">
			<input type="email" name="email"class="form-control" placeholder="Email to login on site" placeholder="" autocomplete="off" required ="true">
		</div>
			</div>

			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label">Full Name</label>
			<div class="  ">
			<input type="text" placeholder="must insert fullname" name="fullname"class="form-control" required ="true" placeholder="" autocomplete="off" >
		</div>
			</div>
			<div class="mb-3 mt-3 ">
			<div class="col-sm-offset col-sm-100 ">
			<button type="submit" class="btn btn-primary btn-lg form-control">Add Member</button>
			</div>
			</div>

	</form>

		<?php

		}





 //insert page-.......................................................................................
elseif($do=='insert'){

if ($_SERVER['REQUEST_METHOD']=='POST'){
	?>
<h1 class="text-center"> Update Member</h1>
<div class="container">

<?php

if ($_SERVER['REQUEST_METHOD']=='POST'){
	$username	=$_POST['username'];
	$password	=$_POST['password'];
	$hashpass	=sha1($_POST['password']);
	$email		=$_POST['email'];
	$fullname	=$_POST['fullname'];
	//update the database
	;
	
	//password trick
	//condition ? true : false;
	

	/*if (empty($_POST["new-password"])){
		$pass=$_POST['old-password'];
	}
	else{
		$pass=sha1($_POST['new-password']);
	}
	*/

	//validate the form
	$array_err=array();
	if (empty($username)){
		$array_err[]= "must be <strong>complete</strong> your username";
	}
	if (strlen($username)>15){
	$array_err[]= "username must be less than <strong> 15 charec</strong>";
	}
	if (strlen($username)<5){
		$array_err[]= "username must be bigger than <strong>5 charec</strong>";
	}

	if (empty($password)){
		$array_err[]= "enter your password please>";
	}

	if(empty($email)){
		$array_err[]= "must be <strong>complete</strong> your email";
	}
	if(empty($fullname)){
		$array_err[]="must be <strong>complete</strong> your fullname";
	}
	
	//loop into error array
	foreach($array_err as $error){
           
		echo '<div class="alert alert-danger">' . $error ."</div> </br>" ;
	}


//check If there is No Error Proceed The Update Operation
if(empty($array_err)){
	//check if user Exist in data base
	$check	=checkitem('Username', 'users', $username);

	if ($check==1){
		
		$msg= "<div class='alert alert-danger'>"."you have dublicated username in your table". "</div>";
		redirectMassag($msg,'back');
	}
	else{
$stmt = $db->prepare("INSERT INTO 
						users(Username, Password, Email, FullName, RegStatus ,Date)
						VALUES(:zuser, :zpass, :zemail, :zname, 1, now())");

	$stmt->execute(array(

		'zuser'	=> $username,
		'zpass'	=> $hashpass,
		'zemail'=>$email,
		'zname'	=>$fullname
	));

$msg="<div class='alert alert-success'>" . $stmt->rowCount() . " " ."Record Inserted</div>";
redirectMassag($msg,'back' ); 

}
}
}

?>
</div>
<?php
}
else{
echo "<div class='container'>";
$msg="<div class='alert alert-danger'>acces to it bage by button</div>";
redirectMassag($msg,'back' ); 
echo "</div>";
}

}



// Pending page..............................................................................................................
elseif($do=="Pending"){

?>
		<h1 class='text-center'>Activate Member</h1>
		<div class='container'>
	<?php
	
	//check if Get Request userid Is Numeric & Get the integer value of it
	
	$Id_User=isset($_GET["userid"])&&is_numeric($_GET['userid'])?intval($_GET['userid']): 0;
	
	//Select all data depend on thi ID
	$chech=checkitem('userID', 'users', $Id_User);
	
	/*$stmt= $db->prepare("SELECT * FROM users WHERE UserID = ? Limit 1");
	
	$stmt->execute(array($Id_User));
	
	$count=$stmt->rowCount();
	*/
	//if ther is sych ID show the form
	
	
	if ($chech > 0){
	
		$stmt=$db->prepare("UPDATE users SET RegStatus=0 WHERE UserID= ?");

	
		// Excute Query
	
		$stmt->execute(array($Id_User));


		$errormsg= '<div class="alert alert-success">' . $stmt->rowCount() . " " . "Record Activated".'</div>';
		redirectMassag($errormsg ,'back',2);

	}

	else{

	$errormsg='<div class= "alert alert-danger">this ID not exist so we can not Activte it</div>';

	redirectMassag($errormsg ,'back',2);
	}
 
	?>

	</div>
	<?php

}


// edit page..............................................................................................................


elseif($do=="edit"){

	
	//check if Get Request userid Is Numeric & Get the integer value of it

$Id_User=isset($_GET["userid"])&&is_numeric($_GET['userid'])?intval($_GET['userid']): 0;

//Select all data depend on thi ID

$stmt= $db->prepare("SELECT * FROM users WHERE UserID = ? Limit 1");

// Excute Query

$stmt->execute(array($Id_User));

//fetch the data

$row=  $stmt->fetch();

//if there is such ID show the form

$count=$stmt->rowcount();

   
if($count>0){

	?>
	<h1 class="text-center"> Edit Member</h1>
	<div class="container">
	<form class="form-horizontal" action="?do=Update" method="Post">
		<input type="hidden" name="userid" value="<?php echo $row['UserID']?>">
		<div class="mb-3 mt-3">
		<label class="col-sm-2 control-label">Username</label>
		<div class="  ">
		<input type="text" name="username"  class="form-control" value="<?php echo $row['Username']?>" required ="true" >
	</div>
		</div>

		<div class="mb-3 mt-3">
		<label class="col-sm-2 control-label">Password</label>
		<div class="  ">
		<input type="hidden" name="old-password" class="form-control"  value="<?php echo $row['Password']?>">
		<input type="text" name="new-password" class="form-control" autocomplete="new-password" placeholder="if you do not need change Password let it blank">
	</div>
		</div>

		<div class="mb-3 mt-3">
		<label class="col-sm-2 control-label">Email</label>
		<div class="  ">
		<input type="email" name="email"class="form-control" value="<?php echo $row['Email']?>" autocomplete="off" required ="true">
	</div>
		</div>

		<div class="mb-3 mt-3">
		<label class="col-sm-2 control-label">Full Name</label>
		<div class="  ">
		<input type="text" name="fullname"class="form-control" value="<?php echo $row['FullName']?>" autocomplete="off" >
	</div>
		</div>
		<div class="mb-3 mt-3 ">
		<div class="col-sm-offset col-sm-100 ">
		<button type="submit" class="btn btn-primary btn-lg form-control">Save</button>
		</div>
		</div>

</form>



<?php
	/*echo "Welcome You are In edit category Page";
   echo $_SESSION['USERNAME'];
*/
}
//if not found ID show it massege
else {
	echo "<div class='container'>";
	$msg= '<div class="alert alert-danger" > Not found this ID </div>  ';
	redirectMassag($msg,'back' ); 
	echo "</div>";
};

}





//update page................................................................................................................
elseif($do=="Update"){ 
	?>
<h1 class="text-center"> Update Member</h1>
<div class="container">
<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
	$id  		=$_POST['userid'];
	$username	=$_POST['username'];
	$email		=$_POST['email'];
	$fullname	=$_POST['fullname'];
	//update the database
	
	
	//password trick
	//condition ? true : false;
	$pass = empty($_POST["new-password"]) ? $_POST['old-password'] : sha1($_POST['new-password']);

	/*if (empty($_POST["new-password"])){
		$pass=$_POST['old-password'];
	}
	else{
		$pass=sha1($_POST['new-password']);
	}
	*/

	//validate the form
	$array_err=array();
	if (empty($username)){
		$array_err[]= "must be <strong>complete</strong> your username";
	}
	if (strlen($username)>15){
	$array_err[]= "username must be less than <strong> 15 charec</strong>";
	}
	if (strlen($username)<5){
		$array_err[]= "username must be bigger than <strong>5 charec</strong>";
	}

	if(empty($email)){
		$array_err[]= "must be <strong>complete</strong> your email";
	}
	if(empty($fullname)){
		$array_err[]="must be <strong>complete</strong> your fullname";
	}
	
	//loop into error array
	foreach($array_err as $error){
           
		echo '<div class="alert alert-danger">' . $error ."</div> </br>" ;
	}

if(empty($array_err)){
	$stmt2=$db->prepare('SELECT * FROM users WHERE Username=? AND UserID != ? ');
	$stmt2->execute(array($username,$id));
	$counnt=$stmt2->rowcount();
	if($counnt==1){
		$errormsg= "<div class= 'alert alert-danger'>This USERNAME DUPLICATED </div>";

	redirectMassag($errormsg ,'back');
	}
	else{

	$stmt=$db->prepare("UPDATE users SET Username= ? ,Email= ?, FullName= ?, Password=? WHERE UserID=?");
	$stmt->execute(array($username,$email,$fullname,$pass,$id));
	//echo success Massege
	$themsg= '<div class="alert alert-success">' . $stmt->rowCount() . " " . "Record Updated".'</div>';
	redirectMassag($themsg,'back' );
}
}
}

else{			 

	$errormsg= "<div class= 'alert alert-danger'>Sorry you can not browse this page directly</div>";

	redirectMassag($errormsg ,'back');

}

} //end of do=Update






//delete page .............................................
elseif($do=='delete'){
		?>
		<h1 class='text-center'>Delete Member</h1>
		<div class='container'>
	<?php
	
	//check if Get Request userid Is Numeric & Get the integer value of it
	
	$Id_User=isset($_GET["userid"])&&is_numeric($_GET['userid'])?intval($_GET['userid']): 0;
	
	//Select all data depend on thi ID
	$chech=checkitem('userID', 'users', $Id_User);
	
	/*$stmt= $db->prepare("SELECT * FROM users WHERE UserID = ? Limit 1");
	
	$stmt->execute(array($Id_User));
	
	$count=$stmt->rowCount();
	*/
	//if ther is sych ID show the form
	
	
	if ($chech > 0){
	
		$stmt=$db->prepare("DELETE FROM users WHERE UserID= :zuser");
	
		$stmt->bindParam(":zuser",$Id_User);
	
		// Excute Query
	
		$stmt->execute();


		$errormsg= '<div class="alert alert-success">' . $stmt->rowCount() . " " . "Record Deleted".'</div>';
		redirectMassag($errormsg ,'back',2);

	}

	else{

	$errormsg='<div class= "alert alert-danger">this ID not exist so we can not delete it</div>';

	redirectMassag($errormsg ,'back',2);
	}
 
	?>

	</div>
	<?php
	}



else{ 
$msg="<div class='alert alert-danger'>No Result for DO statment</div>";
redirectMassag($msg,'back');
}


}// end off this statment session_start(); if(isset($_SESSION['USERNAME']))

else{



	header('Location: index.php');

	exit();
};

   
	include $tbl . "footer.php";
?>