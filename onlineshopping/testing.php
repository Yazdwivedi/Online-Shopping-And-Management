<?php
require "db/connect.php";

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
	$result=$conn->query("insert into item(title,description,image,quantity,type,discount,price) values('{$name}','{$des}','{$image}','{$q}','{$t}','{$d}','{$p}')");
	if(move_uploaded_file($tmp_name,$target.$image))
		header("Location:testing.php");
	else{
		echo "Failed to upload";
	}
	unset($_POST);
} ?>


<form method="post" enctype="multipart/form-data">
            <label>Item Name</label>
            <input class="form-control" type="text" name="name" placeholder="Name">
            <label>Description</label>
            <textarea class="form-control" name="des" rows="8" cols="50"></textarea>
			<label>Image</label>
			<input type="file" name="image">
            <label>Quantity</label>
            <select class="form-control" name="q">
              <option selected disabled hidden>Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
			<label>Price</label>
			<input type="number" class="form-control" name="p">
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
		  <?php
		  
		  $result=$conn->query("select * from item");
		  $row=$result->fetch_object();
		 echo "<img src='upload/".$row->image."' >";
		  
		  ?>