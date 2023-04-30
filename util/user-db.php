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
function getUserInfo_ID($user_id){
    global $db;
    $query = "SELECT * FROM User WHERE user_id = $user_id ORDER BY first_name, last_name";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
function getUserInfo_FName($firstName){
    global $db;
    $query = "SELECT * FROM User WHERE first_name LIKE '%$firstName%' ORDER BY first_name, last_name";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
function getUserInfo_LName($lastName){
    global $db;
    $query = "SELECT * FROM User WHERE last_name LIKE '%$lastName%' ORDER BY first_name, last_name";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
function getUserInfo_FLName($firstName, $lastName){
    global $db;
    $query = "SELECT * FROM User WHERE first_name LIKE '%$firstName%' AND last_name LIKE '%$lastName%' ORDER BY first_name, last_name";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
function getUserInfo_GTag($gamer_tag){
    global $db;
    $query = "SELECT * FROM User WHERE gamer_tag LIKE '%$gamer_tag%' ORDER BY first_name, last_name";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function updateUserInfo($user_id,$gamer_tag, $first_name, $last_name){
    global $db;
    $query = "UPDATE User SET gamer_tag=:gamer_tag , first_name =:first_name, last_name =:last_name WHERE user_id =:user_id";

    try {
		$statement = $db->prepare($query);
		$statement->bindValue(':gamer_tag', $gamer_tag);
		$statement->bindValue(':first_name', $first_name);
		$statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':user_id', $user_id);
		$statement->execute();
	
		//echo "number of rows affected = " . $statement->rowCount() . "##";
		if ($statement->rowCount() == 0)
	   		echo "No row has been updated <br/>";	
	
		$statement->closeCursor();
	} catch (PDOException $e){
		echo $e->getMessage();
	}
}
?>