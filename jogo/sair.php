<?php
session_start();
ob_start();
unset($_SESSION['username']);
$_SESSION['msg'] = "<p style='color: green'>Deslogado com sucesso!</p>";

header("Location: ../login/login.php");
?>