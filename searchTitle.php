<?php
$mysqli = new mysqli('localhost', 'root', '', 'db_webappdev');
$text = $mysqli->real_escape_string($_GET['term']);

$query = "SELECT title FROM posts WHERE title LIKE '%$text%' ORDER BY title ASC";
$result = $mysqli->query($query);
$json = '[';
$first = true;

while($row = $result->fetch_assoc()) {
    if (!$first) { $json .=  ','; } else { $first = false; }
    $json .= '{"value":"'.$row['title'].'"}';
}

$json .= ']';
echo $json;
?>

