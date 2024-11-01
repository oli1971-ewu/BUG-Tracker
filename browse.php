<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Bug-Tracker</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="frontpage.css">
  <link rel="stylesheet" type="text/css" href="custom1.css">
  <script src="custom.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body class="backimage">
<nav class="navbar navbar-expand-sm navbar-dark fixed-top bg-info">
  <a class="navbar-brand" style="margin-right: 30px; margin-left:30px" href="#"><font face="Lucida Calligraphy">Bug-Tracker</font></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="postatask.php">Post a Bug</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="browse.php?card=0">Browse Bugs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="howitworks.html">How it works</a>
      </li>
    </ul>

    <?php
    include 'loginform.php';
    if(empty($_SESSION['uname'])) {
      echo "<button type='button' id='loginindex' class='btn btn-light' data-toggle='modal' data-target='#exampleModalCenter1'>Log in</button>";
      echo "<script>$(document).ready(function() { $('#loginindex').click(); }); $('#exampleModalCenter1').appendTo('body').modal('show');</script>";
    } else {
      echo "<p class='username'>Welcome, " . $_SESSION['uname'] . "</p>";
      echo '<form action="logout.inc.php" method="post"><button type="submit" name="logout" class="btn btn-light" style="margin-left:8px;">Log out</button></form>';
    }
    ?>
  </div>
</nav>

<div>
  <div class="sidenav">
    <a href="browse.php?card=0">All</a>
    <a href="browse.php?card=1">Web Development</a>
    <a href="browse.php?card=2">Android App Development</a>
    <a href="browse.php?card=3">Software Development</a>
    <a href="browse.php?card=4">Database Solution</a>
    <a href="browse.php?card=5">Software Testing</a>
    <a href="browse.php?card=6">Cloud Computing</a>
  </div>
</div>

<div>
<?php
include 'dbconn.php';
if(!empty($_SESSION["uname"])) {
  $uname = $_SESSION["uname"];
  $id = $_SESSION["uid"];
  $var = $_GET["card"];
  
  $sql = "SELECT * FROM tasks";
  
  if($var == 1) {
    $sql .= " WHERE Category='web development'";
  } else if($var == 2) {
    $sql .= " WHERE Category='android app development'";
  } else if($var == 3) {
    $sql .= " WHERE Category='software development'";
  } else if($var == 4) {
    $sql .= " WHERE Category='database solutions'";
  } else if($var == 5) {
    $sql .= " WHERE Category='software testing'";
  } else if($var == 6) {
    $sql .= " WHERE Category='cloud computing'";
  }
  
  $result = mysqli_query($conn, $sql);

  if($_SESSION["user_type"] == 'customer') {
    if (mysqli_num_rows($result) == 0) {
      echo "<div class='jobs'><p style='position:relative; left:300px; top:50px; font-size: 30px;'>No Bugs posted by you. Post your Bugs now!</p></div>";
    } else {
      echo "<div class='jobs'><p style='position:relative; top:60px; font-size: 30px;'>The Bugs posted by you are -</p></div>";
      while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='jobs'>";
        echo "<h3>TITLE - " . $row["title"] . "</h3>";
        echo "<h5>Category - " . $row["category"] . "</h5>";
        echo "<p>DESCRIPTION - " . $row["description"] . " Fees - " . $row["price"] . "</p>";
        echo "<p>Bug id - " . $row["taskid"] . "</p>";
        if($row["done"] == 1) {
          echo "<p>The Bug has been fixed by the tasker assigned.</p>";
        } else {
          echo "<p>The bug is NOT yet been fixed, our taskers are looking into it.</p>";
        }
        echo "</div>";
      }
    }
  } elseif($_SESSION["user_type"] == 'tasker') {
    if (mysqli_num_rows($result) == 0) {
      echo "<p style='position:relative; left:45%; top:50px; font-size: 30px;'>No bugs assigned to you yet.</p>";
    } else {
      echo "<div class='jobs'><p style='position:relative; left:300px; top:50px; font-size: 30px;'>The Bugs assigned to you are -</p></div>";
      while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='jobs'>";
        echo "<h3>TITLE - " . $row["title"] . "</h3>";
        echo "<h5>Category - " . $row["category"] . "</h5>";
        echo "<p>DESCRIPTION - " . $row["description"] . " Fees - " . $row["price"] . "</p>";
        echo "<p>Bug id - " . $row["taskid"] . "</p>";
        if($row["done"] == 1) {
          echo "<p>The Bug has been FIXED.</p>";
        }
        echo "</div>";
      }
      echo '<form action="done.inc.php" method="post">';
      echo "<div class='jobs'>";
      echo "<h3>MARK A BUG AS DONE</h3>";
      echo "Bug ID <input type='text' name='tid' placeholder='BUGID' style='margin-bottom:20px; margin-top:20px;' required><br>";
      echo "<button id='logbtn' name='submit' type='submit' style='position:relative; left:35%; top:0px;'>MARK THIS BUG</button>";
      echo "</div>";
      echo "</form>";
    }
  }

  if($_SESSION["user_type"] == 'admin') {
    echo '<form action="assign.inc.php" method="post">';
    echo "<div class='jobs'>";
    echo "<h3>ASSIGN BUG TO USER</h3>";
    echo "BUG ID <input type='text' name='tid' placeholder='BUGID' style='margin-bottom:20px;' required><br>";
    echo "User ID <input type='text' name='uid' placeholder='USERID' required><br>";
    echo "<button id='logbtn' name='submit' type='submit' style='position:relative; left:35%; top:-10px;'>ASSIGN THE BUG</button>";
    echo "</div>";
    echo "</form>";

    echo '<form action="deletetask.inc.php" method="post">';
    echo "<div class='jobs'>";
    echo "<h3>DELETE A BUG</h3>";
    echo "Bug ID <input type='text' name='tid' placeholder='BUGID' style='margin-bottom:20px; margin-top:20px;' required><br>";
    echo "<button id='logbtn' name='submit' type='submit' style='position:relative; left:35%; top:0px;'>DELETE THE Bug</button>";
    echo "</div>";
    echo "</form>";
  }
  
  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<div class='jobs'>";
      echo "<h3>TITLE - " . $row["title"] . "</h3>";
      echo "<h5>Category - " . $row["category"] . "</h5>";
      echo "<p>DESCRIPTION - " . $row["description"] . " Fees - " . $row["price"] . "</p>";
      echo "<p>Bug id - " . $row["taskid"] . "</p>";
      if($row['assignedtoid']) {
        if($row['done'] == 1) {
          echo "<p>The Bug has SOLVED!</p>";
        } else {
          echo "<p>The Bug has been ASSIGNED but NOT solved yet.</p>";
        }
      } else {
        echo "<p>The Bug has NOT been assigned yet.</p>";
      }
      echo "</div>";
    }
  }
}
?>
</div>
</body>
</html>
