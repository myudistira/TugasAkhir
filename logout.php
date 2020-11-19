<?php
session_start();
session_destroy();
header("Location: index.html"); // Redirecting To Home Page
?>
