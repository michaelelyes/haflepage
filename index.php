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

  <?php
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'haflepage';

  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = 'SELECT * FROM events';
  $result = $conn->query($sql);

  while($event = $result->fetch_assoc()) {
    $href = 'event.php?id=' . $event['id'];
    $imagePath = $event['flyer'];
    ?>
    <div class="container">
      <a href=<?php echo $href ?>>
        <img src=<?php echo $imagePath ?>>
        <div class="overlay">
          <div class="text"><?php echo $event['title'] ?></div>
        </div>
      </a>
    </div>
  <?php
  }
  ?>
</div>

<script src="script.js"></script>
</body>
</html>
