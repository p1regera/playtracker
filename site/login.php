<?php
require("..\util\connect-db.php");
require("..\util\user-db.php");

session_start();

function authenticateUser($userId, $password) {
    $allUsers = getAllUsers();
    foreach ($allUsers as $user) {
        if ($user['user_id'] == $userId && password_verify($password, $user['password'])) {
            return true;
        }
    }
    return false;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $password = $_POST['password'];

    if (authenticateUser($userId, $password)) {
        // Store the user ID in a session variable
        $_SESSION['user_id'] = $userId;
    
        // Redirect to the user_info page after successful login
        header("Location: user_info.php");
        exit;
    } else {
        $message = "Invalid user ID or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Login</h1>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="number" class="form-control" name="user_id" id="user_id" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div style="margin-top: 10px;">
            <!-- don't have an account, redirect to sign_up.php -->
            <a href="sign_up.php">Don't have an account? Sign up here!</a>
        </div>
        <?php if (!empty($message)) { ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>