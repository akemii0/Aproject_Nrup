<!DOCTYPE html>
<html>

<head>
    <title>Add Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
</head>

<body>
    <div class="containerAdd">
        <div class="cubeAdd">
            <h1 id="addpH">Add Project</h1>
            <form action="projectsub.php" method="post">
                <label for="title" class="addpL">Title: </label>
                <input type="text" id="tleA" name="title" required><br>

                <label for="description" class="addpL">Description: </label>
                <textarea name="description" id="descrip" required></textarea><br>

                <label for="start_date" class="addpL">Start Date: </label>
                <input type="date" id="startDt" name="start_date" required><br>

                <label for="end_date" class="addpL">End Date: </label>
                <input type="date" id="endDt" name="end_date" required><br>

                <label for="phase" class="addpL">Phase: </label>
                <select name="phase" id="phaseAdd" required>
                    <option value="Design">Design</option>
                    <option value="Development">Development</option>
                    <option value="Testing">Testing</option>
                    <option value="Deployment">Deployment</option>
                    <option value="Complete">Complete</option>
                </select><br>

                <label for="uid" class="addpL">Project Developer:</label>
                <select id="uidAdd" name="uid" required>
                    <?php
                    $dbname = 'u_220170202_db';
                    $dbhost = 'localhost';
                    $username = 'u-220170202';
                    $password = 'AtQ7kEeBviZ5bY9';

                    $connt = new mysqli($dbhost, $username, $password, $dbname);

                    if ($connt->connect_error) {
                        die("Connection to the database failed: " . $connt->connect_error);
                    }

                    $sql = "SELECT uid FROM users";
                    $rest = $connt->query($sql);

                    while ($row = $rest->fetch_assoc()) {
                        echo "<option value='" . $row['uid'] . "'>" . $row['uid'] . "</option>";
                    }
                    $connt->close();
                    ?>
                </select><br>

                <input type="submit" id="addSb" value="Add Project">
            </form>
            <a href="aproject.php" class="btn">Back</a>
        </div>
    </div>
</body>

</html>