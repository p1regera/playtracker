<?php 

function addGamePlayed($user_id, $game_id, $played_time){
    global $db;
    $query = "INSERT INTO Hours_played VALUES (:user_id, :game_id, :played_time)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':game_id', $game_id);
    $statement->bindValue(':played_time', $played_time);
    $statement->execute();
    $statement->closeCursor();
}

function getGamesPlayed($user_id) {
    global $db;
    $query = "SELECT game_id, title FROM Hours_played NATURAL JOIN Game WHERE user_id = $user_id";
    $statement = $db->prepare($query);
    $statement->execute(); 
    $results = $statement->fetchAll(); 
    $statement->closeCursor();
    return $results;
 }


function deleteGamePlayed($user_id,$game_id) {
   global $db;
   $query = "DELETE FROM Hours_played WHERE user_id = $user_id AND game_id = $game_id";
   $statement = $db->prepare($query);
   $statement->execute(); 
   $statement->closeCursor();
}



?>