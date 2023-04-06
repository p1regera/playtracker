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
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $userId);
    $statement->bindValue(':gamer_tag', $gamertag);
    $statement->bindValue(':first_name', $firstName);
    $statement->bindValue(':last_name', $lastName);
    $statement->bindValue(':country', $country);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}

?>