<?php
require("..\util\connect-db.php");
require("..\util\user-db.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect them to the login page
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_friend'])) {
        $friend_id = $_POST['add_friend'];
        addFriend($user_id, $friend_id);
    } elseif (isset($_POST['delete_friend'])) {
        $friend_id = $_POST['delete_friend'];
        deleteFriend($user_id, $friend_id);
    }
}

// $friends = getFriends($user_id);
$allUsers = getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Friends</title>
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
                <li><a href="game_info.php">Games</a></li>
                <li><a href="user_info.php">Users</a></li>
                <li class="active"><a href="friends.php">Friends</a></li>
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
        <h1 class="mt-5">Friends</h1>
        <div class="row">
            <div class="col-md-6">
            <h2>My Friends</h2>
                <?php if (empty($friends)) { ?>
                    <p>You have no friends yet.</p>
                <?php } else { ?>
                        <ul class="list-group">
                            <?php foreach ($friends as $friend) { ?>
                                <li class="list-group-item"><?php echo getFullName($friend)[0][0]; ?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h2>Add a Friend</h2>
                <form action="friends.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter a user ID" name="add_friend" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Friend</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h2>Delete a Friend</h2>
                <form action="friends.php" method="post">
                    <div class="form-group">
                        <select class="form-control" name="delete_friend" required>
                            <?php foreach ($friends as $friend) { ?>
                                <option value="<?php echo $friend; ?>"><?php echo getFullName($friend)[0][0]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete Friend</button>
                    </form>
            </div>
        </div>
    </div>
</html>

