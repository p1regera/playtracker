<?php 
function getAllUsers(){
    global $db;
    $query = "SELECT * FROM User";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function createUser($userId, $gamertag, $firstName, $lastName, $country, $city, $password) {
    global $db;
    $query = "INSERT INTO User VALUES (:user_id, :gamer_tag, :first_name, :last_name, :country, :city, :password)";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userId);
    $statement->bindValue(':gamer_tag', $gamertag);
    $statement->bindValue(':first_name', $firstName);
    $statement->bindValue(':last_name', $lastName);
    $statement->bindValue(':country', $country);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':password', $hashed_password);
    $statement->execute();
    $statement->closeCursor();
}

function getGamerTag($user_id) {
    global $db;
    $query = "SELECT gamer_tag FROM User WHERE user_id = $user_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getFullName($user_id) {
    global $db;
    $query = "SELECT first_name, last_name FROM User WHERE user_id = $user_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getLocation($user_id) {
    global $db;
    $query = "SELECT city, country FROM User WHERE user_id = $user_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
?>