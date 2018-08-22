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
  </style>
  <body data-spy="scroll" data-target=".right">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="customermain.html">Shoppers Way</a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="customeroffers.html">Offers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="customeritems.html">Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" role="button" href="#" data-toggle="modal" data-target="#update">Change Info</a>
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
        <a class="btn btn-primary nav-link" href="customercart.html" role="button">Cart</a>
      </li>
  <li style="margin-left:5%;" class="nav-item">
    <a class="btn btn-info nav-link" href="#" role="button" data-toggle="modal" data-target="#logout">Logout</a>

  </li>
</ul>
  </li>
</ul>
</div>
    </nav>
    <div id="update" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <form class=""  method="post">
                <label for="">First Name</label>
                <input class="form-control" type="text" name="" value="">
                <label for="">Last Name</label>
                <input class="form-control" type="text" name="" value="">
                <label for="">Email</label>
                <input class="form-control" type="email" name="" value="">
                <button type="submit" class="btn btn-primary" name="submit" style="margin-top:2%;">Change</button>
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
            <input class="form-control" type="text" name="" placeholder="Old Password">
            <label for="">New Password</label>
            <input class="form-control" type="text" name="" placeholder="New Password">
            <button type="submit" class="btn btn-primary" name="submit" style="margin-top:2%;">Change</button>
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
            <button type="button" class="btn btn-primary" name="button">Yes</button>
            <button type="button" name="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </form>
      </div>



    </div>
    </div>
  </div>
    <div class="row pos">
      <div id="second" class="col-md-2" style="background-color: #EAEDED;">
        <ul style="list-style-type:none;">
          <br>
          <li style="text-decoration:underline;">CATEGORIES</li><br>
          <li ><a href="#1" style="color:black;">Electronics</a></li><br>
          <li><a href="#2" style="color:black;">Books</a></li><br>
          <li><a href="#3" style="color:black;">Games</a></li><br>
          <li><a href="#4" style="color:black;">Other</a></li><br>
        </ul>

      </div>
      <div id="first" class="col-md-10">
        <div class="text-center">
        <h2 style="font-family: algerian, courier;">Items</h2>
      </div>
          <div id="1" class="right">
            <h3 style="margin-left:44%;">Electronics</h3>
            <ul style="list-style-type:none;">
              <li>
            <div class="row btop" style="margin-top:5%;">
              <div class="col-md-2">
                <img src="img/mall-918472_1920.jpg" style="width:100%;height:20vh;" alt="">
              </div>
              <div class="col-md-10">
                <h4>Money Back Gurantee</h4>
                <h5>Rating:</h5>
                <h6>Price:</h6>
                <button type="button" class="btn btn-primary" name="button">Look</button>
              </div>

            </div>
          </li>
          </ul>
          </div>
          <div id="2" class="right">
            <h3 style="margin-left:46%;">Books</h3><br>
          </div>
          <div id="3" class="right">
            <h3 style="margin-left:45.5%;">Games</h3><br>
          </div>
          <div id="4" class="right">
            <h3 style="margin-left:43%;">Other Items</h3><br>
          </div>
      </div>

    </div>
    <script type="text/javascript">
      if($("#first").height()>"576")
      {
        $("#second").css("height",$("#first").height());
      }
      else{
        $("#second").addClass("h");
      }
    </script>
  </body>
</html>
