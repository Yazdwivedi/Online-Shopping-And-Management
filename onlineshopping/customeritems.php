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
if(isset($_POST["look"])){
	$id=$_POST["item"];
	$_SESSION["itemid"]=$id;
	header("Location:customerinside.php");
	die();
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light jk fixed-top">
  <a class="navbar-brand" href="#">Items</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#1">Electronics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#2">Books</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#3">Games</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#4">Other</a>
      </li>
    </ul>
  </div>
</nav>
    <div class="pos">
      <div id="first" class="">
   
        <h2 style="font-family: algerian, courier;margin-left:45%;">ITEMS</h2>


          <div id="1" class="right">

            <h3 style="margin-left:43.5%;">Electronics</h3>

									<?php
			$t=1;			
			$result=$conn->query("select * from item where type='{$t}'");
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
				<form method="post">
					<button type="submit" class="btn btn-primary" name="look">Look</button>
					<input type="hidden" name="item" value="<?php echo $row->id?>">
				</form>
              </div>

            </div>
          </li>
          </ul>
          </div>
			<?php }?>
          <div id="2" class="right">

            <h3 style="margin-left:45%;">Books</h3>

									<?php
			$t=2;			
			$result=$conn->query("select * from item where type='{$t}'");
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
				<form method="post">
					<button type="submit" class="btn btn-primary" name="look">Look</button>
					<input type="hidden" name="item" value="<?php echo $row->id?>">
				</form>

              </div>

            </div>
          </li>
          </ul>
          </div>
			<?php }?>

	
           <div id="3" class="right">

            <h3 style="margin-left:44.7%;">Games</h3>

									<?php
			$t=3;			
			$result=$conn->query("select * from item where type='{$t}'");
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
				<form method="post">
					<button type="submit" class="btn btn-primary" name="look">Look</button>
					<input type="hidden" name="item" value="<?php echo $row->id?>">
				</form>

              </div>

            </div>
          </li>
          </ul>
          </div>
			<?php }?>

          <div id="4" class="right">

            <h3 style="margin-left:45%;">Other</h3>

									<?php
			$t=4;			
			$result=$conn->query("select * from item where type='{$t}'");
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
				<form method="post">
					<button type="submit" class="btn btn-primary" name="look">Look</button>
					<input type="hidden" name="item" value="<?php echo $row->id?>">
				</form>
              </div>

            </div>
          </li>
          </ul>
          </div>
			<?php }?>
      </div>

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

<script>
$(document).ready(function(){
	var x=$("#checks").text();
	if(x=="No")
		alert("Old passwords must match");
})
</script>
  </body>
</html>
