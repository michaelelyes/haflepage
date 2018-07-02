<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=haflepage', 'root', '');
$showFormular = true;

if(isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['password']) && isset($_POST['password2'])) {
  $error = false;
  $email = $_POST['email'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Not a valid email address!<br>';
    $error = true;
  }
  if(strlen($password) == 0) {
    echo 'Please define a password<br>';
    $error = true;
  }
  if($password != $password2) {
    echo 'Passwords are not identical<br>';
    $error = true;
  }

  if(!$error) {
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    if($user !== false) {
      echo 'Email address already exists<br>';
      $error = true;
    }
  }

  if(!$error) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $statement = $pdo->prepare('INSERT INTO users (email, passwort, vorname, nachname) VALUES (:email, :passwort, :vorname, :nachname)');
    $result = $statement->execute(array('email' => $email, 'passwort' => $password_hash, 'vorname' => $firstname, 'nachname' => $lastname));

    if($result) {
      $url = $_SESSION['url'];
      header('Location:' .$url);
      $showFormular = false;
    } else {
      echo 'Something went wrong<br>';
    }
  }
}

?>
