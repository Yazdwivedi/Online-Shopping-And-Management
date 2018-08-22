<?php
require "db/connect.php";
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST["logout"])){
	session_destroy();
	unset($_SESSION["id"]);
	unset($_SESSION["itemid"]);
	header("Location:sellerportal.php");
	die();
}
if(isset($_POST["change"])){
	$fname=trim($_POST["fname"]);
	$lname=trim($_POST["lname"]);
	$email=trim($_POST["email"]);
	$result=$conn->prepare("update seller set fname=?,lname=?,email=? where id=?");
	$result->bind_param("sssi",$fname,$lname,$email,$_SESSION["id"]);
	$result->execute();
	$result->close();
}
if(isset($_POST["password"])){
	$pass=$_POST["pass"];
	$npass=$_POST["npass"];
	$result=$conn->query("select password from seller where id={$_SESSION["id"]}");
	$row=$result->fetch_object();
	if($pass===$row->password){
		$update=$conn->prepare("update seller set password=? where id=?");
		$update->bind_param("si",$npass,$_SESSION["id"]);
		$update->execute();
		$update->close();
	}
	else{
		$checker=1;
	}
}

if(isset($_POST["submit"])){
	$name=$_POST["name"];
	$des=$_POST["des"];
	$q=$_POST["q"];
	$t=$_POST["t"];
	$d=$_POST["d"];
	$p=$_POST["p"];
	$image=$_FILES["image"]["name"];
	$tmp_name = $_FILES['image']['tmp_name'];
	$target="upload/";
	$result=$conn->query("insert into item(title,description,image,quantity,type,discount,price,a_id,int_quantity) values('{$name}','{$des}','{$image}','{$q}','{$t}','{$d}','{$p}',{$_SESSION["id"]},'{$q}')");
	if(move_uploaded_file($tmp_name,$target.$image))
		header("Location:adminmain.php");
	else{
		echo "Failed to upload";
	}
	
} 
if(isset($_POST["ups"])){
	$_SESSION["itemid"]=$_POST["id"];
	header("Location:adminreview.php");
	die();
}
if(isset($_POST["img"])){
	$image=$_FILES["image"]["name"];
	$tmp_name=$_FILES["image"]["tmp_name"];
	$target="upload/";
	$result=$conn->query("update item set image='{$image}' where id={$_POST["id"]}");
	if(move_uploaded_file($tmp_name,$target.$image)){
		header("Location:adminitemstatus.php");
		die();
	}
	else{
		echo"Failed";
	}
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopperway</title>
  </head>
  <style media="screen">
  table{
    width:95%;
    margin-left:15%;
  }
  .top{
    margin-left: auto;
    margin-right: auto;
    width:95%;
    margin-top: 5%;

  }
  .right{
    width:10%;

  }
  .left{
    width:15%;
  }
  .col{
	  width:15%;
  }
 td{
	 
	padding-top:2%;
}

  </style>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="adminmain.php">Shoppers Way</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#" role="button" data-toggle="modal" data-target="#item">Add Item</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="adminitemstatus.php">Status</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="adminreviewlist.php">Read Reviews</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admintransport.php">Transport Info</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" role="button" href="#" data-toggle="modal" data-target="#update">Change Info</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" role="button" href="#" data-toggle="modal" data-target="#password">Change Password</a>
          </li>
        </ul>
</div>

<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
  <ul class="navbar-nav">
  <li class="nav-item">
    <ul class="navbar-nav">
  <li style="margin-left:5%;" class="nav-item">
    <a class="btn btn-info nav-link" href="#" role="button" data-toggle="modal" data-target="#logout">Logout</a>

  </li>
</ul>
  </li>
</ul>
</div>
    </nav>
	<p id="checks" style="display:none;"><?php
	if($checker){
		echo"No";
	}
	?></p>
  <div id="update" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
						<?php
			$result=$conn->query("select fname,lname,email from seller where id={$_SESSION['id']}");
			$row=$result->fetch_object();
			?>
              <form class=""  method="post">
                <label for="">First Name</label>
                <input class="form-control" type="text" name="fname" value="<?php echo$row->fname;?>">
                <label for="">Last Name</label>
                <input class="form-control" type="text" name="lname" value="<?php echo$row->lname;?>">
                <label for="">Email</label>
                <input class="form-control" type="email" name="email" value="<?php echo$row->email;?>">
                <button type="submit" class="btn btn-primary" name="change" style="margin-top:2%;">Change</button>
              </form>
              <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;margin-left:2%;">Cancel</button>


            </div>

          </div>

        </div>
    </div>
    <div id="password" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <form class="" action="" method="post">
            <label for="">Old Password</label>
            <input class="form-control" type="password" name="pass" placeholder="Old Password">
            <label for="">New Password</label>
            <input class="form-control" type="password" name="npass" placeholder="New Password">
            <button type="submit" class="btn btn-primary" name="password" style="margin-top:2%;">Change</button>
          </form>
          <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;margin-left:2%;">Cancel</button>
          </div>


        </div>
      </div>
    </div>
    <div id="logout" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-body">
        <h3>Are you sure?</h3>
        <form method="post">
            <button type="submit" class="btn btn-primary" name="logout">Yes</button>
            <button type="button" name="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </form>
      </div>



    </div>
    </div>
  </div>
  <div id="item" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
            <label>Item Name</label>
            <input class="form-control" type="text" name="name" placeholder="Name">
            <label>Description</label>
            <textarea class="form-control" name="des" rows="8" cols="50"></textarea>
			<label>Image</label><br>
			<input type="file" name="image"><br>
            <label>Quantity</label>
            <select class="form-control" name="q">
              <option selected disabled hidden>Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
			<label>Price</label>
			<input type="number" class="form-control" name="p" placeholder="Price">
            <label>Type</label>
            <select class="form-control" name="t">
              <option selected disabled hidden>Choose</option>
              <option value="1">Electronics</option>
              <option value="2">Books</option>
              <option value="3">Games</option>
              <option value="4">Other</option>
            </select>
            <label>Discount</label>
            <select class="form-control" name="d">
              <option selected disabled hidden>Choose</option>
              <option value="1">75%</option>
              <option value="2">50%</option>
              <option value="3">25%</option>
              <option value="4">Other</option>
            </select>
            <button type="submit" class="btn btn-primary" name="submit" style="margin-top:2%;">Register</button>
          </form>
          <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;margin-left:2%;">Cancel</button>

        </div>

      </div>
    </div>
  </div>
  <div class="jumbotron top">
      <table>
        <tr>
          <td class="col"><b>Item</b></td>
        </tr>
		<?php  
		
		$result=$conn->query("select item.id,item.title from seller inner join item on item.a_id=seller.id where seller.id={$_SESSION["id"]}");

		while($row=$result->fetch_object())
		{	
		?>
        <tr>
          <td class="col"><?php echo$row->title;?></td>
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" value="<?php echo$row->id?>" name="id">
				<td class="right"><button type="submit" class="btn btn-primary" name="ups">Read</button></td>
			</form>
        </tr>
		<?php }?>
      </table>
  </div>
    <script>
$(document).ready(function(){
	var x=$("#checks").text();
	if(x=="No")
		alert("Old passwords must match");
})
</script>
  </body>
</html>
