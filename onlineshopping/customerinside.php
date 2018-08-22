<?php
require "db/connect.php";
session_start();

$disp=0;
if(isset($_POST["logout"])){
	session_destroy();
	unset($_SESSION["id"]);
	unset($_SESSION["itemid"]);
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
if(isset($_POST["place"])){
	$id=$_SESSION["itemid"];
	$name=trim($_POST["name"]);
	$num=trim($_POST["num"]);
	$address=$_POST["address"];
	$q=trim($_POST["q"]);
	$landmark=trim($_POST["landmark"]);
	$city=trim($_POST["city"]);
	$state=trim($_POST["state"]);
	$pin=trim($_POST["pin"]);
	$op=$conn->query("select title,quantity,price,discount from item where id='{$id}'");
	$r=$op->fetch_object();
	if($r->quantity>=$q){
		
		$result=$conn->prepare("insert into info(name,number,quantity,address,landmark,city,state,pincode,i_id) values(?,?,?,?,?,?,?,?,?)");
		$result->bind_param("siissssii",$name,$num,$q,$address,$landmark,$city,$state,$pin,$id);
		$result->execute();
		$result->close();
		$temp=$r->quantity-$q;
		$res=$conn->query("update item set quantity='{$temp}',c_id={$_SESSION["id"]} where id={$_SESSION["itemid"]}");
		$x=$conn->query("delete from bought");
		$item=$r->title;
		$price=$r->price;
		$discount=$r->discount;
		$x=$conn->prepare("insert into bought(item,quantity,price,discount,c_id) values(?,?,?,?,?)");
		$x->bind_param("siiii",$item,$q,$price,$discount,$_SESSION["id"]);
		$x->execute();
		$x->close();
		$y=$conn->query("insert into finallist(title,quantity,c_id,i_id) values('{$item}','{$q}',{$_SESSION["id"]},{$_SESSION["itemid"]})");
		header("Location:customerinvoice.php");
		die();

	}
	else{
		$disp=1;
	}
}
if(isset($_POST["cart"])){
	$title=$_POST["title"];
	$quantity=0;
	$price=$_POST["price"];
	$result=$conn->query("insert into cart(item,quantity,price,c_id,i_id) values('{$title}','{$quantity}','{$price}',{$_SESSION["id"]},{$_SESSION["itemid"]})");
	header("Location:customercart.php");
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
    .left{

    }
    .right{

    }
    .pos{
      margin-top:4%;
    }
    .h{
      height:100vh;
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
    <div class="row btop" style="margin-top:5%;">
		  <?php 
		$output=$conn->query("select * from item where id={$_SESSION["itemid"]}");
		$rows=$output->fetch_object();
		
	  ?>
      <div class="col-md-2">
        <?php echo"<img src='upload/".$rows->image."' style='width:100%;height:26vh;' alt='Item'>"?>
      </div>
      <div class="col-md-10">
        <h4><?php echo$rows->title;?></h4>
        <h5>Rating:<?php echo$rows->rating;?></h5>
        <h6>Price:<?php echo$rows->price?></h6>
        <p><?php echo$rows->description?></p>
        <button type="button" class="btn btn-primary" name="button" data-toggle="modal" data-target="#buy">Buy</button>
		<form method="post">
		<input type="hidden" name="title" value="<?php echo$rows->title;?>">
		<input type="hidden" name="quantity" value="<?php echo$rows->quantity;?>">
		<input type="hidden" name="price" value="<?php echo$rows->price;?>">
		<button style="margin-top:1%" type="submit" class="btn btn-success" name="cart">Add to cart</button><br>
        </form>
		<h5 style="margin-top:3%;">Reviews:</h5>
        
		<ol>
		<?php
		$out=$conn->query("select * from reviews inner join item on item.id=reviews.i_id where item.id={$_SESSION["itemid"]}");
		while($o=$out->fetch_object())
		{
		?>
        <li><h6><?php echo$o->head;?></h6>
        <p><?php echo$o->review;?></p></li>
				<?php } 
		?>
        </ol>

      </div>

    </div>

    <div id="buy" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-body">
	  	<?php
		  $result=$conn->query("select * from cusinfo where c_id={$_SESSION["id"]}");
		  $row=$result->fetch_object();
		  if($result->num_rows)
		  {
		  ?>
        <form class="" method="post">
          <label>Name</label>
          <input class="form-control" type="text" name="name" placeholder="Name">
          <label>Phone number</label>
          <input class="form-control" type="text" name="num" placeholder="Number">
          <label for="">Quantity</label>
          <select class="form-control" name="q">
            <option selected disabled hidden>Choose</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>

         
          <textarea style="display:none;" class="form-control" name="address" rows="8" cols="50"><?php echo$row->address;?></textarea>
      
          <input class="form-control" type="hidden" name="landmark" value="<?php echo$row->landmark;?>">
         
          <input class="form-control" type="hidden" name="city" value="<?php echo$row->city?>">
        
          <input class="form-control" type="hidden" name="state" value="<?php echo$row->state?>">
         
          <input class="form-control" type="hidden" name="pin" value="<?php echo$row->pincode?>">
          <button type="submit" class="btn btn-primary" name="place" style="margin-top:2%;">Place Order</button>
        </form>
		  <?php } 
		  else{
			  ?>
			  <h5>Give your Address First</h5>
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
		  <?php } ?>
		  
        <button type="button" name="button" data-dismiss="modal" style="margin-top:2%;margin-left:0%;">Cancel</button>
      </div>



    </div>
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
	var y=$("#check").text();
	if(y=="No")
		alert("Out of Stock");
})
</script>
  </body>
</html>
