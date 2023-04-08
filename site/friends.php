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
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><img src="logo.png" alt="Logo"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <?php } else { ?>
                    <li><a href="#"><?php echo getFullName($user_id)[0][0]; ?></a></li>
                    <li><a href="home.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
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

