<?php
require("..\util\connect-db.php");
require("..\util\\user-db.php");
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
    <title>PlayTracker <?php echo $user_id ?></title> <!-- Need to implement $user_id sessions -->
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
        <h1 class="mt-5">User: <?php echo $gamer_tag[0][0] ?></h1>
        <!--p><b>User <?php //echo $user_id ?> Name:</b> <?php //echo $full_name[0][0];  echo " "; echo $full_name[0][1] ?> </p!-->
        <h3> Search for a game!</h3>
        <p>If you know the game's ID, search by that. Otherwise, feel free to search by the title.</p>
        <form action="game_info.php" method=post>
            <input type="text" class="form-control" id="game_id" name="game_id" placeholder="Search by Game ID..."><br>
            <input type="text" class="form-control" id="title" name="title" placeholder="Search by Title..."><br>
            <!-- <input type="text" class="form-control" id="release" name="release" placeholder="Search by Release Date..."><br> -->
            <input type="submit">
        </form>
        <?php
            if(isset($_POST["game_id"])){
                $game_id = $_POST["game_id"];
                if (strlen($game_id)!=0){
                    $game_info = getGameInfo_ID($game_id);
                }
            }
            if(isset($_POST["title"])){
                $title = $_POST["title"];
                if(strlen($title)!=0){
                    $game_info = getGameInfo_Title($title);
                    // echo count($game_info);
                }
            }
            // if(isset($_POST["release"])){
            //     $release = $_POST["release"];
            //     if(strlen($release)!=0){
            //        $game_info = getGameInfo_RDate($release);
            //        echo count($game_info);
            //    }
            // }
            // foreach ($game_info as $item)
            //     echo $item;
            // echo $game_info[0][3];
        ?>
        
        <?php
        if(isset($game_info)) {
        ?>
        <h3>Game(s)</h3>
        <?php
            foreach ($game_info as $item) {
        ?>
            <p>Game ID: <?php echo $item[0]; ?></p>
            <p>Title: <?php echo $item[3]; ?></p>
            <p>Release Date: <?php echo $item[2]; ?></p>
            <p>Genre: <?php echo $item[4]; ?></p><br>
            
        <?php
            }
        }
        ?>
        <p>For a complete list of all games, click <a href="games.php">here</a>!</p>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>