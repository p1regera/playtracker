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