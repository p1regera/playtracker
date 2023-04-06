<?php
require("..\util\connect-db.php");
require("..\util\user-db.php");

$user_id = 0;
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
    <div class="container">
        <h1 class="mt-5">User Page: <?php echo $gamer_tag[0][0] ?></h1>
        <p><b> User <?php echo $user_id ?> Name:</b> <?php echo $full_name[0][0];  echo " "; echo $full_name[0][1] ?> </p>
        <p><b>User <?php echo $user_id ?> Location:</b> <?php echo $location[0][0];  echo ", "; echo $location[0][1] ?> </p>

        
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>