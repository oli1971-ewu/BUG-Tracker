<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user123";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["sub"])) {
    $uname = mysqli_real_escape_string($conn, $_POST["uname"]);
    $sql = "SELECT * FROM user WHERE name = '$uname'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $age = $row["age"];
            $class = $row["class"];
            $div = $row["division"];
            echo "Name: " . htmlspecialchars($uname) . "<br>";
            echo "Age: " . htmlspecialchars($age) . "<br>";
            echo "Class: " . htmlspecialchars($class) . "<br>";
            echo "Division: " . htmlspecialchars($div);
        } else {
            echo "No user found with the name: " . htmlspecialchars($uname);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<html>
<body>
    <form action="userdetails.php" method="post">
        <input type="text" name="uname" placeholder="Name">
        <input type="submit" value="Submit" name="sub">
    </form>
</body>
</html>
