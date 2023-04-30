<?php
require("..\util\\connect-db.php");
require("..\util\\user-db.php");
require("..\util\\game-db.php");
require("..\util\\addPlay-db.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect them to the login page
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_game_played'])) {
        $game_id = $_POST['add_game_played'];
        $hours_played = $_POST['add_hours_played'];
        addGamePlayed($user_id, $game_id, $hours_played);
    } elseif (isset($_POST['remove_game_played'])) {
        $game_id = $_POST['remove_game_played'];
        deleteGamePlayed($user_id,$game_id);
    }
}

$games = getGamesPlayed($user_id);

$allGames = getAllGames();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Games Played</title>
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
                <li class="active"><a href="games_played.php">Games Played</a></li>
                <li><a href="game_info.php">Game Search</a></li>
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
        <h1 class="mt-5">Games Played</h1>
        <div class="row">
            <div class="col-md-6">
            <h2>My Games</h2>
                <?php if (empty($games)) { ?>
                    <p>You have no games added yet.</p>
                <?php } else { ?>
                        <ul class="list-group">
                            <?php foreach ($games as $game) { ?>
                                <li class="list-group-item"> Title: <?php echo $game["title"]; ?>,
                                 Game ID: <?php echo $game["game_id"]; ?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h2>Add a Game</h2>
                <form action="games_played.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter a game ID" name="add_game_played" required>
                        <input type="text" class="form-control" placeholder="Enter number of hours played as an int!" name="add_hours_played" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add a Game you have Played!</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h2>Remove a Game from Played</h2>
                
                <form action="games_played.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter a Game ID" name="remove_game_played" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Remove Game Played</button>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>