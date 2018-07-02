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


if(isset($_POST['loungeCBlist'])) {
  $cb = $_POST['loungeCBlist'];
  $number = count($cb);
  for ($i=0; $i < $number; $i++) {
    $loungeId = $cb[$i];

    $statement = $pdo->prepare("UPDATE lounges SET isReserved = :isReserved WHERE id = :loungeId");
    $result = $statement->execute(array('isReserved' => 1, 'loungeId' => $loungeId));
    $lounge = $statement->fetch();

    $statement = $pdo->prepare("SELECT * FROM lounges WHERE id = :loungeId");
    $result = $statement->execute(array('loungeId' => $loungeId));
    $lounge = $statement->fetch();


    $statement = $pdo->prepare("SELECT * FROM users WHERE id = :userId");
    $result = $statement->execute(array('userId' => $_SESSION['userid']));
    $user = $statement->fetch();


    $statement = $pdo->prepare("SELECT * FROM events WHERE id = :eventId");
    $result = $statement->execute(array('eventId' => $_SESSION['eventId']));
    $event = $statement->fetch();

    $statement = $pdo->prepare("SELECT * FROM users WHERE id = :userId");
    $result = $statement->execute(array('userId' => $event['userId']));
    $eventUser = $statement->fetch();

    echo $user['email'];
    echo $eventUser['email'];
    $text = "Bestätigung der Reservation der folgenden Lounge:";
    $lname = $lounge['name'];
    $ename = $event['title'];
    $minKons = $lounge['minConsum'];

    echo $text ." ". $lname ."Für folgenden Event: ". $ename . " Mindestkonsum ist: " .$minKons;
/*
    $empfaenger = echo $user['email'];
    $betreff = "Lounge reservation";
    $from = "From: No Reply <noReply@domain.de>";
    $text = "Bestätigung der Reservation der folgenden Lounge:
            ".echo $lounge['name'];

    mail($empfaenger, $betreff, $text, $from);

    $empfaenger = echo $eventUser['email'];
    $betreff = "Lounge reservation für Ihren Event";
    $from = "From: No Reply <noReply@domain.de>";
    $text = "Folgende Lounge wurde reserviert: ";
            ".echo $lounge['name'];

    mail($empfaenger, $betreff, $text, $from);*/
  }
} else {
  echo 'No Checkboxes selected';
}
?>
