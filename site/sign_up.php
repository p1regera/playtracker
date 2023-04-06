<?php
require("..\util\connect-db.php");
require("..\util\user-db.php");

function userExists($userId) {
    $allUsers = getAllUsers();
    foreach ($allUsers as $user) {
        if ($user['user_id'] == $userId) {
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $gamertag = $_POST['gamer_tag'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $country = $_POST['country'];
    $city = $_POST['city'];

    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
    } elseif (userExists($userId)) {
        echo "User ID already exists!";
    } else {
        createUser($userId, $gamertag, $firstName, $lastName, $country, $city, $password);
        // echo "Account created successfully!";
        header("Location: user_info.php");
        exit;
    }
}
?>


<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
        crossorigin="anonymous">
</head>
<body>
<div class="container">
        <h1 class="mt-5">Sign Up</h1>
        <form action="sign_up.php" method="post">
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID:</label>
                <input type="number" class="form-control" name="user_id" id="user_id" required>
            </div>
            <div class="mb-3">
                <label for="gamer_tag" class="form-label">Gamer Tag:</label>
                <input type="text" class="form-control" name="gamer_tag" id="gamer_tag" required>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name:</label>
                <input type="text" class="form-control" name="first_name" id="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" class="form-control" name="last_name" id="last_name" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country:</label>
                <input type="text" class="form-control" name="country" id="country" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City:</label>
                <input type="text" class="form-control" name="city" id="city" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>

    <!-- Popup window for the message -->
    <div class="modal" tabindex="-1" id="messageModal">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="messageText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>