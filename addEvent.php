<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=haflepage', 'root', '');


function random_string() {
   if(function_exists('random_bytes')) {
      $bytes = random_bytes(16);
      $str = bin2hex($bytes);
   } else if(function_exists('openssl_random_pseudo_bytes')) {
      $bytes = openssl_random_pseudo_bytes(16);
      $str = bin2hex($bytes);
   } else if(function_exists('mcrypt_create_iv')) {
      $bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
      $str = bin2hex($bytes);
   } else {
      //Bitte euer_geheim_string durch einen zufälligen String mit >12 Zeichen austauschen
      $str = md5(uniqid('euer_geheimer_string', true));
   }
   return $str;
}

//Überprüfe auf den 'Angemeldet bleiben'-Cookie
if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier']) && isset($_COOKIE['securitytoken'])) {
   $identifier = $_COOKIE['identifier'];
   $securitytoken = $_COOKIE['securitytoken'];

   $statement = $pdo->prepare("SELECT * FROM securitytokens WHERE identifier = ?");
   $result = $statement->execute(array($identifier));
   $securitytoken_row = $statement->fetch();

   if(sha1($securitytoken) !== $securitytoken_row['securitytoken']) {
      die('Ein vermutlich gestohlener Security Token wurde identifiziert');
   } else { //Token war korrekt
      //Setze neuen Token
      $neuer_securitytoken = random_string();
      $insert = $pdo->prepare("UPDATE securitytokens SET securitytoken = :securitytoken WHERE identifier = :identifier");
      $insert->execute(array('securitytoken' => sha1($neuer_securitytoken), 'identifier' => $identifier));
      setcookie("identifier",$identifier,time()+(3600*24*365)); //1 Jahr Gültigkeit
      setcookie("securitytoken",$neuer_securitytoken,time()+(3600*24*365)); //1 Jahr Gültigkeit

      //Logge den Benutzer ein
      $_SESSION['userid'] = $securitytoken_row['user_id'];
   }
}



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

$upload_folder = 'images/';
$fileName = pathinfo($_FILES['flyer']['name'], PATHINFO_FILENAME);
$extension = strtolower(pathinfo($_FILES['flyer']['name'], PATHINFO_EXTENSION));

$allowed_extensions = array('png', 'jpg', 'jpeg');
if(!in_array($extension, $allowed_extensions)) {
  die('Please upload one of these types: PNG, JPG, JPEG');
}

$max_size = 500*1024; //500 KB
if($_FILES['flyer']['size'] > $max_size) {
 die('Only images smaller than 500kb');
}

if(function_exists('exif_imagetype')) {
  $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
  $detected_type = exif_imagetype($_FILES['flyer']['tmp_name']);
  if(!in_array($detected_type, $allowed_types)) {
    die('Please upload just an image');
  }
}

$new_path = $upload_folder.$fileName.'.'.$extension;

if(file_exists($new_path)) {
  $id = 1;
  do {
    $new_path = $upload_folder.$fileName.'_'.$id.'.'.$extension;
    $id++;
  } while(file_exists($new_path));
}

move_uploaded_file($_FILES['flyer']['tmp_name'], $new_path);

$statement = $pdo->prepare('INSERT INTO events (userId, title, flyer, time, date, street, streetNumber, addressId, act, price, description)
             VALUES (:userId, :title, :flyer, :time, :date, :street, :streetNumber, :addressId, :act, :price, :description)');
$result = $statement->execute(array('userId' => $userId, 'title' => $title, 'flyer' => $new_path, 'time' => $time, 'date' => $date, 'street' => $street,
          'streetNumber' => $streetNumber, 'addressId' => $addressId, 'act' => $act, 'price' => $price, 'description' => $description));

if(isset($_POST['reservationCB'])) {
  $sessionUser = $_SESSION['userid'];
  $stmt = $pdo->prepare('SELECT id FROM events WHERE userId = :userId ORDER BY id DESC LIMIT 1');
  $idResult = $stmt->execute(array('userId' => $sessionUser));
  $event = $stmt->fetch();
  $eventId = $event['id'];

  $loungeStatement = $pdo->prepare('INSERT INTO lounges (name, number, minConsum, description, eventId)
                     VALUES (:name, :number, :minConsum, :description, :eventId)');

  for($i = 0; $i < count($loungeNames); $i++) {
    $loungeResult = $loungeStatement->execute(array('name' => $loungeNames[$i], 'number' => $loungeNumbers[$i],
                    'minConsum' => $loungeConsum[$i], 'description' => $loungeDescriptions[$i], 'eventId' => $eventId));
  }
}

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
