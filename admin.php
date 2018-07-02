<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php include('template.php'); ?>

<div id="main" class="main">
  <div class="formContainer" id="formContainer">
  <form class="uploadEvent" id="uploadEvent" action="addEvent.php" method="post" enctype="multipart/form-data">
    <legend>Upload Event</legend>
    <input type="text" placeholder="Event name" name="title" required>
    <input type="file" placeholder="Flyer" name="flyer" required>
    <input type="time" placeholder="Event time" name="time" required>
    <input type="date" placeholder="Event date" name="date" required>
    <input type="text" placeholder="Street" name="street" class="eventPlace big" id="placeRight" required>
    <input type="text" placeholder="Nr." name="streetNumber" class="eventPlace small" required>
    <input type="number" placeholder="Zip" name="zip" class="eventPlace small" id="placeRight" required>
    <input type="text" placeholder="Place" name="place" class="eventPlace big" required>
    <input type="text" placeholder="Act" name="act">
    <input type="number" placeholder="Price" name="price">
    <textarea rows="4" cols="50" placeholder="Description" name="description" required></textarea>
    <!-- RESERVATION -->
    <div class="resPossible">
      <input type="checkbox" id="resCheck" name="reservationCB" onclick="showReservation()" value="reservation" style="width:6%;">
      <label for="resCheck">Are reservations possible?</label>
    </div>
    <div id="ifReservationActive" style="display:none;">
      <input type="text" name="checkIfHere" style="display:none;">
      <input type="text" placeholder="Lounge name" name="loungename[]" id="lounge1">
      <input type="number" placeholder="Number of People" name="loungenumber[]" id="lounge1Number">
      <input type="number" placeholder="Minimum consumption" name="loungeconsum[]" step="any" id="lounge1Consum">
      <textarea rows="4" cols="50" placeholder="Description" name="loungedescription[]" id="lounge1Desc" style="margin-bottom:0;"></textarea>
      <input type="button" value="-" class="removeLoungeButton" onclick="removeFirstLounge(this)"></input>
    </div>
    <button type="button" id="reservationButton" style="display:none;" onclick="addLounge()">Add Lounge</button>
    <button type="submit">Upload</button>
</form>
</div>
</div>

<script src="script.js"></script>
</body>
</html>
