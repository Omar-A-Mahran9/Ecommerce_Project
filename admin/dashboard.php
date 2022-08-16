<?php
ob_start();//output Buffering start

session_start();
if(isset($_SESSION['USERNAME'])){

	$title_page="Dashboard";

	include "ini.php";





?>
<div class="container home-stats">
<h1>Dashboard</h1>

<div class='row text-center'>
	
	<div class='col-md-3'>
		<a href="members.php">
		<div class='stat st-members'>
			<i class='fa fa-users'></i>
			<div class='info'>Total Members
			</div>
			<span><?php echo countOfMembers('UserID','users')?></span>
		</div>
		</a>
	</div>
	
	<div class='col-md-3'>
		<a href='members.php?do=Manage&Page=Pending'>
		<div class='stat st-pendingM'><i class='fa fa-user-plus'></i>
			<div class='info'>Pending Members </div>
			<span><?php echo checkitem('RegStatus', "users", 1)?>
					</span>
		</div>
		</a>
		
	</div>
	<div class='col-md-3'>
		<a href='item.php'>
		<div class='stat st-items'><i class='fa fa-tag'></i>
			<div class='info'>Total items </div>
			<span><?php echo countOfMembers('itemID','items')?></span>
		</div>
	</a>
		
	</div>
	<div class='col-md-3 '>
		<a href='comments.php'>
		<div class='stat st-comments'><i class='fa fa-comments'></i>
			<div class='info'>Total comments </div>
			<span><?php echo countOfMembers('cid','comments')?></span>
		</div>
		</a>
	</div>
	
</div>
</div>



<div class='container latest'>
	<div class="row">
		<div class="col-sm-6">
			<div class="card ">
				<div class="card-header" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
					<?php $last=5;
						  $latest=getLatext('*','users','UserID',$last,'WHERE GroupID!=1 '); ?>
					<i class="fa fa-users"> </i> Latest  <?php echo "  ". $last; ?> Registred User
					<i class="fa fa-plus float-end"></i>				</div>
				<div class="card-body collapse" id="collapseExample">
					<ul class='list-unstyled Latest-user'>
					<?php
						if(!empty($latest)){
						foreach ($latest as $last ) {
							echo "<li>" .  $last["Username"] .	"<a href='members.php?do=edit&userid= ". $last['UserID']."'> <span class='btn btn-success float-end'><i class='fa fa-edit'></i> Edit</span></li></a>";
						}
}
else{
	echo "There is No Record To show ";
}
					?>
					</ul>
				</div>
				
			</div>
		</div>
		<div class="col-sm-6">
			<div class="card ">
				<div class="card-header" data-bs-toggle="collapse" href="#collapeExample" role="button" >
						<?php $last=5;
						  $latest=getLatext('*','items','itemID',$last); ?>
					<i class="fa fa-users"> </i> Latest  <?php echo "  ". $last; ?> items
				</div>
				<div class="card-body collapse" id="collapeExample">
					<ul class='list-unstyled Latest-user'>
					<?php
								if(!empty($latest)){													
						foreach ($latest as $last ) {
							echo "<li>" .  $last["Name"] .	
								"<div class='float-end'>" .			
								"<a href='item.php?do=edit&IDItem= ". $last['itemID']."'> <span class='btn btn-sm btn-success '><i class='fa fa-edit'></i> Edit</span></a>" ."  ";
							echo"<a href='item.php?do=delete&iditem=".$last['itemID']."' > <span class='btn btn-sm btn-danger confirm '><i class='fa fa-close'></i> Delete</span></a>"."  "; 
							  	if($last['approve']==0){											 
								echo "<a href='item.php?do=Aproove&iditem=".$last['itemID']."'> <span class='btn btn-sm btn-info activate '><i class='fa fa-check'></i> Approve</span></a>" ;
									}
									
			 echo "</div> </li>";
			  
							
							 
						}
}
else{
	echo "Also empty records Sorry";
}
					?>
					</ul>
				</div>
				
			</div>
		</div>
	</div>
</div>

<?php



?>






<div class="container mt-5">

	<?php

	$stmt=$db->prepare('SELECT comments.*, users.Username AS MemberName, items.Name AS ItemName FROM comments 
			INNER JOIN users ON comments.user_id = users.UserID 
			INNER JOIN items ON comments.itme_id = items.itemID ORDER BY cid DESC LIMIT 6');
		$stmt->execute();
		$row=$stmt->fetchAll();

		?>

            <div class="row  d-flex ">

                <div class="col-sm-6">

                	<div class="card ">
                		<div class="card-header">


                    <div class=" headings d-flex justify-content-between align-items-center mb-3">
                        <h5>Latest comments(6)</h5>

                        <div class="buttons">

                            <span class="badge bg-white align-items-center">

                            	 <div class="text-primary"> Show Not approve Comment </div>
                                
                                <div class="form-check form-switch align-items-center float-end">
                                  <input class="form-check-input" type="checkbox" id="CHeck" onclick="check()">                             
                                </div>
                            </span>
                            
                        </div>
                        
                    </div>




                    	<?php
                    	if(!empty($row)){
			foreach($row as $rrw){

				?>

                    <div class="card p-3"  <?php if($rrw['statue']==1){echo  "style='display:block;' id='text'";}?>>

                        <div class="d-flex justify-content-between align-items-center">

                      <div class="user d-flex flex-row align-items-center">
                      	<a href="members.php?do=edit&userid=<?php echo $rrw['user_id']?>">
                        <img src="https://i.imgur.com/hczKIze.jpg" width="30" class="user-img rounded-circle mr-2">
                        <span><small class="font-weight-bold text-primary"><strong><?php echo $rrw['MemberName'];?></strong></small><strong> <small class="font-weight-bold"> <?php echo $rrw['comment'];?></small></strong></span>
                          </a>
                      </div>


                      <small><?php echo $rrw['date']?></small>

                      </div>


                      <div class="action d-flex justify-content-between mt-2 align-items-center">

                        <div class="reply px-4">
                            <a href="comments.php?do=edit&comid=<?php echo $rrw['cid']?>" ><i class='fa fa-edit'> </i> <small>Edit</small></a>
                            <span class="bi bi-dot"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
  <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
</svg> </span>
                            <small>Reply</small>
                            <span class="bi bi-dot"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
  <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
</svg> </span>
                            <a href="comments.php?do=delete&comid=<?php echo $rrw['cid']?>"><i class='fa fa-close'> </i>  <small>Delete</small></a>
                           
                        </div>

                        <div class="icons align-items-center">

                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-check-circle-o check-icon"></i>
                            
                        </div>
                          
                      </div>


                        
                    </div>
<?php
}
}
else{
	echo " No comments Until Now";
}
?>



















        


                    
                </div>
             </div>
          </div>
                
            </div>
            
        </div>






<?php
   //end dashboard page

	include $tbl . "footer.php";

} 
else{
	echo'you are Not authorized to log in here';
	header('Location: index.php');
	exit();
}
	ob_end_flush();
?>

