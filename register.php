<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: aproject.php");
    exit;
}

$username = $password = $email = $confirm_pass = "";
$username_err = $password_err = $email_err = $confirm_pass_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dbname = 'u_220170202_db';
    $dbhost = 'localhost';
    $dbusername = 'u-220170202';
    $dbpassword = 'AtQ7kEeBviZ5bY9';

    try {
        $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        echo "Connection could not be made: " . $ex->getMessage();
        exit;
    }

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (empty(trim($_POST['email']))) {
        $email_err = "Please enter your email address.";
    } else {
        $username = trim($_POST["username"]);
        $email = trim($_POST['email']);

        $sql = "SELECT uid FROM users WHERE username = :username";

        if ($stm = $db->prepare($sql)) {
            $stm->bindParam(":username", $par_username, PDO::PARAM_STR);


            if ($stm->execute()) {
                if ($stm->rowCount() == 1) {
                    $username_err = "This username is already taken.";
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }
            unset($stm);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_pass"]))) {
        $confirm_pass_err = "Please confirm password.";
    } else {
        $confirm_pass = trim($_POST["confirm_pass"]);
        if (empty($password_err) && ($password != $confirm_pass)) {
            $confirm_pass_err = "Password did not match.";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_pass_err) && empty($email_err)) {
        $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";

        if ($stm = $db->prepare($sql)) {
            $par_username = $username;
            $par_email = $email;
            $par_password = password_hash($password, PASSWORD_DEFAULT);
            $stm->bindParam(":username", $par_username, PDO::PARAM_STR);
            $stm->bindParam(":email", $par_email, PDO::PARAM_STR);
            $stm->bindParam(":password", $par_password, PDO::PARAM_STR);
            if ($stm->execute()) {
                header("Location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }
    unset($db);
}
?>





<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
</head>

<body>
    <div class="regsR">
        <h1 id="reg">Register</h1>
        <a href="aproject.php" class="btn">Projects</a>
        <form action="register.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Enter a username" required>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Enter your email address" required>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter a password (Min 8 characters long)" required>
            <label for="confirm_pass">Confirm Password</label>
            <input type="password" name="confirm_pass" placeholder="Confirm your password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have a account? <a href="login.php">Click here to login</a>.</p>
    </div>

    <?php

    $dbname = 'u_220170202_db';
    $dbhost = 'localhost';
    $dbusername = 'u-220170202';
    $dbpassword = 'AtQ7kEeBviZ5bY9';
    $db = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $email = mysqli_real_escape_string($db, $_POST['email']);

        $sql = "SELECT * FROM users WHERE username='$username'";
        $res = mysqli_query($db, $sql);

        if (mysqli_num_rows($res) > 0) {
            echo "<p class='err'> The username is already exists.</p>";
        } else {
            $sql = "INSERT INTO users(username, password, email) VALUES ('$username', '$password', '$email')";
            mysqli_query($db, $sql);
            echo "<p class='finsh'>Successful. Please login here <a href='login.php'>Login</a>.</p>";
        }
    }
    ?>

</body>

</html>