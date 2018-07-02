<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=haflepage', 'root', '');

//remember me function
function random_string() {
  if (function_exists('random_bytes')) {
    $bytes = random_bytes(16);
    $str = bin2hex($bytes);
  } else if(function_exists('openssl_random_pseudo_bytes')) {
    $bytes = openssl_random_pseudo_bytes(16);
    $str = bin2hex($bytes);
  } else if (function_exists('mcrypt_create_iv')) {
    $bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
    $str = bin2hex($bytes);
  } else {
    $str = md5(uniqueid('', true));
  }
  return $str;
}

if(isset($_POST['email']) && isset($_POST['password'])) {
$email = $_POST['email'];
$password = $_POST['password'];

$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$result = $statement->execute(array('email' => $email));
$user = $statement->fetch();

 //Überprüfung des Passworts
if ($user !== false && password_verify($password, $user['passwort'])) {
 $_SESSION['userid'] = $user['id'];

 //Möchte der Nutzer angemeldet bleiben?
 if (isset($POST['angemeldet_bleiben'])) {
   $identifier = random_string();
   $securitytoken = random_string();

   $insert = $pdo->prepare("INSERT INTO securitytokens (user_id, identifier, securitytoken)
   VALUES (:user_id, :identifier, :securitytoken)");
   $insert->execute(array('user_id' => $_SESSION['userid'], 'identifier' => $identifier, 'securitytoken' => $securitytoken));
   setcookie('identifier',$identifier,time()+(3600*24*365));//1 Jahr gültig
   setcookie('securitytoken',$securitytoken,time()+(3600*24*365));//1 Jahr gültig
 }

 $url = $_SESSION['url'];
 header('Location:' .$url);
 //die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
} else {
 $errorMessage = "E-Mail oder Passwort war ungültig<br>";
}
}
?>
