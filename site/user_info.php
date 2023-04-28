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
                <li><a href="index.php">Home</a></li>
                <li><a href="game_info.php">Games</a></li>
                <li class="active"><a href="user_info">Users</a></li>
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
        <h1 class="mt-5">User Page: <?php echo $gamer_tag[0][0] ?></h1>
        <p><b>User <?php echo $user_id ?> Name:</b> <?php echo $full_name[0][0];  echo " "; echo $full_name[0][1] ?> </p>
        <p><b>User <?php echo $user_id ?> Location:</b> <?php echo $location[0][0];  echo ", "; echo $location[0][1] ?> </p>

        
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>