<?php
require("../util/connect-db.php");
require("../util/user-db.php");

session_start();

// TODO: Implement search functionality (searchGamesAndUsers)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    $results = searchGamesAndUsers($search_query);
    $_SESSION['search_results'] = $results;
    header("Location: search_results.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
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
            height: 300px;
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
                <!-- <a class="navbar-brand" href="#">
                    <img src="../../img/logo.png" alt="Logo" style="max-height: 100%; max-width: 100%;">
                </a> -->
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="../site">Home</a></li>
                <li><a href="games_played.php">Games Played</a></li>
                <li><a href="game_info.php">Game Search</a></li>
                <li><a href="game_achievements.php">Achievements</a></li>
                <li><a href="user_info.php">Users</a></li>
                <li><a href="friends.php">Friends</a></li>
                <li><a href="write_review.php">Review</a></li>
            </ul>
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

<div class="jumbotron">
    <div class="container">
        <h1>Welcome to PlayTracker!</h1>
        <p>Here you can find information about various games and connect with other gamers from around the world.</p>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h2>Games</h2>
            <p>Browse our collection of games and find your new favorite.</p>
            <a class="btn btn-primary" href="game_info.php">Browse Games</a>
        </div>
        <div class="col-md-4">
            <h2>Users</h2>
            <p>Connect with other gamers from around the world and build your network.</p>
            <a class="btn btn-primary" href="user_info.php">Browse Users</a>
        </div>
        <div class="col-md-4">
            <h2>Reviews</h2>
            <p>Read reviews of games written by other players or share your own thoughts and experiences.</p>
            <a class="btn btn-primary" href="write_review.php">Write a Review</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>