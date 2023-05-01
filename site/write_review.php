<?php
require("..\util\connect-db.php");
require("..\util\\review-db.php");
require("..\util\\user-db.php");

session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $gameId = $_POST['game_id'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    if (userHasReviewed($userId, $gameId)) {
        $message = "You have already reviewed this game!";
    } else {
        createReview($userId, $gameId, $rating, $comments);
        $message = "Review submitted successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Write Review</title>
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
                <!-- <a class="navbar-brand" href="#">
                    <img src="../../img/logo.png" alt="Logo" style="max-height: 100%; max-width: 100%;">
                </a> -->
            </div>
            <ul class="nav navbar-nav">
                <li><a href="../site">Home</a></li>
                <li><a href="games_played.php">Games Played</a></li>
                <li><a href="game_info.php">Game Search</a></li>
                <li><a href="user_info.php">Users</a></li>
                <li><a href="friends.php">Friends</a></li>
                <li class="active"><a href="write_review.php">Review</a></li>
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
            <h1>Write a Review!</h1>
            <p>Let us know what you thought about any of your favorite games.</p>
        </div>
    </div>

    <div class="container">
        <h1 class="mt-5">Write a Review</h1>
        <form action="write_review.php" method="post">
            <div class="form-group">
                <label for="game_id">Game ID:</label>
                <input type="number" class="form-control" name="game_id" id="game_id" required>
            </div>
            <div class="form-group">
                <label for="rating">Rating (0-10):</label>
                <input type="number" class="form-control" name="rating" id="rating" min="0" max="10" required>
            </div>
            <div class="form-group">
                <label for="comments">Comments:</label>
                <textarea class="form-control" name="comments" id="comments" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
        <?php if (!empty($message)) { ?>
            <div class="alert alert-info mt-3" role="alert" style="margin-top: 10px;">
                <?php echo $message; ?>
            </div>
        <?php } ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
