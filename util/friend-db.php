<?php
function addFriend($name, $major, $year){
global $db;
// $query = "INSERT INTO friends VALUES ($name, $major, $year)";
// $statement = $db->query($query);

$query = "INSERT INTO friends VALUES (:name, :major, :year)";
$statement = $db->prepare($query);
$statement->bindValue(':name', $name);
$statement->bindValue(':major', $major);
$statement->bindValue(':year', $year);
$statement->execute();
$statement->closeCursor();
}

//returns an array of all rows of data from the friends table.
function getAllFriends(){
global $db;
$query = "SELECT * FROM friends";
$statement = $db->prepare($query);
$statement->execute();
$results = $statement->fetchAll();
$statement->closeCursor();
return $results;


// $statement = $db->query($query);
// $results = $statement->fetchAll();
// $statement->closeCursor();
// return $results;
}

function deleteFriend($name){
global $db;
$query = "DELETE FROM friends WHERE name = :name";
$statement = $db->prepare($query);
$statement->bindValue(':name', $name);
$statement->execute();
$statement->closeCursor();
}

function updateFriend($name, $major, $year){
global $db;
$query = "UPDATE friends SET major = :major, year = :year WHERE name = :name";
$statement = $db->prepare($query);
$statement->bindValue(':name', $name);
$statement->bindValue(':major', $major);
$statement->bindValue(':year', $year);
$statement->execute();
$statement->closeCursor();
}

?>