<?php
session_start();
$title_page ="ADD New Item";

include "ini.php";

if (isset($_SESSION['User'])){
	if ($_SERVER['REQUEST_METHOD']=='POST'){
	$form_err		=array();
	$itemName		=filter_var($_POST['nameItem'],FILTER_SANITIZE_STRING);
	$itemDes		=filter_var($_POST['Description'],FILTER_SANITIZE_STRING);
	$itemPrice		=filter_var($_POST['Price'],FILTER_SANITIZE_NUMBER_INT);
	$itemCountry	=filter_var($_POST['Country'],FILTER_SANITIZE_STRING);
	$itemstatue		=filter_var($_POST['Statue'],FILTER_SANITIZE_NUMBER_INT);
	$itemCat		=filter_var($_POST['CatID'],FILTER_SANITIZE_NUMBER_INT);


		if (strlen($itemName)<4){
			$form_err[] = 'Item Name must be at least 4 char';
		}
		if (strlen($itemDes)<10){
			$form_err[] = 'Description of Item must be at least 10 char';
		}
		if (strlen($itemCountry)<2){
			$form_err[] = 'Country of Item must be at least 2 char';
		}

		if (empty($itemPrice)){
			$form_err[] = 'the price is empt so fill it please';
		}

		if (empty($itemstatue)){
			$form_err[] = 'the statue ce is empt so fill it please';
		}

		if (empty($itemCat)){
			$form_err[] = 'the Category is empt so fill it please';
		}

		if(empty($form_err)){
				$userid= $_SESSION["user_ID"];
		$stmt=$db->prepare(" INSERT INTO items( Name, Description, Price, add_Date, counteryMade, sattus, Cat_id, Member_ID)
										VALUES(:zname, :zdec, :zprice, NOW(), :zcoun, :zstat, :zcat, :zuser)");
			
			$stmt->execute(array(
				"zname"			=>	$itemName,
				"zdec"			=>	$itemDes,
				"zprice"		=>	$itemPrice,
				"zcoun"			=> 	$itemCountry,
				"zstat" 		=>	$itemstatue,
				"zcat"			=>	$itemCat,

				"zuser"			=>	$userid
			));
			if ($stmt){
				
				echo "<div class='container alert alert-success'> Item Successfuly Added </div>";
			}
		}
		
	}



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


   <!-- form section -->
    <div class="col-md-7">

		<form class="form-horizontal" action= "<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
			<div class="mb-3 mt-3">
				<label><b>Name of Item</b></label>
			<input type="text" name="nameItem" class="form-control live"  data-class="Name" placeholder="Please insert Item Name" required>
			</div>

			<div class="mb-3 mt-3">
			<label><b>Description of Item</b></label>
			<input type="text" name="Description" class="form-control live " data-class="Desc" placeholder="Descripe your Item here" required >
			</div>

			<div class="mb-3 mt-3">
				<label><b>Price Your Item</b></label>
			<input type="text" name="Price" class="form-control live" data-class="price" placeholder="your Price here" required> 
			</div>

			<div class="mb-3 mt-3">
				<label><b>Countery Made</b></label>
				<input type="text" name="Country"  class="form-control " placeholder="insrt country made here" required>
			</div>


			<div class="mb-3 mt-3">
				<label ><b>Statue of Item</b></label>
				<select  aria-label="Default select example" name="Statue" required >
				  <option selected >select Statue</option>
				  <option value="1">NEW</option>
				  <option value="2">LIKE NEW</option>
				  <option value="3">USED</option>
				  <option value="4">Very Old</option>
				</select>		
			</div>
			
			
			<?php
			$stmt=$db->prepare('SELECT * FROM categories ');
			$stmt->execute();
			$rwow=$stmt->fetchAll();
			?>

			<div class="mb-3 mt-3">
				<label ><b>Select type of category</b></label>
				<select  aria-label="Default select example" name="CatID" required>
				  <option selected >select Statue</option>
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
        <!-- photo section -->
		    <div class="col-md-5">
<div class="thumbnail card h-100 shadow-sm"> 
<img src="https://www.freepnglogos.com/uploads/notebook-png/download-laptop-notebook-png-image-png-image-pngimg-2.png" class="card-img-top" alt="..."> <div class="card-body"> 
<div class="clearfix mb-3"> 
<span class="float-start badge rounded-pill bg-primary Name"></span> <span class="float-end price-hp price" >  &euro;</span> </div> <h5 class="card-title Desc" > </h5> <div class="text-center my-4"> <a href="#" class="btn btn-warning">Check offer</a> </div> </div> </div> </div>

       

</div>
   <!-- start print errors-->
  <div>
	<?php
if(!empty($form_err)){
	foreach($form_err as $err){
		echo '<div class="alert alert-danger">'. $err.'</div>';

	}
}

	?>
  </div>
   <!-- end of print error -->

</div>
    </div>
 </div>
<?php
}





include $tbl . "footer.php";
?>