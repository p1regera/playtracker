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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- <a class="navbar-brand" href="#"><img src="../../img/logo.png" alt="Logo" style="max-height: 25%; max-width: 25%;"></a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../site">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="games_played.php">Games Played</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="game_info.php">Game Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_info.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="friends.php">Friends</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="write_review.php">Review</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log in</a>
                </li>
            <?php else: ?>
                <?php
                $user_id = $_SESSION['user_id'];
                $full_name = getFullName($user_id);
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="user_info.php"><span class="glyphicon glyphicon-user"></span> <?php echo $full_name[0][0] . ' ' . $full_name[0][1]; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1>Games Played</h1>
    <div class="row">
        <div class="col-md-6">
            <h2>My Games</h2>
            <?php if (empty($games)): ?>
                <p>You have no games added yet.</p>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($games as $game): ?>
                        <li class="list-group-item">Title: <?php echo $game["title"]; ?>, Game ID: <?php echo $game["game_id"]; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h2>Add a Game</h2>
            <form action="games_played.php" method="post">
                <div class="form-group">
                    <label for="add_game_played">Game ID</label>
                    <input type="text" class="form-control" id="add_game_played" name="add_game_played" placeholder="Enter a game ID" required>
                </div>
                <div class="form-group">
                    <label for="add_hours_played">Hours Played</label>
                    <input type="number" class="form-control" id="add_hours_played" name="add_hours_played" placeholder="Enter number of hours played as an int!" required>
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
                    <label for="remove_game_played">Game ID</label>
                    <input type="text" class="form-control" id="remove_game_played" name="remove_game_played" placeholder="Enter a Game ID" required>
                </div>
                <button type="submit" class="btn btn-primary">Remove Game Played</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

