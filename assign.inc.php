<?php
	if(!isset($_SESSION)) {
        session_start();
    }
	
	if(isset($_POST['submit']))
	{
		include 'dbconn.php';
		$tid=mysqli_real_escape_string($conn,$_POST['tid']);
		$uid=mysqli_real_escape_string($conn,$_POST['uid']);
		$sql = "UPDATE tasks SET assignedtoid='$uid' WHERE taskid='$tid'";
		$result = mysqli_query($conn, $sql);
		echo '<script>alert("The bug has been assigned to the tasker!"); window.location.href="browse.php";</script>';
	
		
	}

?>
