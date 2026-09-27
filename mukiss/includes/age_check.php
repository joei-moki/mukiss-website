<?php
/**
 * MUKISS - Age Verification Gate
 * Location: includes/age_check.php
 *
 * Include this at the very top of any public page (after auth.php starts
 * the session) to make sure the visitor confirmed the age gate first.
 * This is a session-based prototype gate only, not a real age-verification
 * / identity-proofing system.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['age_verified'])) {
    header('Location: /mukiss/age_verify.php');
    exit;
}
