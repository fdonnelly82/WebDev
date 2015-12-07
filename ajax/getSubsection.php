<!DOCTYPE html>
<html>
<head>
<style>

</style>
</head>
<body>

<?php
include_once("config.php");
$q = intval($_GET['q']);

$con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD );
$sthandler = $con->prepare("SELECT * FROM posts WHERE tags LIKE LIKE '%" . $q . "%' OR author LIKE '%" . $q ."%'"); 
$sthandler->execute();

echo "<table>
<tr>
<th>Post Title</th>
<th>Author ID</th>
<th>Post</th>
</tr>";

while ($row = $sthandler->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['userID'] . "</td>";
    echo "<td>" . $row['blogPost'] . "</td>";
    echo "</tr>";
}
echo "</table>";


?>
</body>
</html>