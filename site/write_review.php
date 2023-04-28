<?php
require("..\util\connect-db.php");
require("..\util\\review-db.php");

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
                <li class="active"><a href="../site">Home</a></li>
                <li><a href="game_info.php">Games</a></li>
                <li><a href="user_info.php">Users</a></li>
                <li><a href="friends.php">Friends</a></li>
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
?>