<?php
require "db/connect.php";
session_start();
$log=0;
$check=0;
if(isset($_POST["submit1"])){
	$fname=trim($_POST["fname"]);
	$lname=trim($_POST["lname"]);
	$email=trim($_POST["email"]);
	$pass=trim($_POST["password"]);
	$rpass=trim($_POST["rpassword"]);
	if($pass===$rpass){
		$result=$conn->prepare("insert into customer(fname,lname,email,password) values(?,?,?,?)");
		$result->bind_param("ssss",$fname,$lname,$email,$pass);
		$result->execute();
		$check=1;
	}
	else{
		$check=2;
	}
}
if(isset($_POST["submit2"])){
	$email=trim($_POST["email"]);
	$pass=trim($_POST["password"]);
	$result=$conn->prepare("select id from customer where email=? and password=?");
	$result->bind_param("ss",$email,$pass);
	$result->execute();
	$result->bind_result($id);
	if($result->fetch()){
		$_SESSION["id"]=$id;
		$log=1;
		header("Location:customermain.php");
		die();
	}
	else{
		$log=2;
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
    <title>Shopperway</title>
  </head>
  <style media="screen">
    .pos{
      margin-top:8%;
    }
    .h{
      height:cover;
    }
	.temp{
		float:left;
		width:20%;
	}
	ul #menu li {
    display:inline;
}
.jk{
	margin-top:3.5%;
}
  </style>
  <body>
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="main.php">Shoppers Way</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="offers.php">Offers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="items.php">Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sellerportal.php">Seller Portal</a>
          </li>
        </ul>
</div>
<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
  <ul class="navbar-nav">
  <li class="nav-item">
    <ul class="navbar-nav">
  <li class="nav-item">
    <a class="btn btn-primary nav-link" href="#" role="button" data-toggle="modal" data-target="#myModal">Register</a>
  </li>
  <li style="margin-left:5%;" class="nav-item">
    <a class="btn btn-info nav-link" href="#" role="button" data-toggle="modal" data-target="#login">Login</a>

  </li>
</ul>
  </li>
</ul>
</div>
    </nav>

	<p id="checker" style="display:none;"><?php
	if($check==2)
		echo"1";
	if($check==1)
		echo"2";?></p>
	<p id="checks" style="display:none;"><?php
	if($log==2)
		echo"1";
	?></p>
   
   

    <nav class="navbar navbar-expand-lg navbar-light bg-light jk fixed-top">
  <a class="navbar-brand" href="#">Discounts</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#1">75% Discount</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#2">50% Discount</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#3">25% Discount</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#4">Other Offers</a>
      </li>
    </ul>
  </div>
</nav>
    <div class="pos">
      <div id="first" class="">
   
        <h2 style="font-family: algerian, courier;margin-left:45%;">OFFERS</h2>


          <div id="1" class="right">

            <h3 style="margin-left:45%;">75% OFF!</h3>

									<?php
			$t=1;			
			$result=$conn->query("select * from item where discount='{$t}'");
			while($row=$result->fetch_object())
			{
			?>
            <ul style="list-style-type:none;">

		
              <li>
            <div class="row btop" style="margin-top:5%;">
              <div class="col-md-2">
                <?php echo"<img src='upload/".$row->image."' style='width:100%;height:20vh;' alt=''>"?>
              </div>
              <div class="col-md-10">
                <h4><?php echo $row->title;?></h4>
                <h5>Rating:<?php echo$row->rating;?></h5>
                <h6>Price:<?php echo$row->price;?></h6>

              </div>

            </div>
          </li>
          </ul>
          </div>
			<?php }?>
          <div id="2" class="right">

            <h3 style="margin-left:45%;">50% OFF!</h3>

									<?php
			$t=2;			
			$result=$conn->query("select * from item where discount='{$t}'");
			while($row=$result->fetch_object())
			{
			?>
            <ul style="list-style-type:none;">

		
              <li>
            <div class="row btop" style="margin-top:5%;">
              <div class="col-md-2">
                <?php echo"<img src='upload/".$row->image."' style='width:100%;height:20vh;' alt=''>"?>
              </div>
              <div class="col-md-10">
                <h4><?php echo $row->title?></h4>
                <h5>Rating:<?php echo$row->rating;?></h5>
                <h6>Price:<?php echo$row->price;?></h6>


              </div>

            </div>
          </li>
          </ul>
          </div>
			<?php }?>

	
           <div id="3" class="right">

            <h3 style="margin-left:45%;">25% OFF!</h3>

									<?php
			$t=3;			
			$result=$conn->query("select * from item where discount='{$t}'");
			while($row=$result->fetch_object())
			{
			?>
            <ul style="list-style-type:none;">

		
              <li>
            <div class="row btop" style="margin-top:5%;">
              <div class="col-md-2">
                <?php echo"<img src='upload/".$row->image."' style='width:100%;height:20vh;' alt=''>"?>
              </div>
              <div class="col-md-10">
                <h4><?php echo $row->title?></h4>
                <h5>Rating:<?php echo$row->rating;?></h5>
                <h6>Price:<?php echo$row->price;?></h6>


              </div>

            </div>
          </li>
          </ul>
          </div>
			<?php }?>

          <div id="4" class="right">

            <h3 style="margin-left:46%;">Other</h3>

									<?php
			$t=4;			
			$result=$conn->query("select * from item where discount='{$t}'");
			while($row=$result->fetch_object())
			{
			?>
            <ul style="list-style-type:none;">

		
              <li>
            <div class="row btop" style="margin-top:5%;">
              <div class="col-md-2">
                <?php echo"<img src='upload/".$row->image."' style='width:100%;height:20vh;' alt=''>"?>
              </div>
              <div class="col-md-10">
                <h4><?php echo $row->title?></h4>
                <h5>Rating:<?php echo$row->rating;?></h5>
                <h6>Price:<?php echo$row->price;?></h6>

              </div>

            </div>
          </li>
          </ul>
          </div>
			<?php }?>
      </div>

    </div>

    <div id="login" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form class="" method="post">
            <label>Email</label>
            <input class="form-control" type="email" name="email" placeholder="Email">
            <label>Password</label>
            <input class="form-control" type="password" name="password" placeholder="Password">
            <button type="submit" class="btn btn-primary" name="submit2" style="margin-top:2%;">Login</button>
          </form>
          <button type="button" name="butto" data-dismiss="modal" style="margin-top:2%;">Cancel</button>

        </div>

      </div>

    </div>
  </div>
      <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-body">
        <form class="" method="post">
          <label>First Name</label>
          <input class="form-control" type="text" name="fname" placeholder="First Name">
          <label>Last Name</label>
          <input class="form-control" type="text" name="lname" placeholder="Last Name">
          <label>Email</label>
          <input class="form-control" type="email" name="email" placeholder="Email">
          <label>Password</label>
          <input class="form-control" type="password" name="password" placeholder="Password">
          <label>Retype Password</label>
          <input class="form-control" type="password" name="rpassword" placeholder="Retype Password">
          <button type="submit" class="btn btn-primary" name="submit1" style="margin-top:2%;">Register</button>
        </form>
        <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;margin-left:2%;">Cancel</button>
      </div>



    </div>
    </div>
  </div>
<script>
	$(document).ready(function(){
	
		var x=$("#checker").text();
	
		if(x==1)
			alert("The Passwords must match");
		if(x==2){
			alert("Registered Successfully");
		}		
		var y=$("#checks").text();
		if(y==1){
			alert("Wrong Email or Password");

		}

	})
</script>
  </body>
</html>
