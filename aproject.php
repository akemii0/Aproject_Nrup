<?php

session_start();



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

if (isset($_SESSION['user_id'])) {
    echo '<a href="addproj.php"><button class="btn">Add Project</button></a>';
    echo '<form method="post" action="logout.php">';
    echo '<input type="submit" class="btn" value="Logout">';
    echo '</form>';
} else {
    echo '<a href="login.php"><button class="btn">Login</button></a>';
}




//search query with a bit of security feature
if (isset($_GET['search'])) {
    $search = '%' . htmlspecialchars($_GET['search']) . '%';
    $stm = $db->prepare('SELECT * FROM projects WHERE title LIKE ? OR start_date LIKE ?');
    $stm->execute([$search, $search]);
    $projects = $stm->fetchAll(PDO::FETCH_ASSOC);
} else {
    //fetches all the projects that are in the database
    $qry = $db->query('SELECT * FROM projects');
    $projects = $qry->fetchAll(PDO::FETCH_ASSOC);
}



?>

<!DOCTYPE html>
<html>

<head>
    <title> List of projects</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
</head>

<body>
    <h1>Projects</h1>
    <a href="index.html"><button class="btn">Home</button></a>
    <form id="searchF" method="get" action="">
        <label for="search">Search:</label>
        <input type="text" id="searchIn" name="search" placeholder="Please enter a project title or start date">
        <input type="submit" id="submitIn" value="Search">
    </form>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Start date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>

                    <td>
                        <a href="pdetails.php?id=<?php echo $project['pid']; ?>"><?php echo htmlspecialchars($project['title']); ?></a>


                    </td>
                    <td>
                        <?php echo htmlspecialchars($project['start_date']); ?>
                    </td>
                    <?php if (isset($_SESSION['user_id']) && $project['user_id'] == $_SESSION['user_id']): ?>
                        <td>
                            <a href="editP.php?id=<?php echo $project['pid']; ?>"><button class="btn">Edit</button></a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>