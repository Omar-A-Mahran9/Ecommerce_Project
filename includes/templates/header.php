<DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php PrintTitle() ?></title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo $css?>bootstrap.min.css">
	

	<link rel="stylesheet" type="text/css" href="<?php echo $css?>all.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $css?>jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $css?>jquery.selectBoxIt.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $css?>front.css">



</head>
<body>

	<div class="upper-bar">
	<div class="container">
		<?php
		if(isset($_SESSION['User'])){
			echo 'Welcom' . $_SESSION['User']."  ";
			echo "<a href='Profile.php'>My Profile</a>";
			echo "-";
			echo "<a href='logout.php'>Log Out</a>";
			$tatue=checkUserStatus($_SESSION['User']);
			if ($tatue==1){
				echo "Your memebr ship need to activate";
			}
		}
		else{
		?>
		<a href="login.php">
			<span class="d-flex justify-content-end">
			Login/Signup
		</span>
			</a>
			<?php
		}
?>
	</div>
	</div>
	<nav class="navbar navbar-dark bg-dark">

  <div class="container">
    <a class="navbar-brand" href="#"><?php echo lang('E-Commerce');?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="app_nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

      <?php

$cat= getgetcat();

foreach($cat as $ct){
?>
 <li class="nav-item">
<a class="nav-link " aria-current="page" href="category.php?cat_id=<?php echo $ct['catID']; ?>&cat_name=<?php echo $ct['Name'];?>"><?php echo $ct['Name'];?></a>
 </li>

<?php
}
?>


      	      </ul>
     
    </div> 
  </div>

</nav>


</body>
