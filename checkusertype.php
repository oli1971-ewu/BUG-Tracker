<?php
// Start the session
ob_start();
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
include 'dbconn.php';

// Get the username and password from POST request and escape them to prevent SQL injection
$uname = mysqli_real_escape_string($conn, $_POST['uname']);
$pass = mysqli_real_escape_string($conn, $_POST['pass']);

// Use prepared statements for SQL query
$sql = "SELECT * FROM users WHERE username = ? AND pass = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $uname, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the user data and store it in session
    while ($row = $result->fetch_assoc()) {
        $_SESSION['uid'] = $row["id"];
        $_SESSION['uname'] = $row["username"];
        $_SESSION['user_type'] = $row["user_type"];
        echo "id: " . $row["id"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] . "<br>";
    }

    $tol = $_POST['typeofuser'];
    if ($tol == 'taskgiver') {
        header('Location: postatask.php');
    } else {
        header('Location: browse.php');
    }
    exit(); // Make sure to call exit() after header() to stop the script execution
} else {
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
?>
