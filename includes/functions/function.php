<?php
 

 function getgetcat(){
    global $db;

    $stmt=$db->prepare(" SELECT * FROM categories ORDER BY catID DESC ");
    $stmt->execute();
    $row=$stmt->fetchAll();
    return $row;

}

 function PrintTitle(){

     global $title_page;
     
    	if(isset($title_page)){

     		echo $title_page;
     	}
     	else{
     		echo 'Default';
     	}


     }


 /* Redirect Function v2.0
 */
 function redirectMassag($msg ,$url=null ,$sec =3){
    if ($url==null){
        $url='index.php';
    }
    else{
          if(isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER']!==''){
            $url=$_SERVER['HTTP_REFERER'];    
        }
        else {
            $url='index.php';
        }
        }
        
    

    echo $msg ;
    echo "<div class= 'alert alert-primary'>You will Be Redirected to $url during $sec  Seconds.</div>";
    header("refresh:$sec;url=$url");

 }

 /*
 **check Item Function v1.0
 **function to check item database
 **$select= the Item To Select [Example: user, item, category]
 **$from= The Table to Select From [ Example:users, items,categories]
**$value=The Value Of Select[Example:osama,box,electronics]
*/
function checkitem($select, $from, $vlue){
    global $db;
    
    $stmt= $db->prepare("SELECT $select From $from Where $select =?");
    
    $stmt->execute(array($vlue));
    $count= $stmt->rowcount();
    return $count;





}


//get numbers of members
// $item= The Item To Count
// $tabele= The Table To Choose from
function countOfMembers($item,$tabele){
global $db;

$stmt=$db->prepare("SELECT COUNT($item)  FROM $tabele ");
$stmt -> execute();
//assign to variable
  $count=  $stmt->fetchColumn();
  return $count;
  }


function ccountOfMembers($item,$tabele,$value=1){
global $db;

$stmt=$db->prepare("SELECT COUNT($item)  FROM $tabele WHERE $item=?");
$stmt -> execute(array($value));
//assign to variable
  $count=  $stmt->fetchColumn();
  return $count;
  }

/*
**Get Latest Records Function v1,0
**Function To Get Latest Items From Database [Users,Item,Comments];
**
**
**
*/
function getLatext($select,$table,$order,$Limit=5,$Where=""){
    global $db;
    $stmt=$db->prepare("SELECT $select FROM $table $Where ORDER BY $order DESC LIMIT $Limit");
    $stmt->execute();
    $row=$stmt->fetchAll();
    return $row;

}

function checkUserStatus($usr){
    global $db;
    $stmt=$db->prepare("SELECT Username , RegStatus FROM users WHERE Username=? AND RegStatus=1");
    $stmt->execute(array($usr));
    $count = $stmt->rowcount();
    return $count;
}

function getitem($WHRE,$VALUE){
global $db;
$stmt=$db->prepare("SELECT * FROM items WHERE $WHRE=? ORDER BY $WHRE DESC");
$stmt->execute(array($VALUE));
$row= $stmt->fetchAll();
return $row;
}


?>