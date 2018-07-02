<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=haflepage', 'root', '');

$error = false;
$userId = $_SESSION['userid'];
$title = $_POST['title'];
//$flyer = $_POST['flyer'];
$time = $_POST['time'];
$date = $_POST['date'];
$street = $_POST['street'];
$streetNumber = $_POST['streetNumber'];
$zip = $_POST['zip'];
$place = $_POST['place'];
$act = $_POST['act'];
$description = $_POST['description'];
$loungeNames = $_POST['loungename'];
$loungeNumbers = $_POST['loungenumber'];
$loungeDescriptions = $_POST['loungedescription'];

if(isset($_POST['reservationCB'])) {
  echo 'CB is CHECKED';
} else {
  echo 'CB is NOT CHECKED';
}
?>
