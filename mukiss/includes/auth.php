<?php
/**
 * MUKISS - Authentication Helpers
 * Location: includes/auth.php
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Returns true if a customer/admin user is logged in. */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/** Returns true if the logged-in user is an admin. */
function isAdmin(): bool
{
    return isLoggedIn() && ($_SESSION['role'] ?? '') === 'admin';
}

/** Redirects to login.php if the visitor is not logged in. */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /mukiss/login.php');
        exit;
    }
}

/** Redirects away if the visitor is not an admin. Protects all admin/ pages. */
function requireAdmin(): void
{
    if (!isAdmin()) {
        header('Location: /mukiss/login.php');
        exit;
    }
}

/** Generates (or reuses) a CSRF token for the current session. */
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Validates a submitted CSRF token against the session token. */
function csrfCheck(?string $token): bool
{
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}
