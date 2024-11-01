<?php
	if(!isset($_SESSION)) {
        session_start();
    }
	
	if(isset($_POST['submit']))
	{
		include 'dbconn.php';
		$tid=mysqli_real_escape_string($conn,$_POST['tid']);
		$sql = "DELETE FROM tasks WHERE taskid='$tid'";
		$result = mysqli_query($conn, $sql);
		echo '<script>alert("The bug has been deleted"); window.location.href="browse.php";</script>';
	
		
	}
?>