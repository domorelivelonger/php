<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (mail("domorelivelonger@gmail.com", "Test mail", "Mail system checking")) {
echo "ok";
} else {
echo "error";}
?>

