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

/*$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'haflepage';

<label for="loungeCB"><?php echo $lounge['number'] .' Personen' ?></label><br>
<label for="loungeCB" style="display:block"><?php echo $lounge['minConsum'] . ' CHF Mindestkonsum' ?></label><br>
<label for="loungeCB"><?php echo $lounge['description'] ?></label><br>

$conn = new mysqli($servername, $username, $password, $dbname);
$eventId = $_GET['id'];
$sql = "SELECT * FROM lounges WHERE eventId = :eventId";
$result = $conn->query($sql);
$event = $result->fetch_assoc();
*/
$pdo = new PDO('mysql:host=localhost;dbname=haflepage', 'root', '');

$statement = $pdo->prepare("SELECT * FROM lounges WHERE eventId = :eventId");
$result = $statement->execute(array('eventId' => $_GET['eventId']));
?>

<div id="main" class="main" style="margin-top:50px; color:white;">
  <form class="loungeFormContainer" action="reserveLounge.php" method="post">
  <?php
  while ($lounge = $statement->fetch(PDO::FETCH_ASSOC)) {?>

    <?php
    $isReserved = false;
    if($lounge['isReserved'] == 1){$isReserved = true;}
    if($isReserved){
    ?>
    <div class="tooltip">
    <span class="tooltiptext">Sold out</span><?php } ?>

    <div id="loungeContainer" class="loungeContainer">
      <input type="checkbox" id="loungeCB<?php echo $lounge['id']?>" name="loungeCBlist[]" value="<?php echo $lounge['id']?>" <?php if($isReserved){?>disabled<?php }?>>
      <div class="labelDiv" <?php if($isReserved){?>style="opacity: 0.5;"<?php }?>>
        <label for="loungeCB<?php echo $lounge['id']?>">
          <?php echo $lounge['name'] ?><br>
          <?php echo $lounge['number'] .' Personen' ?><br>
          <?php echo $lounge['minConsum'] . ' CHF Mindestkonsum' ?><br>
          <?php echo $lounge['description'] ?>
          <input type="hidden" value="<?php echo $lounge['isReserved']?>">
        </label><br>
      </div>
    </div>
  <?php if($isReserved){ ?>
  </div> <?php } ?>

  <?php
  }
  $_SESSION['eventId'] = $_GET['eventId'];
  ?>
  <button type="submit">Reservieren</button>
</form>
</div>

<script src="script.js"></script>
</body>
</html>
