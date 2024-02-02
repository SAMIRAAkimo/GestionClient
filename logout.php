<?php

session_destroy();
session_start();
unset($_SESSION['email']);
unset($_SESSION['id']);
unset($_SESSION['statut']);

header('location:login.php');

