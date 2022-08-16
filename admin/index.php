<?php

session_start();

$noNavbar ="";

$title_page ="Login";
//if(isset($_ScmdESSION['USERNAME'])){
if(isset($_SESSION['USERNAME'])){

	header('Location:dashboard.php');
}

include "ini.php";



?>
<form class="login" action="<?php $_SERVER['PHP_SELF']?>" method="POST">

	<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
	<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">

	 <div class="d-grid">
	<input class="btn btn-primary d-grid btn-block" type="submit" value="Login" />
	 </div>
</form>
    


 <?php

//check if HTTP Post Request is correct
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$username=$_POST['user'];
		$password=$_POST['pass'];
		$hashedpass=sha1($password);


	//check if user in database thin if found Put it details on session
		$stmt= $db -> prepare("SELECT UserID, Username, Password FROM users WHERE Username= ? AND Password= ? AND GroupID=1 LIMIT 1");

		$stmt->execute(array($username,$hashedpass));
		$row=$stmt->fetch();
		$count=$stmt->rowCount();

		if($count>0){
		$_SESSION['USERNAME']=$row['Username']; //Register session name
		$_SESSION['ID']=$row['UserID'];  //Register session ID
		header("Location: dashboard.php");//Redirect To dashboard
		exit();
		}
}
include $tbl . "footer.php";
?>