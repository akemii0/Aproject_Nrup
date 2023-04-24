<!DOCTYPE html>
<html>

<head>
    <title>Project Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
</head>

<body>
    <a href="aproject.php"><button class="btn">Projects</button></a>

    <?php
    $dbname = 'u_220170202_db';
    $dbhost = 'localhost';
    $username = 'u-220170202';
    $password = 'AtQ7kEeBviZ5bY9';
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $user_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        var_dump($_GET['id']);



        $stmt = $db->prepare('SELECT p.*, u.email, u.username FROM projects p INNER JOIN users u ON p.uid = u.uid WHERE p.pid = ?');
        $stmt->execute([$user_id]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);

        //display project detials
        if ($project) {
            echo '<div class="container">';
            echo '<div class="cube">';

            //htmlspecialchars is used to prevent XSS attacks  
            echo '<h1 id="pdtl">' . htmlspecialchars($project['title']) . '</h1>';

            echo '<p id="pdescrip">Description: ' . htmlspecialchars($project['description']) . '</p>';
            echo '<p>Start date: ' . htmlspecialchars($project['start_date']) . '</p>';
            echo '<p>End date: ' . htmlspecialchars($project['end_date']) . '</p>';
            echo '<p>Phase: ' . htmlspecialchars($project['phase']) . '</p>';



            $userStmt = $db->prepare('SELECT email FROM users WHERE uid = ?');
            $userStmt->execute([$project['uid']]);
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo '<p>User email: ' . htmlspecialchars($user['email']) . '</p>';
            } else {
                echo '<p>User not found</p>';
            }

            if ($project['username']) {
                echo '<p>Developer Username: ' . htmlspecialchars($project['username']) . '</p>';
            } else {
                echo '<p>Username not found</p>';
            }


            echo '</div>';
            echo '</div>';



        } else {
            echo '<p>Project not found</p>';
        }
    } else {
        echo '<p>No project ID provided</p>';
    }

    ?>
</body>

</html>