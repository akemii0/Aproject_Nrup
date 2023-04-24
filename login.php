<?php
session_start();

$dbname = 'u_220170202_db';
$dbhost = 'localhost';
$username = 'u-220170202';
$password = 'AtQ7kEeBviZ5bY9';

try {
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        //CSRF security
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
            die('Invalid CSRF token');
        }

        $stm = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stm->execute([$email]);
        $user = $stm->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['uid'];
            header('Location: aproject.php');
            exit;
        } else {
            echo 'Invalid email or password';
        }
    }
} catch (PDOException $ex) {
    echo 'Connection failed: ' . $ex->getMessage();
}

$token = bin2hex(random_bytes(32));
$_SESSION['token'] = $token;
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body id="logB">
    <h1 id="logH">Login</h1>
    <form id="logF" method="post" action="login.php">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div>
            <label class="logL" for="email">Email:</label>
            <input type="email" id="emailA" name="email" required>
        </div>
        <div>
            <label class="logL" for="password">Password:</label>
            <input type="password" id="passd" name="password" required>
        </div>
        <button id="logSub" type="submit">Login</button>
        <a href="register.php" class="btnr">Don't have a account? Click this button to register</a>
    </form>
    <a href="index.html"><button class="btn">Home</button></a>
    <a href="aproject.php" class="btn">Projects</a>
</body>

</html>