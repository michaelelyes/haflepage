<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=haflepage', 'root', '');

$error = false;
$userId = $_SESSION['userid'];
$eventId = $_POST['eventId'];
$title = $_POST['title'];
//$flyer = $_POST['flyer'];
$time = $_POST['time'];
$date = $_POST['date'];
$street = $_POST['street'];
$streetNumber = $_POST['streetNumber'];
$zip = $_POST['zip'];
$place = $_POST['place'];
$act = $_POST['act'];
$price = $_POST['price'];
$description = $_POST['description'];
$loungeNames = $_POST['loungename'];
$loungeNumbers = $_POST['loungenumber'];
$loungeConsum = $_POST['loungeconsum'];
$loungeDescriptions = $_POST['loungedescription'];

$statement = $pdo->prepare("SELECT * FROM address WHERE zip = :zip");
$result = $statement->execute(array('zip' => $zip));
$address = $statement->fetch();

if ($address !== false) {
  $addressId = $address['id'];
}


$statement = $pdo->prepare('UPDATE events SET userId=:userId, title=:title, time=:time, date=:date, street=:street,
          streetNumber=:streetNumber, addressId=:addressId, act=:act, price=:price, description=:description WHERE id=:eventId');
$result = $statement->execute(array('userId' => $userId, 'title' => $title, 'time' => $time, 'date' => $date, 'street' => $street,
          'streetNumber' => $streetNumber, 'addressId' => $addressId, 'act' => $act, 'price' => $price, 'description' => $description, 'eventId' => $eventId));


if(isset($_POST['reservationCB'])) {
  if($result && $loungeResult) {
    header('Location:index.php');
  }
} else {
  if($result) {
    header('Location:index.php');
  }
}
?>
