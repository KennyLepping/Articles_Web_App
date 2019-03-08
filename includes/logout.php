<?php ob_start(); ?>
<?php session_start(); // Starts session for access to user specific information ?>

<?php 

$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['user_role'] = null;

header("Location: /phpfun/Articles_Web_App");

?>