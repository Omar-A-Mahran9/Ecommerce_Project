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


   <!-- form section -->
    <div class="col-md-7">

		<form class="form-horizontal" action="?do=insert" method="Post">
			<div class="mb-3 mt-3">
				<label><b>Name of Item</b></label>
			<input type="text" name="nameItem" class="form-control live"  data-class="Name" placeholder="Please insert Item Name" required>
			</div>

			<div class="mb-3 mt-3">
			<label><b>Description of Item</b></label>
			<input type="text" name="Description" class="form-control live " data-class="Desc" placeholder="Descripe your Item here"  required>
			</div>

			<div class="mb-3 mt-3">
				<label><b>Price Your Item</b></label>
			<input type="text" name="Price" class="form-control live" data-class="price" placeholder="your Price here" required> 
			</div>

			<div class="mb-3 mt-3">
				<label><b>Countery Made</b></label>
				<input type="text" name="Country"  class="form-control " placeholder="insrt country made here" required >
			</div>


			<div class="mb-3 mt-3">
				<label ><b>Statue of Item</b></label>
				<select  aria-label="Default select example" name="Statue" required >
				  <option selected>select Statue</option>
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
        <!-- photo section -->
        <div class="col-md-5">
<div class="thumbnail card h-100 shadow-sm"> 
<img src="https://www.freepnglogos.com/uploads/notebook-png/download-laptop-notebook-png-image-png-image-pngimg-2.png" class="card-img-top" alt="..."> <div class="card-body"> 
<div class="clearfix mb-3"> 
<span class="float-start badge rounded-pill bg-primary Name"></span> <span class="float-end price-hp price" >  &euro;</span> </div> <h5 class="card-title Desc" > </h5> <div class="text-center my-4"> <a href="#" class="btn btn-warning">Check offer</a> </div> </div> </div> </div>

       

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