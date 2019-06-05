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
  
  $messages = $conn -> query("SELECT * FROM users JOIN messages ON users.username = '$username' AND users.userID = messages.fromUserID 
    JOIN messageRecipients ON messages.messageID = messageRecipients.messageID");

  $message = $messages -> fetch();

  if ($message['toUserID'] != '') {
    print "Messages from <span id='highlight'>$username</span>";
    print "<table>";
    print "<tr>";
    print "<th>To</th>";
    print "<th>Subject</th>";
    print "<th>Body</th>";
    print "</tr>";
    foreach ($messages as $message) {
      print "<tr>";

      $toUserID = $message['toUserID'];
      $toUsers = $conn -> query("SELECT * FROM users WHERE userID = $toUserID");
      $toUser = $toUsers -> fetch();
      $toUsername = $toUser["username"];

      print "<td>" .  $toUsername .  "</td>";
      print "<td>" .  $message['subject'] .  "</td>";
      print "<td>" .  $message['body'] .  "</td>";
      print "</tr>";
    }
    print "</table>";
    print "<br>";
    print "<br>";
  } else {
    print "There are no messages from <span id='highlight'>$username</span><br><br>";
  }
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage() . "<br><br>";
}
?>
