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

    <div class="jumbotron">
        <div class="container">
            <h1>User Page</h1>
            <p>View details about a user.</p>
        </div>
    </div>

    <div class="container">
        <h1 class="mt-5">Information</h1>
        <p><b>Gamer Tag:</b> <?php echo $gamer_tag[0][0] ?></p>
        <p><b>User ID:</b> <?php echo $user_id ?></p>
        <p><b>Full Name:</b> <?php echo $full_name[0][0];  echo " "; echo $full_name[0][1] ?> </p>
        <p><b>Location:</b> <?php echo $location[0][0];  echo ", "; echo $location[0][1] ?> </p>

        <a href="update_user.php"> <button>Edit User Info</button> </a>
        <br><br>
        <h3>Find other users!</h3>
        <p>If you know the user's ID, search by that. Otherwise, feel free to search by their name.</p>
        <form action="user_info.php" method=post>
            <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Search by User ID..."><br>
            <input type="text" class="form-control" id="gtag" name="gtag" placeholder="Search by Gamertag..."><br>
            <input type="text" class="form-control" id="fname" name="fname" placeholder="Search by First Name..."><br>
            <input type="text" class="form-control" id="lname" name="lname" placeholder="Search by Last Name..."><br>
            <input type="submit">
        </form>
        <?php
            if(isset($_POST["user_id"])){
                $user_id = $_POST["user_id"];
                if (strlen($user_id)!=0){
                    $user_info = getUserInfo_ID($user_id);
                }
            }
            if(isset($_POST["user_id"])){
                $gamer_tag = $_POST["gtag"];
                if (strlen($gamer_tag)!=0){
                    $user_info = getUserInfo_GTag($gamer_tag);
                }
            }
            if(isset($_POST["fname"])){
                $fname = $_POST["fname"];
                if(strlen($fname)!=0){
                    $user_info = getUserInfo_FName($fname);
                }
                if(isset($_POST["lname"])){
                    $lname = $_POST["lname"];
                    if(strlen($lname)!=0){
                        $user_info = getUserInfo_FLName($fname, $lname);
                    }
                }
            }
            else if(isset($_POST["lname"])){
                $lname = $_POST["lname"];
                if(strlen($lname)!=0){
                   $user_info = getUserInfo_LName($lname);
               }
            }
            // foreach ($user_info[0] as $item)
            //     echo $item;
            // echo $user_info[0][3];
        ?>
        
        <?php
        if(isset($user_info)) {
        ?>
        <h1>CREATE ADD FRIEND BUTTON TO EACH USER</h1>
        <h3>User(s)</h3>
        <?php
            foreach ($user_info as $item) {
        ?>
            <p>User ID = <?php echo $item[0]; ?></p>
            <p>Gamertag = <?php echo $item[1]; ?></p>
            <p>Name = <?php echo $item[2]; ?> <?php echo $item[3]; ?></p>
            <p>Location = <?php echo $item[5]; ?>, <?php echo $item[4] ?></p><br> 
        <?php
            }
        }
        ?>
        
        
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>