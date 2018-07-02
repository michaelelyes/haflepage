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
$userId = $_SESSION['userid'];
$sql = "SELECT * FROM events WHERE userId='$userId'";
$result = $conn->query($sql);
?>

<div id="main" class="main">
  <table id="myEventsTable" class="myEventsTable">
  <tr>
    <th>Event name</th>
    <th id="txtHint">Action</th>
  </tr>
  <?php while($event = $result->fetch_assoc()) {
    $eventId = $event['id'];
    $href = 'updateEvent.php?eventId=' . $event['id']; ?>
  <tr>
    <td><?php echo $event['title']; ?></td>
    <td>
      <a href=<?php echo $href ?>><i class="material-icons">edit</i></a>
      <i id="deleteIcon" data-eventid="<?php echo $eventId ?>" class="material-icons" onclick="deleteEvent(event, this)">delete</i>
    </td>
  </tr> <?php } ?>
</table>
</div>

<script src="script.js"></script>
<script>
function deleteEvent(e, element) {
  var row = element.parentNode.parentNode.rowIndex;
  var deleteEvent = confirm('Are you sure you want to delete this event?');
  if(deleteEvent) {
    var eventId = e.target.getAttribute('data-eventid');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById('myEventsTable').deleteRow(row);
      }
    };
    xmlhttp.open('GET', 'deleteEvent.php?eventId=' + eventId, true);
    xmlhttp.send();
  }
}
</script>
</body>
</html>
