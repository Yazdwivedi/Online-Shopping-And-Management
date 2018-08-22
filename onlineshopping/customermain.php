<?php
require "db/connect.php";
session_start();

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
      background-image: url("img/mall-918472_1920.jpg");
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
      height:50%;
      padding:0px;
      float: left;
    }
    .sbot{
      margin-left:2%;
      margin-top:6%;
      width:20%;
      height:50%;
      padding:0px;
      float: left;
    }
    .tbot{
      margin-left:2%;
      margin-top:6%;
      width:20%;
      height:50%;
      padding:0px;
      float: left;
    }
    .lbot{
      margin-left:2%;
      margin-top:6%;
      width:20%;
      height:50%;
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
            <a class="nav-link" role="button" href="#" data-toggle="modal" data-target="#password">Change Password</a>
          </li>
        </ul>
</div>
<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
  <ul class="navbar-nav">
  <li class="nav-item">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="btn btn-primary nav-link" href="customercart.php" role="button" >Cart</a>
      </li>
  <li style="margin-left:5%;" class="nav-item">
    <a class="btn btn-info nav-link" href="#" role="button" data-toggle="modal" data-target="#logout">Logout</a>

  </li>
</ul>
  </li>
</ul>
</div>
    </nav>
	<div id="place" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-body">
		<?php 
		$re=$conn->query("select * from cusinfo where id={$_SESSION["id"]}")
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
          <input class="form-control" type="text" name="pin" placeholder="Pincode">
          <button type="submit" class="btn btn-primary" name="place" style="margin-top:2%;">Place Order</button>
        </form>
        <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;margin-left:0%;">Cancel</button>
      </div>



    </div>
    </div>
  </div>
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
<div>
<div class="jumbotron fbot">
  <img src="img/guitar-1245856_1920.jpg" style="width:100%" alt="">
  <div class="text-center" style="padding:5%;">
    <h4>Music</h4>
    <p> Buy Music CD Online, Latest MP3 Songs Audio CDs, Movie Albums.Keep grooving</p>
  </div>
</div>
<div class="jumbotron sbot">
  <img src="img/people-2570596_1920.jpg" style="width:100%;height:27vh;" alt="">
  <div class="text-center" style="padding:5%;">
    <h4>Apparel</h4>
    <p>Shop for latest,trendy apparels for women, men & kids online at best prices.</p>
  </div>
</div>
<div class="jumbotron tbot">
  <img src="img/books-1617327_1920.jpg" style="width:100%;height:27vh;" alt="">
  <div class="text-center" style="padding:5%;">
    <h4>Books</h4>
    <p>Find & Buy Books Online at low prices.Shop online wide range of Books upto 75% off from top brands</p>
  </div>
</div>
<div class="jumbotron lbot">
  <img src="img/holiday-shopping-1921658_1920.jpg" style="width:100%" alt="">
  <div class="text-center" style="padding:5%;">
    <h4>And much more!</h4>
    <p>Search and ye shall find!Explore to discover a vast plethora items at the best prices.</p>
  </div>
</div>
</div>
<div class="first">
  <div class="text-center">
  <p style="font-weight:bold;font-size:20px;">An excellent customer support is our forte.Purchase items from top brands with the assurance of quality.Look around as if you are in a real Mall!.</p>
</div>
</div>
<div class="row btop">
  <div class="col-md-10">
    <h4>Customer Support</h4>
    <p>Having Problems?Worry not.We provide you with 24x7 support so that you can have the best experience with us.We have provided ways to contact us below.Don't hesitate to call if facing any issues.</p>
  </div>
  <div class="col-md-2">
	<img src="img/agreement-2548138_1920.jpg" style="width:95%;border-radius:40%;height:17vh;" alt="">
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

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	var x=$("#checks").text();
	if(x=="No")
		alert("Old passwords must match");
})
</script>
  </body>
</html>
