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
		$result=$conn->prepare("insert into seller(fname,lname,email,password) values(?,?,?,?)");
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
	$result=$conn->prepare("select id from seller where email=? and password=?");
	$result->bind_param("ss",$email,$pass);
	$result->execute();
	$result->bind_result($id);
	if($result->fetch()){
		$_SESSION["id"]=$id;
		$log=1;
		header("Location:adminmain.php");
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
      background-position: top;
      display:none;
    }
    .first{
      background-image: url("img/dawn-1840298_1920.jpg");
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      width:100%;
      height:50vh;
      margin-top:6%;
      color:white;
      padding-top: 10%;
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
      margin-top: 6%;
    }
    table{
      margin-left: 25%;
      width:50%;
    }
    thead{
      font-size: 150%;
      padding-bottom: 10%;
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
  </style>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="sellerportal.php">Shoppers Way</a>
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="offers.php">Offers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="items.php">Items</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="main.php">Customer Portal</a>
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
      <img class="w-100" src="img/tie-690084_1920.jpg" alt="First slide">
      <div class="carousel-caption">
        <h4>Achieve</h4>
        <p style="font-weight:bold;font-size:40px;">Success in Management requires learning as fast as the world is changing</p>
      </div>
    </div>
    <div class="carousel-item" style="height:500px;">
      <img class="w-100" src="img/paper-3213924_1920.jpg" alt="Second slide">
      <div class="carousel-caption">
        <h4>Teamwork</h4>
        <p style="font-weight:bold;font-size:40px;">When 'i' is replaced by 'we'</p>
      </div>
    </div>
    <div class="carousel-item" style="height:500px;">
      <img class="d-block w-100" src="img/dawn-1840298_1920.jpg" alt="Third slide">
      <div class="carousel-caption">
        <h4>Sucess</h4>
        <p style="font-weight:bold;font-size:40px;">Stay Positive.Work Hard.Make it Happen</p>
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

	<p id="checker" style="display:none;"><?php
	if($check==2)
		echo"1";
	if($check==1)
		echo"2";?></p>
	<p id="checks" style="display:none;"><?php
	if($log==2)
		echo"1";
	?></p>
<div>
<div class="jumbotron fbot">
  <img src="img/objects-731426_1920.jpg" style="width:100%;height:27vh;" alt="">
  <div class="text-center" style="padding:5%;">
    <h4>Items</h4>
    <p>Add an Item you want to sell.Electronics,Books,Apparel or anything that comes to mind.State the working condition as well as whether it is new or old along with the days it has been used.</p>
  </div>
</div>
<div class="jumbotron sbot">
  <img src="img/percent-1188490_1920.jpg" style="width:100%;height:27vh;" alt="">
  <div class="text-center" style="padding:5%;">
    <h4>Discount</h4>
    <p>Set the Discounts you want.Items having a higher discount sell much faster.However it reduces your profit margin.Take all of these into consideration and make the choice wisely in seeting the discount.</p>
  </div>
</div>
<div class="jumbotron tbot">
  <img src="img/archive-1850170_1920.jpg" style="width:100%;height:27vh;" alt="">
  <div class="text-center" style="padding:5%;">
    <h4>Stock</h4>
    <p>Keep a track of the Items that are unsold over long periods of time.Change their price or add discounts if they remain unsold.Care should be taken in doing so as it can lead to reduction in profit margins.</p>
  </div>
</div>
<div class="jumbotron lbot">
  <img src="img/highway-1666635_1920.jpg" style="width:100%;height:27vh;" alt="">
  <div class="text-center" style="padding:5%;">
    <h4>Transport</h4>
    <p>Information regarding where the items need to be transported will be given to you.From there on you should keep a track of where the items are being delivered.This is the most important and final step.</p>
  </div>
</div>
</div>
<div class="first">
  <div class="text-center">
  <p style="font-weight:bold;font-size:20px;">Keep looking at the positive side of a situation.Be firm in your decisions.Customer always comes first.</p>
</div>
</div>
<div class="row btop">
  <div class="col-md-10">
    <h4>Customer Support</h4>
    <p>Customer aways comes first.Keep that in mind to keep the buisness going.Address any problem that the customer faces and resolve them.</p>
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
    <h4>Cash on Delivery</h4>
    <p>As of now card payment is not available on this site and is still under development.You will be informed as soon as that is possible.</p>
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
<div id="register" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form class="form-group" method="post">
          <label for="">First Name</label>
          <input class="form-control" type="text" name="fname" placeholder="First Name">
          <label for="">Last Name</label>
          <input class="form-control" type="text" name="lname" placeholder="Last Name">
          <label for="">Email</label>
          <input class="form-control" type="email" name="email" placeholder="Email">
          <label for="">Password</label>
          <input class="form-control" type="password" name="password" placeholder="Password">
          <label for="">Retype Password</label>
          <input class="form-control" type="password" name="rpassword" placeholder="Retype Password">
          <button type="submit" class="btn btn-primary" name="submit1" style="margin-top:2%;">Register</button>
          <br>
          <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;">Cancel</button>
        </form>

      </div>

    </div>

  </div>
</div>
<div class="modal fade" role="dialog" id="login">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form class="form-group" method="post">
          <label for="">Email</label>
          <input class="form-control" type="email" name="email" placeholder="Email">
          <label for="">Password</label>
          <input class="form-control" type="password" name="password" placeholder="Password">

          <button type="submit" class="btn btn-primary" name="submit2" style="margin-top:2%;">Login</button><br>
          <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;">Cancel</button>
        </form>

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
