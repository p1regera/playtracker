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
<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img src="../../img/logo.png" alt="Logo" style="max-height: 100%; max-width: 100%;">
                </a>
            </div>
            <ul class="nav navbar-nav">
            <li><a href="../site">Home</a></li>
                <li><a href="games_played.php">Games Played</a></li>
                <li class="active"><a href="game_info.php">Game Search</a></li>
                <li><a href="user_info.php">Users</a></li>
                <li><a href="friends.php">Friends</a></li>
                <li><a href="write_review.php">Review</a></li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search for games, users, ...">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <?php
                //session_start();
                if (!isset($_SESSION['user_id'])) {
                    echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log in</a></li>';
                } else {
                    $user_id = $_SESSION['user_id'];
                    $full_name = getFullName($user_id);
                    echo '<li><a href="user_info.php"><span class="glyphicon glyphicon-user"></span> ' . $full_name[0][0] . ' ' . $full_name[0][1] . '</a></li>';
                    echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>';
                }
                ?>
            </ul>
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
