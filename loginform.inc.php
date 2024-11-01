<?php
// Start the session
if(!isset($_SESSION)) {
        session_start();
    }

?>

<script>
function myFunction() {
    alert("Check Username or Password");
}
</script>

<?php
	if(isset($_POST['submit']))
	{
		include 'dbconn.php';
		$uname=mysqli_real_escape_string($conn,$_POST['uname']);
		$pass=mysqli_real_escape_string($conn,$_POST['pass']);
		$pass=md5($pass);
		$sql = "SELECT * FROM users WHERE username='$uname' AND pass='$pass'";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			$_SESSION["uname"]=$uname;
			
			$row = mysqli_fetch_assoc($result);
			$_SESSION["uid"]=$row["user_id"];
			$_SESSION['error']='none';
			$_SESSION['user_type']=$row['user_type'];
			if($row['user_type']=='tasker'){
				
				header('location: browse.php');
			}
			else{
				header('location: postatask.php');
			}
		
		}
		else{
                 $_SESSION['error']='wrong_pass';
				 header('location: index.php');
		}
	}
	else{
		header('location: index.php');
		exit();
	}
	
?>