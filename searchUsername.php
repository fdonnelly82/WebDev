<?php
$mysqli = new mysqli('localhost', 'root', '', 'db_webappdev');
$text = $mysqli->real_escape_string($_GET['term']);

$query = "SELECT username FROM users WHERE username LIKE '%$text%' ORDER BY username ASC";
$result = $mysqli->query($query);
$json = '[';
$first = true;

while($row = $result->fetch_assoc()) {
    if (!$first) { $json .=  ','; } else { $first = false; }
    $json .= '{"value":"'.$row['username'].'"}';
}

$json .= ']';
echo $json;
?>

