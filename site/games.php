<?php
require("../util/connect-db.php");

$query = "SELECT * FROM Game";
$statement = $db->prepare($query);
$statement->execute();
$games = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Games</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><img src="logo.png" alt="Logo"></a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>All Games</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Release Date</th>
                    <th>Studio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($games as $game) { ?>
                    <tr>
                        <td><?php echo $game['title']; ?></td>
                        <td><?php echo $game['genre']; ?></td>
                        <td><?php echo $game['release_date']; ?></td>
                        <td><?php echo $game['studio_id']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
