<?php
session_start();
session_unset();
unset($_SESSION['login']);
header("location:login.php");