<?php 
function userHasReviewed($userId, $gameId) {
    global $db;
    $query = "SELECT * FROM Review WHERE user_id = :user_id AND game_id = :game_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userId);
    $statement->bindValue(':game_id', $gameId);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result ? true : false;
}

// function createReview($userId, $gameId, $rating, $comments) {
//     global $db;
//     $query = "INSERT INTO Review VALUES (:user_id, :game_id, :rating, :comments)";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':user_id', $userId);
//     $statement->bindValue(':game_id', $gameId);
//     $statement->bindValue(':rating', $rating);
//     $statement->bindValue(':comments', $comments);
//     $statement->execute();
//     $statement->closeCursor();
// }

function createReview($userId, $gameId, $rating, $comments) {
    global $db;
    $query = "INSERT INTO Review (user_id, game_id, review_id, rating, comments) VALUES (:user_id, :game_id, :review_id, :rating, :comments)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userId);
    $statement->bindValue(':game_id', $gameId);
    $review_id = uniqid(); // Generate a unique review_id
    $statement->bindValue(':review_id', $review_id);
    $statement->bindValue(':rating', $rating);
    $statement->bindValue(':comments', $comments);
    $statement->execute();
    $statement->closeCursor();
}

?>