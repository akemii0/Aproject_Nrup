<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit();
}
$uid = $_SESSION['uid'];

$dbname = 'u_220170202_db';
$dbhost = 'localhost';
$username = 'u-220170202';
$password = 'AtQ7kEeBviZ5bY9';


$connt = mysqli_connect($dbhost, $username, $password, $dbname);

if (!$connt) {
    die("Connection to database failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

$stm = $connt->prepare("INSERT INTO  projects(title, description, start_date, end_date, phase, uid) VALUES(?, ?, ?, ?, ?, ?)");

$stm->bind_param("sssssi", $title, $description, $start_date, $end_date, $phase, $uid);

$title = $_POST['title'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$phase = $_POST['phase'];
$uid = $_POST['uid'];

if ($stm->execute()) {
    echo "New project was added successfully. ";
    echo "<button onclick=\"window.location.href='aproject.php'\">Projects</button>";
    header("Location: aproject.php");
    exit;
} else {
    echo "There was an error adding project: " . mysqli_error($connt);
}

$stm->close();
mysqli_close($connt);
?>