<?php
require("..\util\connect-db.php");
require("..\util\user-db.php");
require("..\util\game-db.php");

session_start();

if (isset($_SESSION['user_id'])) {
    // User is logged in, display their information
} else {
    // User is not logged in, redirect them to the login page
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_g']) && isset($_POST['new_f']) && isset($_POST['new_l'])) {
        $new_g = $_POST['new_g'];
        $new_f = $_POST['new_f'];
        $new_l = $_POST['new_l'];
        updateUserInfo($user_id, $new_g, $new_f, $new_l);
        echo "Info Updated!!";
    } else {
        echo "Fill out all fields!!";
    }
}


// $user_id = 0;
$gamer_tag = getGamerTag($user_id);
$full_name = getFullName($user_id);
$location = getLocation($user_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User <?php echo $user_id ?></title> <!-- Need to implement $user_id sessions -->
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
                <li><a href="game_info.php">Game Search</a></li>
                <li class="active"><a href="user_info.php">Users</a></li>
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

    <div class="container">
        <h1 class="mt-5">Update Your User Info</h1>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <form action="update_user.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter new gamertag!" name="new_g" required>
                        <input type="text" class="form-control" placeholder="Enter new first name" name="new_f" required>
                        <input type="text" class="form-control" placeholder="Enter new last name" name="new_l" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Info</button>
                </form>
            </div>
        </div>
        <hr>

</body>
</html>

