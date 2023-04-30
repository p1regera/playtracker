<?php 

function addFriend($user_id1, $user_id2){
    global $db;
    $query = "INSERT INTO Friends_with VALUES (:user_id1, :user_id2)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id1', $user_id1);
    $statement->bindValue(':user_id2', $user_id2);
    $statement->execute();
    $statement->closeCursor();
}

function deleteFriend($user_id1, $user_id2){
   global $db;
   $query = "DELETE FROM Friends_with WHERE user_id1 = $user_id1 AND user_id2 = $user_id2";
   $statement = $db->prepare($query);
   $statement->execute(); 
   $statement->closeCursor();
}

function getFriends($user_id1) {
   global $db;
   $query = "SELECT gamer_tag, user_id2 FROM Friends_with, User WHERE user_id1 = $user_id1 AND user_id2 = user_id";
   $statement = $db->prepare($query);
   $statement->execute(); 
   $results = $statement->fetchAll(); 
   $statement->closeCursor();
   return $results;
}

?>