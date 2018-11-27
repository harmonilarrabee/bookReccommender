<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "book_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM genre";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - name: " . $row["name"]. " ";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<div class="title">Book Recommender</div>