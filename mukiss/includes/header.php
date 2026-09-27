<?php
/**
 * MUKISS - Page Head
 * Location: includes/header.php
 *
 * Expects an optional $pageTitle variable to be set before including this file.
 */
$pageTitle = $pageTitle ?? 'MUKISS';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($pageTitle); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/mukiss/assets/css/style.css">
</head>
<body>
