<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

try {
    $dbname = 'u_220170202_db';
    $dbhost = 'localhost';
    $username = 'u-220170202';
    $password = 'AtQ7kEeBviZ5bY9';
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "Connection was not successful: " . $ex->getMessage();
}

if (!isset($_GET['user_id'])) {
    header('Location: aproject.php');
    exit();
}

$user_id = $_GET['user_id'];

$qry = $db->prepare('SELECT * FROM projects WHERE pid = ? AND uid = ?');
$qry->execute([$user_id, $_SESSION['user_id']]);
$project = $qry->fetch();

if (!$project) {
    header('Location: aproject.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $start_date = $_POST['start_date'];
    $phase = $_POST['phase'];
    $end_date = $_POST['end_date'];

    $stm = $db->prepare('UPDATE projects SET title = ?, description = ?, start_date = ?, end_date = ?, phase = ? WHERE pid = ?');
    $stm->execute([$title, $desc, $start_date, $end_date, $phase, $pid]);

    header("Location: pdetails.php?id=$user_id");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Project</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
</head>

<body>
    <h1>Edit Project</h1>
    <form method="post" action="">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="tleA" name="title" value="<?php echo htmlspecialchars($project['title']); ?>">
        </div>
        <div>
            <label for="desc">Description:</label>
            <textarea id="descrip" name="desc"><?php echo htmlspecialchars($project['description']); ?></textarea>
        </div>
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="startDt" name="start_date" value="<?php echo $project['start_date']; ?>">
        </div>
        <div>
            <label for="end_date">End Date:</label>
            <input type="date" id="endDt" name="end_date" value="<?php echo $project['end_date']; ?>">
        </div>
        <div>
            <button type="submit" class="btn">Update</button>
            <a href="pdetails.php?id=<?php echo $project['pid']; ?>"><button type="button"
                    class="btn">Cancel</button></a>
        </div>
    </form>
</body>

</html>