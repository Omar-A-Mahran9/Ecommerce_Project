<?php
ob_start();
session_start();
$title_page ="Login";

if (isset($_SESSION['User'])){
    header('Location:index.php');
}
include "ini.php";
if ($_SERVER['REQUEST_METHOD']=="POST"){
    if (isset($_POST['login'])){
    $user=$_POST['username'];
    $pass=$_POST['Password'];
    $hashPas=sha1($pass);
 
    $stmt=$db->prepare("SELECT UserID , Username , Password FROM users WHERE Username=? AND Password=? ");
    $stmt->execute(array($user , $hashPas));
    $count=$stmt->rowCount();
    $row=$stmt->fetch();
    if ($count>0){
        $_SESSION['User']=$row['Username']; //Register Session name
        $_SESSION['user_ID']=$row['UserID']; //Register Session ID

        header('Location:index.php');
        exit();
        
    }
}
else{
   $form_Errors=array();
    $user=$_POST['username'];
    $pass=sha1($_POST['Password']);
    $pass2=sha1($_POST['Password2']);
    $email=$_POST['Email'];


 

    if(isset($_POST['username']))  {
       $filterusername=filter_var($_POST['username'],FILTER_SANITIZE_STRING) ;
       if (strlen($filterusername)<4){
        $form_Errors[]="User name must be larger than 4 char";
       }
    }
    if (isset($_POST['Password']) && isset($_POST['Password2'])) {
        if (empty($_POST['Password'])){
            $form_Errors[]= "Sorry Password can't be Empty ";
        }

        if(sha1($_POST['Password'])!==sha1($_POST['Password2'])){
            $form_Errors[]= "Sorry Password Not Match ";
        }
  }

  if(isset($_POST['Email'])){
    $filterusername=filter_var($_POST['Email'],FILTER_SANITIZE_EMAIL) ;
    if (filter_var($filterusername,FILTER_VALIDATE_EMAIL) != true){
     $form_Errors[]="Not Valid Email";
    }


}

if (empty($form_Errors)){
    $count=checkitem('Username', 'users', $user);
    if($count==1){
        $form_Errors[]="Sorry this Username used before this time ";
    }
    else{
        $stmt=$db->prepare("INSERT INTO users(Username, Password, Email , Regstatus, Date) VALUES(:sername, :assword, :mail, 1,now())");
        $stmt->execute(array(
            
                    'sername' =>$user,
                    'assword' => $pass,
                    'mail' => $email,
        ));
        $suc= "<div class= 'alert alert-success'>Congratulation $user Now You are member On site </div> ";
        }
}
    
}
    }

?>
 
<div class='container loginPage'>
<h1 class='text-center sub '>
    <span  data-class='login' class="active"> Login</span> | <span data-class="signup">Signup</span>
</h1>

<!--start login form-->
    <form class='login' action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
      <div class="input-container">
        <input class="form-control"  type='text' name="username"  autocomplete="off" value="" required placeholder="Type your user name">
        <span class="asterik">*</span>
     </div>
     <div class="input-container">
          <input class="form-control" type="Password" name="Password" autocomplete="off" value="" required placeholder='Type your Password'/>
          <span class="asterik">*</span>
     </div>
        <input class="btn btn-primary form-control" type="submit" name='login' value='Login'>
</form>


<!--end login form-->
<!--start signup form-->
    <form class='signup' action="<?php echo $_SERVER['PHP_SELF']?>" method='POST'>
    <div class="input-container">

        <input class="form-control"  type='text' name="username"  autocomplete="off" placeholder="Type your user name" pattern=".{4,8}" title="Username must be between 4 and 8 Char" required/>
        <span class="asterik">*</span>
     </div>
     <div class="input-container">
        <input class="form-control"  type='Email' name="Email"  autocomplete="off" placeholder="Type your Email"/>
        <span class="asterik">*</span>
     </div>
     <div class="input-container">
        <input class="form-control" type="Password" name="Password" autocomplete="off" placeholder='Type your Password' minlength="4" required/>
        <span class="asterik">*</span>
     </div>
     <div class="input-container">
        <input class="form-control" type="Password" name="Password2" autocomplete="off" placeholder='Type your Password Again' minlength="4" required/>
        <span class="asterik">*</span>
     </div>

        <input class="btn btn-success form-control" type="submit" name="signup" value='Signup'>
        
</form>
<div class="the_error text-center">
    
<?php
if(!empty($form_Errors)){
foreach($form_Errors as $error){
    ?>
    <div class="MSG">
   <?php echo $error."</br>";?>
    </div>
<?php
}  

}
if(isset($suc)){
    echo $suc;
}
?>

</div>
<!--end signup form-->
</div>



<?php


include $tbl . "footer.php";
ob_end_flush();
?>