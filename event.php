<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php include('template.php');

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'haflepage';

$conn = new mysqli($servername, $username, $password, $dbname);
$eventId = $_GET['id'];
$href = 'reserve.php?eventId=' . $eventId;
$sql = "SELECT events.*, address.zip, address.place FROM events INNER JOIN address ON events.addressId=address.id WHERE events.id='$eventId'";
$result = $conn->query($sql);
$event = $result->fetch_assoc();
$imagePath = $event['flyer'];


$loungeSql = "SELECT * FROM lounges WHERE eventId = '$eventId'";
$loungeResult = $conn->query($loungeSql);

?>

<div id="main" class="main" style="margin-top:20px;">
  <div class="container">
    <img src=<?php echo $imagePath ?>>
  </div>
  <div id="description" class="description">
    <h1>Description</h1>
    <p><?php echo $event['description']; ?></p>
  </div>
  <div id="column date" class="column date">
    <h1>Date</h1>
    <p><?php echo date('H:i', strtotime($event['time'])); echo ' Uhr' ?></p>
    <p><?php echo date('d F Y',strtotime($event['date'])); ?></p>
  </div>
  <div id="column place" class="column place">
    <h1>Place</h1>
    <p><?php echo $event['street']; echo ' '; echo $event['streetNumber']; ?></p>
    <p><?php echo $event['zip']; echo ' '; echo $event['place']; ?></p>
  </div>
  <div id="column act" class="column act">
    <h1>Act</h1>
    <p><?php echo $event['act']; ?></p>
  </div>
  <div id="column price" class="column price">
    <h1>Price</h1>
    <p><?php echo $event['price']; echo ' CHF'?></p>
  </div>
  <?php if(isset($_SESSION['userid']) && $loungeResult->num_rows > 0) { ?>
  <div class="footer" id="footer">
  <a href=<?php echo $href ?>><button class="reserve" id="reserve" type="button">Reserve</button></a>
  </div>
  <?php } ?>
</div>

<script src="script.js"></script>
</body>
</html>
