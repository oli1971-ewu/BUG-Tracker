<?php
ob_start();
if(!isset($_SESSION)) {
        session_start();
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Bug-Tracker</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  
  <link rel="stylesheet" type="text/css" href="frontpage.css">
  
  <link rel="stylesheet" type="text/css" href="custom1.css">

  <script type="text/javascript" href="custom.js"></script>
  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    

</head>
<body class="backimage">
<nav class="navbar navbar-expand-sm navbar-dark bg-info">
  <a class="navbar-brand" style="margin-right: 30px; margin-left:30px" href="#"><font face="Lucida Calligraphy">Bug-Tracker</font></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="postatask.php">Post a Bug</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="browse.php?card=0">Browse Bugs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="howitworks.html">How it works</a>
      </li>
    </ul>
	<?php
	include 'loginform.php';
    if(empty($_SESSION['uname']))
	{
		echo " <button type='button' id='loginindex' class='btn btn-light' data-toggle='modal' data-target='#exampleModalCenter1'>Log in</button>";
		 echo "<script>$(document).ready(function() { $('#loginindex').click(); }); $('#exampleModalCenter1').appendTo('body').modal('show');</script>";
		
	}else{
		if($_SESSION['user_type']!='tasker')
		{
		  echo "<p class='username'>Welcome, ".$_SESSION['uname']."</p>";
		  echo '<form action="logout.inc.php" method="post"><button type="submit" name="logout" class="btn btn-light" style="margin-left:8px;">Log out</button></form>';
		}
		else{
			echo '<script>alert("You can only post a bug if you are a logged in as a customer"); window.location.href="browse.php";</script>';
	
		}
		
	}
  ?>

  </div>
  
  
  
</nav>
	<form action="postatask.inc.php" method="post">
	<div style="margin-left: 50px; margin-top: 50px;">
		
			<h5>TITLE</h5>
			<input type="text" name="title">
      <br>
      <br>
			<h5>DESCRIPTION</h5>
			<textarea name ="desc" rows="9 " cols="70" style="padding: 13px"></textarea>
	
	</div>

<h5 style="position: fixed; top: 110px; left: 750px;">FEES</h5>
<input type="number" name="fees" style="width: 300px; position: fixed; top: 140px; left: 750px;">
  

  <div style="position: fixed; top: 190px; left: 750px"> 
	  <label><h4 >Category</h4> 
	  <input list="cat" name="category" /></label>
	  <datalist id="cat"> <option value="Web Development"> 
	  <option value="Android App Devlopment"> 
	  <option value="Software Development"> 
		  <option value="Database Solution">
		  <option value="Software Testing"> 
		  <option value="Cloud Computing"> 
	  </datalist>
  </div>

  <h4 style="position: fixed; top: 290px; left: 750px;">EMAIL</h4>
  <input type="text" name="email" style="width: 300px; position: fixed; top: 320px; left: 750px;">
  <?php
    if(!empty($_SESSION['uname']))
	{	echo"<button class='btn btn-info' style='width: 100px; position: fixed; top: 500px; left: 1000px;' name='post'>POST</button>";
	}else{
		echo "<p style='position: fixed; top: 500px; left: 1000px;color:red;font-size:150%'>login first to post !</p>";
	}
	?>
	</form>

</body>
</html>