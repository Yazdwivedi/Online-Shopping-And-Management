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
    .top{
      background-image: url("img/agreement-2642610_1920.jpg");
      height:90vh;
      width:100%;
      background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
    }
    .btop{
      margin-top: 6%;
      background-color: #EAEDED;
      width:90%;
      margin-left: auto;
      margin-right: auto;
      padding-top: 3%;
      padding-bottom: 3%;
    }
    .mid{
      margin-top: 6%;
      color:white;
      background-image: url("img/mall-918472_1920.jpg");
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: top;
      background-size: cover;
      height:30vh;
      padding:6%;
	  clear:left;

    }
    .fbot{
      margin-left:6%;
      margin-top:6%;
      width:20%;
      height:40%;
      padding:0px;
      float: left;
    }
    .sbot{
      margin-left:2%;
      margin-top:6%;
      width:20%;
      height:40%;
      padding:0px;
      float: left;
    }
    .tbot{
      margin-left:2%;
      margin-top:6%;
      width:20%;
      height:40%;
      padding:0px;
      float: left;
    }
    .lbot{
      margin-left:2%;
      margin-top:6%;
      width:20%;
      height:40%;
      padding:0px;
      float: left;
    }
    .final{
      padding-top: 3%;
      background-color: #EAEDED;
      height:30vh;
      clear:left;
	  margin-top:2%;
    }
    table{
      margin-left: 25%;
      width:50%;
    }
    thead{
      font-size: 150%;
      padding-bottom: 10%;
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
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active" style="height:500px;">
      <img class="w-100" src="img/vinyl-records-945396_1920.jpg" alt="First slide">
      <div class="carousel-caption">
        <h4>Music</h4>
        <p style="font-weight:bold;font-size:40px;">From Micheal Jackson to Stevie Wonder!</p>
      </div>
    </div>
    <div class="carousel-item" style="height:500px;">
      <img class="w-100" src="img/apparel-1850804_1920.jpg" alt="Second slide">
      <div class="carousel-caption">
        <h4>Apparel</h4>
        <p style="font-weight:bold;font-size:40px;">Wide Range of Purses!</p>
      </div>
    </div>
    <div class="carousel-item" style="height:500px;">
      <img class="d-block w-100" src="img/books-1163695_1920.jpg" alt="Third slide">
      <div class="carousel-caption">
        <h4>Books</h4>
        <p style="font-weight:bold;font-size:40px;">From Demigods to Spies to Wizards we have it all!</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
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
	<p id="checker" style="display:none;"><?php
	if($check==2)
		echo"1";
	if($check==1)
		echo"2";?></p>
	<p id="checks" style="display:none;"><?php
	if($log==2)
		echo"1";
	?></p>
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
      <div class="jumbotron fbot" style="padding-bottom:2%;">
      <img src="img/625749896.jpg" style="width:100%" alt="">
      <div style="padding:5%;">
        <p>We have a wide collection of clothes,electronics,books and anything you will ever need.Be on a lookout and choose the items that that suits you the best.</p>
      </div>
      <a role="button" class="btn btn-primary" href="items.php" style="margin-left:37%;">Items</a>
    </div>
    <div class="jumbotron sbot" style="padding-bottom:2%;">
      <img src="img/ecommerce-2301933.jpg" style="width:100%" alt="">
      <div style="padding:5%;">
        <p>We ensure that you get the best offers on items that you need.Discounts range from unbelievable 75% to 25%.Look around to find exciting offers!</p>
      </div>
      <a role="button" class="btn btn-success" href="offers.php" style="margin-left:37%;">Offers</a>
    </div>
    <div class="jumbotron tbot" style="padding-bottom:2%;">
      <img src="img/online-2900303.jpg" style="width:100%" alt="">
      <div style="padding:5%;">
        <p>Wondering how to get started?Register to get access to unbelievable offers and discounts at itemss that will not be found anywhere else.Start Rolling!</p>
      </div>
      <a role="button" class="btn btn-warning" href="#" style="margin-left:36%;" data-toggle="modal" data-target="#myModal">Register</a>
    </div>
    <div class="jumbotron lbot" style="padding-bottom:2%;">
      <img src="img/holiday-shopping-1921658_1920.jpg" style="width:100%" alt="">
      <div style="padding:5%;">
        <p>Already member?What are you waiting for then?Login now and have a look at the items that we have.Get access to a plethora of offers and discouts</p>
      </div>
      <a role="button" class="btn btn-danger" href="#" style="margin-left:38%;" data-toggle="modal" data-target="#login">Login</a>
    </div>
	    <div class="mid text-center">
      <p style="font-weight:bold;font-size:20px;">An excellent customer support is our forte.Purchase items from top brands with the assurance of quality.Look around as if you are in a real Mall!.</p>
    </div>
    <div class="row btop">
      <div class="col-md-10">
        <h4>Customer Support</h4>
        <p>Having Problems?Worry not.We provide you with 24x7 support so that you can have the best experience with us.We have provided ways to contact us below.Don't hesitate to call if facing any issues.</p>
      </div>
      <div class="col-md-2">
        <img src="img/agreement-2548138_1920.jpg" style="width:100%;height:100%;border-radius:40%;" alt="">
      </div>

    </div>
    <div class="row btop" style="margin-top:2%;">
      <div class="col-md-2">
        <img src="img/Why-Card-Security-Code-Matters-In-Online-Shopping.jpg" style="width:95%;border-radius:40%;height:17vh;" alt="">
      </div>
      <div class="col-md-10">
        <h4>Money Back Gurantee</h4>
        <p>Not satisfied with our products?Return them with the press of the button.No hassles.</p>
      </div>

    </div>

    <div class="final">
      <table>
        <thead>
          <td>Contact Info</td>
          <td>Follow Us</td>
        </thead>
        <tr>
          <td>Email:yazdwivedi@gmail.com</td>
          <td>Facebook</td>
        </tr>
        <tr>
          <td>Contact no:7530003911</td>
          <td>Twitter</td>
        </tr>
        <tr>
          <td>Github:github.com/Yazdwivedi</td>
          <td>Github</td>
        </tr>
        <tr>
          <td>LinkedIn:www.linkedin.com/in/yash-dwivedi-687663135/</td>
          <td>LinkedIn</td>
        </tr>
      </table>
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
