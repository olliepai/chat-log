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

  $from = $_GET['from'];
  $recipients = explode(",", $_GET['to']);
  $subject = $_GET['subject'];
  $message = $_GET['message'];

  $fromUsers = $conn -> query("SELECT * FROM users WHERE username = '$from'");
  $fromUser = $fromUsers -> fetch();
  $fromUserID = $fromUser["userID"];

  $insertMessage = "INSERT INTO messages (subject, body, fromUserID) VALUES ('$subject', '$message', $fromUserID)";
  $statement1 = $conn -> exec($insertMessage);

  $messageID = $conn -> lastInsertId();

  $notification = 'Your message has been sent to ';

  foreach($recipients as $recipient) {
    $toUsers = $conn -> query("SELECT * FROM users WHERE username = '$recipient'");
    $toUser = $toUsers -> fetch();
    $toUserID = $toUser["userID"];

    $insertMessageRecipients = "INSERT INTO messageRecipients (messageID, toUserID) VALUES ($messageID, $toUserID)";
    $statement2 = $conn -> exec($insertMessageRecipients);

    $notification = $notification . "<span id='highlight'>$recipient</span>, ";
  }

  $notification = substr($notification, 0, strlen($notification) - 2);
  echo $notification . "<br><br>";
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage() . "<br><br>";
}
?>
