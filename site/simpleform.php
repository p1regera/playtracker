<?php
require("..\util\connect-db.php");
require("..\util\friend-db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['actionBtn']) && $_POST['actionBtn'] == 'Add Friend') {
        addFriend($_POST['name'], $_POST['major'], $_POST['year']);
    }

    if(!empty($_POST['deleteBtn']) && $_POST['deleteBtn'] == 'delete') {
        deleteFriend($_POST['name']);
    }

    if(!empty($_POST['UpdateBtn']) && $_POST['UpdateBtn'] == 'Update') {
        updateFriend($_POST['name'], $_POST['major'], $_POST['year']);
    }
}

$friends = getAllFriends();
?>

<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Friend Book</h1>
        <form name="mainForm" action="simpleform.php" method="post">   
            <div class="form-group">
                <label for="name">Your name:</label>
                <input type="text" class="form-control" name="name" required />     
            </div> 
            <div class="form-group">
                <label for="major">Major:</label>
                <input type="text" class="form-control" name="major" required />     
            </div>  
            <div class="form-group">
                <label for="year">Year:</label>
                <input type="text" class="form-control" name="year" required />     
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="actionBtn" value="Add Friend" />
                <input type="submit" class="btn btn-primary" name="UpdateBtn" value="Update" />
            </div>
        </form> 

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Major</th>
                    <th scope="col">Year</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($friends as $friend) : ?>
                <tr>
                    <td><?php echo $friend['name']; ?></td>
                    <td><?php echo $friend['major']; ?></td>
                    <td><?php echo $friend['year']; ?></td>
                    <td>
                        <form action="simpleform.php" method="post">
                            <input type="hidden" name="name" value="<?php echo $friend['name']; ?>" />
                            <input type="submit" class="btn btn-danger" name="deleteBtn" value="delete" />
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
