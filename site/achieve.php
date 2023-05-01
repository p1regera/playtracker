<?php
require("../util/connect-db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $achievement_id = $_POST['achievement_id'];
    $game_id = $_POST['game_id'];
    $user_id = $_SESSION['user_id'];

    // Insert the achieved achievement into the database
    $query = "INSERT INTO Achieved (achievement_id, user_id) VALUES (:achievement_id, :user_id)";
    $statement = $db->prepare($query);
    $statement->bindValue(':achievement_id', $achievement_id);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $statement->closeCursor();

    // Redirect the user back to the game achievements page
    header("Location: game_achievements.php?game_id=$game_id");
    exit();
}
