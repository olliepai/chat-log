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

  $messages = $conn -> query("SELECT * FROM users JOIN messageRecipients ON users.username = '$username' AND users.userID = messageRecipients.toUserID
    JOIN messages ON messageRecipients.messageID = messages.messageID");

  $message = $messages -> fetch();

  if ($message['fromUserID'] != '') {
    print "Messages to <span id='highlight'>$username</span>";
    print "<table>";
    print "<tr>";
    print "<th>From</th>";
    print "<th>Subject</th>";
    print "<th>Body</th>";
    print "</tr>";
    foreach ($messages as $message) {
      print "<tr>";

      $fromUserID = $message['fromUserID'];
      $fromUsers = $conn -> query("SELECT * FROM users WHERE userID = $fromUserID");
      $fromUser = $fromUsers -> fetch();
      $fromUsername = $fromUser["username"];

      print "<td>" .  $fromUsername .  "</td>";
      print "<td>" .  $message['subject'] .  "</td>";
      print "<td>" .  $message['body'] .  "</td>";
      print "</tr>";
    }
    print "</table>";
    print "<br>";
    print "<br>";
  } else {
    print "There are no messages for <span id='highlight'>$username</span><br><br>";
  }
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage() . "<br><br>";
}
?>
