<?php
require "db/connect.php";
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$disp=0;
if(isset($_POST["logout"])){
	session_destroy();
	unset($_SESSION["id"]);
	unset($_SESSION["itemid"]);
	header("Location:main.php");
	die();
}
if(isset($_POST["change"])){
	$fname=trim($_POST["fname"]);
	$lname=trim($_POST["lname"]);
	$email=trim($_POST["email"]);
	$result=$conn->prepare("update customer set fname=?,lname=?,email=? where id=?");
	$result->bind_param("sssi",$fname,$lname,$email,$_SESSION["id"]);
	$result->execute();
	$result->close();
}
if(isset($_POST["password"])){
	$pass=$_POST["pass"];
	$npass=$_POST["npass"];
	$result=$conn->query("select password from customer where id={$_SESSION["id"]}");
	$row=$result->fetch_object();
	if($pass===$row->password){
		$update=$conn->prepare("update customer set password=? where id=?");
		$update->bind_param("si",$npass,$_SESSION["id"]);
		$update->execute();
		$update->close();
	}
	else{
		$checker=1;
	}
}
if(isset($_POST["place1"])){
	$address=$_POST["address"];
	$landmark=$_POST["landmark"];
	$city=$_POST["city"];
	$state=$_POST["state"];
	$pincode=$_POST["pincode"];
	$result=$conn->query("update cusinfo set address='{$address}',landmark='{$landmark}',city='{$city}',state='{$state}',pincode='{$pincode}' where c_id={$_SESSION["id"]}");
	
}
if(isset($_POST["place2"])){
	$address=$_POST["address"];
	$landmark=$_POST["landmark"];
	$city=$_POST["city"];
	$state=$_POST["state"];
	$pincode=$_POST["pincode"];
	$result=$conn->query("insert into cusinfo(address,landmark,city,state,pincode,c_id) values('{$address}','{$landmark}','{$city}','{$state}','{$pincode}',{$_SESSION["id"]})");
	
}
if(isset($_POST["submit"])){
	$q=$_POST["q"];
	$result=$conn->query("update cart set quantity='{$q}' where id={$_POST["id"]}");
}
if(isset($_POST["subrev"])){
	
	$title=trim($_POST["title"]);
	$rating=trim($_POST["rating"]);
	$review=$_POST["review"];
	$w=$conn->query("select * from reviews");
	if($w->num_rows){
	$result=$conn->query("insert into reviews(head,review,i_id,c_id) values('{$title}','{$review}',{$_SESSION["itemid"]},{$_SESSION["id"]})");
	$res=$conn->query("select * from reviews inner join item on item.id=reviews.i_id where item.id={$_SESSION["itemid"]}");

	$count=0;
	while($row=$res->fetch_object())
	{
		$count=$count+1;
	}
	}
	else{
		$count=1;
		$result=$conn->query("insert into reviews(head,review,i_id,c_id) values('{$title}','{$review}',{$_SESSION["itemid"]},{$_SESSION["id"]})");
	}

	$q=$conn->query("select rating from item where id={$_SESSION["itemid"]}");
	$ro=$q->fetch_object();
	
	$temp=($ro->rating)*($count-1);
	$newrev=($temp+$rating)/($count);
	$tw=$conn->query("update item set rating='{$newrev}' where id={$_SESSION["itemid"]}");
	header("Location:customereview.php");
	die();
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
    <title>Shopperway</title>
  </head>
  <style media="screen">
    .top{
      margin-left: auto;
      margin-right: auto;
      width:90%;
      margin-top: 3%;

    }
    table{
      width:100%;
      font-size:200%;
    }
    .right{
      width:10%;

    }
    .left{
      width:30%;
    }
    .a{
      width:40%;
    }
  </style>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="customermain.php">Shoppers Way</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="customeroffers.php">Offers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="customeritems.php">Items</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="customereview.php">Rate Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" role="button" href="#" data-toggle="modal" data-target="#update">Change Info</a>
          </li>
		  				  <li class="nav-item">
            <a class="nav-link" role="button" href="#" data-toggle="modal" data-target="#address">Set Address</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" role="button" href="adminitemstatus.html" data-toggle="modal" data-target="#password">Change Password</a>
          </li>
        </ul>
</div>
<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
  <ul class="navbar-nav">
  <li class="nav-item">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="btn btn-primary nav-link" href="customercart.php" role="button">Cart</a>
      </li>
  <li style="margin-left:5%;" class="nav-item">
    <a class="btn btn-info nav-link" href="#" role="button" data-toggle="modal" data-target="#logout">Logout</a>

  </li>
</ul>
  </li>
</ul>
</div>
    </nav>
  <body data-spy="scroll" data-target=".right">

	<p id="checks" style="display:none;"><?php
	if($checker){
		echo"No";
	}
	?></p>
	  	<p id="check" style="display:none;"><?php
	if($disp){
		echo"No";
	}
	?></p>
    <div id="update" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
						<?php
			$result=$conn->query("select fname,lname,email from customer where id={$_SESSION['id']}");
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
        <form class="" method="post">
            <button type="submit" class="btn btn-primary" name="logout">Yes</button>
            <button type="button" name="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </form>
      </div>



    </div>
    </div>
  </div>
  <div class="jumbotron top">
    <h3 style="margin-left:40%;">Write The Review</h3><br>
    <form method="post">
				
					<label>Title</label>
					<input class="form-control" type="text" name="title" placeholder="Title">
					<label>Rating</label>
					<select class="form-control" name="rating">
						<option selected hidden disabled>Choose</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						
						
					</select>
					<label>Review</label>
					<textarea class="form-control" name="review" rows="8" cols="50"></textarea>
					<button style="margin-top:2%;" type="submit" name="subrev" class="btn btn-primary">Submit</button>
				</form>
    <div class="text-center" style="margin-top:5%;">
    </div>
  </div>
  <?php 

  ?>
  		<div id="address" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-body">
		<?php 
		$re=$conn->query("select * from cusinfo where c_id={$_SESSION["id"]}");

		if($re->num_rows)
		{
			$ro=$re->fetch_object();
		?>
        <form class="" method="post">
          <label>Address</label>
          <textarea class="form-control" name="address" rows="8" cols="50" ><?php echo$ro->address;?></textarea>
          <label>Landmark</label>
          <input class="form-control" type="text" name="landmark" value="<?php echo$ro->landmark;?>">
          <label>City</label>
          <input class="form-control" type="text" name="city" placeholder="City" value="<?php echo$ro->city;?>">
          <label>State</label>
          <input class="form-control" type="text" name="state" placeholder="State" value="<?php echo$ro->state;?>">
          <label>Pin Code</label>
          <input class="form-control" type="text" name="pincode" placeholder="Pincode" value="<?php echo$ro->pincode;?>">
          <button type="submit" class="btn btn-primary" name="place1" style="margin-top:2%;">Set</button>
        </form>
		<?php }
		else{
			?>
		<form class="" method="post">
          <label>Address</label>
          <textarea class="form-control" name="address" rows="8" cols="50" value="<??>"></textarea>
          <label>Landmark</label>
          <input class="form-control" type="text" name="landmark" placeholder="Landmark">
          <label>City</label>
          <input class="form-control" type="text" name="city" placeholder="City">
          <label>State</label>
          <input class="form-control" type="text" name="state" placeholder="State">
          <label>Pin Code</label>
          <input class="form-control" type="text" name="pincode" placeholder="Pincode">
          <button type="submit" class="btn btn-primary" name="place2" style="margin-top:2%;">Set</button>
        </form>
		<?php }
		?>
        <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;margin-left:0%;">Cancel</button>
      </div>



    </div>
    </div>
  </div>
  

      <script>
$(document).ready(function(){
	var x=$("#checks").text();
	if(x=="No")
		alert("Old passwords must match");
	var y=$("#check").text();
	if(y=="No")
		alert("Out of Stock");
})
</script>
  </body>
</html>
