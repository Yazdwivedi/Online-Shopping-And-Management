<?php
$servername="localhost";
$username="root";
$password="";
$db="onlineshopping";
$conn=new mysqli($servername,$username,$password,$db);

if($conn->connect_errno){
	echo"Sorry we are having problems";
	die();
}


?>