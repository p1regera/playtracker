<?php 
function getAllGames(){
    global $db;
    $query = "SELECT * FROM Game";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function createGame($game_id, $studio_id, $release_date, $title, $genre) {
    global $db;
    $query = "INSERT INTO Game VALUES (:game_id, :studio_id, :release_date, :title, :genre)";
    $statement = $db->prepare($query);
    $statement->bindValue(':game_id', $game_id);
    $statement->bindValue(':studio_id', $studio_id);
    $statement->bindValue(':release_date', $release_date);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':genre', $genre);
    $statement->execute();
    $statement->closeCursor();
}

function getGameInfo_ID($game_id) {
    global $db;
    $query = "SELECT * FROM Game WHERE game_id = $game_id ORDER BY release_date";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getGameInfo_Title($title) {
    global $db;
    $query = "SELECT * FROM Game WHERE title LIKE '%$title%' ORDER BY release_date";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getGameInfo_RDate($release_date) {
    global $db;
    $query = "SELECT * FROM Game WHERE release_date = $release_date ORDER BY release_date";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getStudioName($game_id) {
    global $db;
    $query = "SELECT Name FROM Game NATURAL JOIN Studio WHERE game_id = $game_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

?>