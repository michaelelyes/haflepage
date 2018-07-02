<?php include('template.php');

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'haflepage';

$conn = new mysqli($servername, $username, $password, $dbname);
$eventId = $_GET['eventId'];
$sql = "DELETE FROM events WHERE id='$eventId'";
$result = $conn->query($sql);
$event = $result->fetch_assoc();
?>
