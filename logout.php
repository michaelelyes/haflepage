<?php
session_start();
session_destroy();
$url = $_SESSION['url'];
header('Location:' .$url);
exit;
?>
