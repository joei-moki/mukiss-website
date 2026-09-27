<?php
/**
 * MUKISS - Logout
 * Location: logout.php
 */
require_once __DIR__ . '/includes/auth.php';

$ageVerified = $_SESSION['age_verified'] ?? false;

$_SESSION = [];
session_destroy();

session_start();
$_SESSION['age_verified'] = $ageVerified; // don't force the age gate again this browser session

header('Location: /mukiss/login.php');
exit;
