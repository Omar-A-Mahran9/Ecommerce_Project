<?php

ob_start();

session_start();

$title_page="CATIGORIES";

if(isset($_SESSION['USERNAME'])){

	include 'ini.php';

	$do=isset($_GET['do'])?$_GET['do']:'Manage';

	if($do=='Manage'){

		

			$sortDef="ASC";
			$sort_arra = array('ASC','DESC');
			if(isset($_GET['sort'])&&in_array($_GET['sort'], $sort_arra)){
				$sortDef=$_GET['sort'];
			}
			else{
				$sortDef="ASC";
			}

			$stmt=$db->prepare("SELECT * FROM categories ORDER BY Ordering $sortDef");
			$stmt->execute();
			$row=$stmt->fetchAll();
			$count=$stmt->rowCount();
			

			
		?>
		<h1 class="text-center">Manage Category</h1>

		
		<div class='container'>
			<div class='ordering float-end'>
				<i class="fa fa-sort" ></i> Orderin:
				[<a class="<?php if($sortDef=='ASC'){echo 'active';}?>" href="?sort=ASC">ASC </a>|
				<a class="<?php if($sortDef=='DESC'){echo 'active';}?>" href="?sort=DESC">DECS</a>]
			</div>
				<div class="table "> 

		<table class=" main_table table table-bordered">
			<h5 class="float-start"><i class="fa fa-edit"></i>  Manage Category</h5>
				
				<tr>
					<td>#ID</td>
					<td>Category Name</td>
					<td>Description</td>
					<td>control</td>
					
				</tr>
	<?php
	foreach ($row as $cat) {
		?>
					<tr class="ho cat">
					<td><?php echo $cat['catID']?></td>
					<td><?php echo $cat['Name']?></td>
					<td><?php $des= $cat['Description']=="" ?'this category has no description':$cat['Description'];
										echo $des;?>
					</td>
					
					<td class=''>  
						<div class="hidden-buton">
							<a href='?do=edit&catid=<?php echo $cat['catID']?>' class="btn  btn-primary"><i class="fa fa-edit"></i> Edit</a>
							<a href='?do=delete&catid=<?php echo $cat['catID']?>' class="btn  btn-danger"><i class="fa fa-close"> </i> Delete</a>
						</div>
					</td>
					
				</tr>

				<?php
				}			
				?>
					
				
		</table>
	  </div>
		<a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Category </a>
		</div>


<?php	}

	elseif($do=='Add'){
		?>
		<h1 class="text-center">Add New Category</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=Insert" method="Post">
			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label" for="catName" >CategoryName</label>
			<div class="  ">
			<input type="text" name="Category_Name" id="catName"  class="form-control" placeholder="Pleaase insert category name here" required ="required" >
		</div>
			</div>

			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label">Description</label>
			<div class="  ">
			<input type="text" name="description" class="form-control" placeholder="your description here"  placeholder="insert ypur description here">
			</div>
			</div>

			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label">Ordering</label>
			<div class="  ">
			<input type="text" name="ordering" class="form-control" placeholder="order number to sort" placeholder="Number to arrnge the category" autocomplete="off" >
		</div>
			</div>

			<label class="col-sm-2 control-label"> visible</label>
			<div class="form-check">
  		<input class="form-check-input" type="radio" value='0' name="visibilty" id="vis-yes" checked>
 		 <label class="form-check-label" for="vis-yes">
    	Yes
 		 </label>
		</div>
		<div class="form-check">
		  <input class="form-check-input" type="radio" value='1' name="visibilty" id="vis-NO" >
		  <label class="form-check-label" for="vis-NO">
		    NO
		  </label>
		</div>


		<label class="col-sm-2 control-label"> Allow Comment</label>
			<div class="form-check">
  		<input class="form-check-input" type="radio" value='0' name="comment" id="com-yes" checked>
 		 <label class="form-check-label" for="com-yes">
    	Yes
 		 </label>
		</div>
		<div class="form-check">
		  <input class="form-check-input" type="radio" value='1' name="comment" id="com-NO" >
		  <label class="form-check-label" for="com-NO">
		    NO
		  </label>
		</div>


		<label class="col-sm-2 control-label"> Allow ad</label>
			<div class="form-check">
  		<input class="form-check-input" type="radio" value='0' name="ads" id="ad-yes" checked>
 		 <label class="form-check-label" for="ad-yes">
    	Yes
 		 </label>
		</div>
		<div class="form-check">
		  <input class="form-check-input" type="radio" value='1' name="ads" id="ad-NO" >
		  <label class="form-check-label" for="ad-NO">
		    NO
		  </label>
		</div>
		<div class="mb-3 mt-3 ">
			<div class="col-sm-offset col-sm-100 ">
			<button type="submit" class="btn btn-primary btn-lg form-control">Add New Category</button>
			</div>
			</div>
	</form>
		
<?php
	}

	elseif($do=='Insert'){

		if($_SERVER['REQUEST_METHOD']=='POST'){

			$NAME=$_POST['Category_Name'];
			$DESCRIP=$_POST['description'];
			$Ordering=$_POST['ordering'];
			$visible=$_POST['visibilty'];
			$Allo_com=$_POST['comment'];
			$Allow_ad=$_POST['ads'];

			$stmt=$db->prepare('SELECT Name FROM categories WHERE Name=? ');
			
			$stmt->execute(array($NAME));

			$count=$stmt->rowCount();

			if($count>0){
				$msg="<div class='alert alert-success'> sorry dublicated Name" . $count . " " ."Time on databse</div>";
						redirectMassag($msg,'back' ); 
			
			}
		
			else{

					$stmt=$db->prepare('INSERT INTO categories(Name , Description , Ordering , visibilty , allow_comment , allow_ads ) VALUES(:zname, :zdesc, :zorder, :zvisbilty, :zallowcom, :zallowads)');
					$stmt->execute(array(
							
							'zname'			=> $NAME,
							
							'zdesc'			=> $DESCRIP,
							
							'zorder'		=> $Ordering,
							
							'zvisbilty'	=> $visible,

							'zallowcom'	=> $Allo_com,

							'zallowads' => $Allow_ad,

					));
					$msg="<div class='alert alert-success'>" . $stmt->rowCount() . " " ."Record Inserted</div>";
						redirectMassag($msg,'back' ); 
				}	 


			

	}
		else{
			$msg="<div class='alert alert-danger'>You cant Enter to this Page directy please click the add new category button to inside here </div>";
			redirectMassag($msg ,' back' );
		}
	}


	elseif($do=='edit'){
		$Id_Cat="";
	if (isset($_GET['catid'])&&is_numeric($_GET['catid'])){
		$Id_Cat=$_GET['catid'];
	}
	else{
		$Id_Cat=0;
	}

		$stmt=$db->prepare('SELECT * FROM categories WHERE catID=? LIMIT 1');
		$stmt->execute(array($Id_Cat));
		$dat=$stmt->fetch();
		$row=$stmt->rowCount();

		if($row>0){
			
		?>	
			<h1 class="text-center">Edit Category</h1>
		<div class="container">
		<form class="form-horizontal" action="?do=Update" method="Post">
			<input type="hidden" name="catid" value="<?php echo $dat['catID']?>">
			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label" for="catName" >CategoryName</label>																		
			<div class="  ">
			<input type="text" name="Category_Name" id="catName"  class="form-control" placeholder="Pleaase insert category name here" required ="required" value='<?php echo $dat['Name']?>'>
		</div>
			</div>

			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label">Description</label>
			<div class="  ">
			<input type="text" name="description" class="form-control" placeholder="your description here"  placeholder="insert ypur description here" value='<?php echo $dat['Description']?>'>
			</div>
			</div>

			<div class="mb-3 mt-3">
			<label class="col-sm-2 control-label">Ordering</label>
			<div class="  ">
			<input type="text" name="ordering" class="form-control" placeholder="insert number to help ordering category" placeholder="Number to arrnge the category" autocomplete="off" value='<?php echo $dat['Ordering']?>' >
		</div>
			</div>

			<label class="col-sm-2 control-label"> visible</label>
			<div class="form-check">
  		<input class="form-check-input" type="radio" value='0' name="visibilty" id="vis-yes" <?php if($dat['visibilty']==0){ echo 'checked'; } ?>>
 		 
 		 <label class="form-check-label" for="vis-yes">
    	Yes
 		 </label>
		</div>
		<div class="form-check">
		  <input class="form-check-input" type="radio" value='1' name="visibilty" id="vis-NO" <?php if($dat['visibilty']==1){ echo 'checked';}?>>
		  <label class="form-check-label" for="vis-NO">
		    NO
		  </label>
		</div>


		<label class="col-sm-2 control-label"> Allow Comment</label>
			<div class="form-check">
  		<input class="form-check-input" type="radio" value='0' name="comment" id="com-yes" <?php if($dat['allow_comment']==0){ echo 'checked';}?>>
 		 <label class="form-check-label" for="com-yes">
    	Yes
 		 </label>
		</div>
		<div class="form-check">
		  <input class="form-check-input" type="radio" value='1' name="comment" id="com-NO" <?php if($dat['allow_comment']==1){ echo 'checked';}?>>
		  <label class="form-check-label" for="com-NO">
		    NO
		  </label>
		</div>


		<label class="col-sm-2 control-label"> Allow ad</label>
			<div class="form-check">
  		<input class="form-check-input" type="radio" value='0' name="ads" id="ad-yes" <?php if($dat['allow_ads']==0){ echo 'checked';}?>>
 		 <label class="form-check-label" for="ad-yes">
    	Yes
 		 </label>
		</div>
		<div class="form-check">
		  <input class="form-check-input" type="radio" value='1' name="ads" id="ad-NO" <?php if($dat['allow_ads']==1){ echo 'checked';}?> >
		  <label class="form-check-label" for="ad-NO">
		    NO
		  </label>
		</div>
		<div class="mb-3 mt-3 ">
			<div class="col-sm-offset col-sm-100 ">
			<button type="submit" class="btn btn-primary btn-lg form-control">Edit Category</button>
			</div>
			</div>
	</form>
		<?php
	}
		else{
			$msg="<div class='alert alert-danger'> can not find this category Id to edit</div>";
			redirectMassag($msg ,'back' ,$sec =3);
		}
	}





	elseif($do=='Update'){
		if($_SERVER['REQUEST_METHOD']=="POST"){
		$ID=$_POST['catid'];
		$catname=$_POST['Category_Name'];
		$catdescrip=$_POST['description'];
		$order=$_POST['ordering'];
		$vidible=$_POST['visibilty'];
		$allow_comme=$_POST['comment'];
		$allow_ads=$_POST['ads'];

		$stmt=$db->prepare("UPDATE categories SET Name= ? ,Description= ?, Ordering= ?, visibilty=?, allow_comment=?, allow_ads=? WHERE catID=?");
		$stmt->execute(array($catname,$catdescrip,$order,$vidible,$allow_comme,$allow_ads,$ID));
		$msg="<div class='alert alert-success'> Done" . $stmt->rowCount() . "Updating  </div>";
			redirectMassag($msg ,'back' ,$sec =3);
}
else{
		$msg="<div class='alert alert-danger'> can enter to this page without press Edit category </div>";
			redirectMassag($msg ,'back' ,$sec =3);
}

	}

	elseif($do=='delete'){

		if(isset($_GET['catid'])&&is_numeric($_GET['catid'])){
			$idcat=$_GET['catid'];

			$chech=checkitem('catID', 'Categories', $idcat);
			if($chech>0){

			$stmt=$db->prepare('DELETE FROM categories WHERE catID=?');

			$stmt->execute(array($idcat));

			$msg="<div class='alert alert-success'> delete successfuly   " . $stmt->rowCount() ."   category </div>";
			redirectMassag($msg,'back');
		}
			else{
				$msg="<div class='alert alert-danger'> Not found this category</div>";
			redirectMassag($msg,'back');
		}
			}

		
		else{
			$msg="<div class='alert alert-danger'> can not inside here directly without click delete</div>";
			redirectMassag($msg,'back');
		}

	}
		else
	{
		$msg="<div class='alert alert-danger'> this page not found we will redirect you to dashboard</div>";
		redirectMassag($msg,'back');
	}



}//end of isset($_session[])

else{

	 
	header('Location: index.php');

	exit();
};

	include $tbl . "footer.php";
?>