<?php
//See original: https://www.w3schools.com/php/php_mysql_connect.asp
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "chatlog";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);

  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $username = $_GET['username'];
  $password = $_GET['password'];
  $email = $_GET['email'];
  $firstName = $_GET['first-name'];
  $lastName = $_GET['last-name'];

  $sql = "INSERT INTO users (username, password, email, `first name`, `last name`)
    VALUES ('$username', '$password', '$email', '$firstName', '$lastName')";
  $statement = $conn -> exec($sql);

  echo "New user <span id='highlight'>$username</span> added<br><br>";
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage() . "<br><br>";
}
?>
