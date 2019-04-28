<?php
session_start();
$name=$_SESSION['SESS_FIRST_NAME'];
echo 'hello'.$name;
?>