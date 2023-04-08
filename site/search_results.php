<?php
require("util/connect-db.php");
require("util/user-db.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect them to the login page
    header("Location: login.php");
    exit;
}

$results = $_SESSION['search_results'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img src="../../img/logo.png" alt="Logo" style="max-height: 100%; max-width: 100%;">
                </a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Games</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="friends.php">Friends</a></li>
            </ul>
            <form class="navbar-form navbar-left" action="index.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search for games, users, ..." name="search_query">
                </div>
                <button type="submit" class="btn btn-default" name="search">Search</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <?php
                $user_id = $_SESSION['user_id'];
                $full_name = getFullName($user_id);
                echo '<li><a href="user_info.php"><span class="glyphicon glyphicon-user"></span> ' . $full_name[0][0] . ' ' . $full_name[0][1] . '</a></li>';
                echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>';
                ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Search Results</h1>
        <?php if (count($results) == 0) { ?>
            <p>No results found.</p>
        <?php } else { ?>
            <ul>
                <?php foreach ($results as $result) { ?>
                    <li><?php echo $result['name'] . ' (' . $result['type'] . ')'; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
