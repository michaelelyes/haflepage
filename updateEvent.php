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
$eventId = $_GET['eventId'];
$sql = "SELECT * FROM events WHERE id='$eventId'";
$result = $conn->query($sql);
$event = $result->fetch_assoc();

$title = $event['title'];
$flyer = $event['flyer'];
$time = $event['time'];
$date = $event['date'];
$street = $event['street'];
$streetNumber = $event['streetNumber'];
$addressId = $event['addressId'];
$act = $event['act'];
$price = $event['price'];
$description = $event['description'];

$sql = "SELECT * FROM address WHERE id='$addressId'";
$result = $conn->query($sql);
$address = $result->fetch_assoc();

$zip = $address['zip'];
$place = $address['place'];

$sql = "SELECT * FROM lounges WHERE eventId='$eventId'";
$result = $conn->query($sql);
$lounge = $result->fetch_assoc();

?>

<div id="main" class="main">
  <div class="formContainer" id="formContainer">
  <form class="uploadEvent" id="uploadEvent" action="updateActualEvent.php" method="post" enctype="multipart/form-data">
    <legend>Upload Event</legend>
    <input type="text" name="eventId" value="<?php echo $eventId ?>" style="display:none;">
    <input type="text" placeholder="Event name" name="title" value="<?php echo $title ?>" required>
    <input type="text" placeholder="Flyer" name="flyer" value="<?php echo $flyer ?>" disabled required>
    <input type="time" placeholder="Event time" name="time" value="<?php echo $time ?>" required>
    <input type="date" placeholder="Event date" name="date" value="<?php echo $date?>" required>
    <input type="text" placeholder="Street" name="street" class="eventPlace big" id="placeRight" value="<?php echo $street ?>" required>
    <input type="text" placeholder="Nr." name="streetNumber" class="eventPlace small" value="<?php echo $streetNumber ?>" required>
    <input type="number" placeholder="Zip" name="zip" class="eventPlace small" id="placeRight" value="<?php echo $zip ?>" required>
    <input type="text" placeholder="Place" name="place" class="eventPlace big" value="<?php echo $place?>" required>
    <input type="text" placeholder="Act" value="<?php echo $act ?>" name="act">
    <input type="number" placeholder="Price" value="<?php echo $price ?>" name="price">
    <textarea rows="4" cols="50" placeholder="Description" name="description" required><?php echo $description ?></textarea>
    <!-- RESERVATION -->
    <div class="resPossible">
      <input type="checkbox" id="resCheck" name="reservationCB" onclick="showReservation()" value="reservation" style="width:6%;">
      <label for="checkbox">Are reservations possible?</label>
    </div>
    <div id="ifReservationActive" style="display:none;">
      <input type="text" placeholder="Lounge name" name="loungename[]" id="lounge1">
      <input type="number" placeholder="Number of People" name="loungenumber[]" id="lounge1Number">
      <input type="number" placeholder="Minimum consumption" name="loungeconsum[]" step="any" id="lounge1Consum">
      <textarea rows="4" cols="50" placeholder="Description" name="loungedescription[]" id="lounge1Desc"></textarea>
    </div>
    <button type="button" id="reservationButton" style="display:none;" onclick="addLounge()">Add Lounge</button>
    <button type="submit" onclick="addEvent()">Upload</button>
</form>
</div>
</div>

<script src="script.js"></script>
</body>
</html>
