<?php
// Start the session
ob_start();
if(!isset($_SESSION)) {
        session_start();
    }
?>

<?php
	if(isset($_POST['post']))
	{
		include 'dbconn.php';
		$title=mysqli_real_escape_string($conn,$_POST['title']);
		$desc=mysqli_real_escape_string($conn,$_POST['desc']);
		$category=mysqli_real_escape_string($conn,$_POST['category']);
		$fees=mysqli_real_escape_string($conn,$_POST['fees']);
		$userid=$_SESSION['uid'];
		$sql = "INSERT INTO tasks (title ,description, user_id , category ,price) VALUES ('$title','$desc' , '$userid' ,'$category','$fees')";
		mysqli_query($conn, $sql);
		echo '<script>alert("Bug has been posted, check out Browse bugs to view it!"); window.location.href="postatask.php";</script>';
	
	}	
	else{
		header('location: tasker.php');
		exit();
	}
	
?>