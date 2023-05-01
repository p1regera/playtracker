<?php
require("../util/connect-db.php");

// Start session if it hasn't already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Check if game_id is set in the URL
if (!isset($_GET['game_id'])) {
    header("Location: games.php");
}

$game_id = $_GET['game_id'];

// Fetch game information
$query = "SELECT * FROM Game WHERE game_id = :game_id";
$statement = $db->prepare($query);
$statement->bindValue(':game_id', $game_id);
$statement->execute();
$game = $statement->fetch();
$statement->closeCursor();

// Fetch achievements for the game
$query = "SELECT Achievement.*, Achieved.user_id FROM Achievement 
          INNER JOIN Belongs_to ON Achievement.achievement_id = Belongs_to.achievement_id 
          LEFT JOIN Achieved ON Achievement.achievement_id = Achieved.achievement_id AND Achieved.user_id = :user_id
          WHERE Belongs_to.game_id = :game_id";
$statement = $db->prepare($query);
$statement->bindValue(':game_id', $game_id);
$statement->bindValue(':user_id', $_SESSION['user_id']);
$statement->execute();
$achievements = $statement->fetchAll();
$statement->closeCursor();


?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $game['title']; ?> - Achievements</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .game-info {
            margin-top: 30px;
        }
        .game-info h2 {
            margin-top: 0;
        }
        .game-info p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .game-info a.btn {
            margin-right: 10px;
        }

        body {
            background-color: #f5f5f5;
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-brand img {
            max-height: 25%;
            max-width: 25%;
        }

        .jumbotron {
            background-image: url("../../img/bg.jpg");
            background-size: cover;
            background-position: center;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .jumbotron h1 {
            color: #fff;
            text-shadow: 1px 1px #000;
            font-weight: bold;
            font-size: 5rem;
            text-align: center;
        }

        .jumbotron p {
            color: #fff;
            text-shadow: 1px 1px #000;
            font-size: 2rem;
            text-align: center;
            margin-top: 1rem;
        }

        .search-form {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2rem;
        }

        .search-input {
            border-radius: 0;
        }
    </style>
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
            <li><a href="game_info.php">Game Search</a></li>
            <li class="active"><a href="game_achievements.php">Achievements</a></li>
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
                //$full_name = getFullName($user_id);
                //echo '<li><a href="user_info.php"><span class="glyphicon glyphicon-user"></span> ' . $full_name[0][0] . ' ' . $full_name[0][1] . '</a></li>';
                //echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>

<div class="jumbotron">
        <div class="container">
            <h1><?php echo $game['title']; ?> - Achievements</h1>
        </div>
    </div>

<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Achievement Name</th>
                <th>Date Obtained</th>
                <th>Achieved?</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($achievements as $achievement) { ?>
                <tr>
                    <td><?php echo $achievement['achievement_name']; ?></td>
                    <td><?php echo $achievement['date_obtained']; ?></td>
                    <td>
                        <?php if ($achievement['user_id'] == null) { ?>
                            <span style="color: red">&#10005;</span>
                        <?php } else { ?>
                            <span style="color: green">&#10003;</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>

            <?php if (empty($achievements)) { ?>
                <tr>
                    <td colspan="3"><p>No achievements found for this game.</p></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
