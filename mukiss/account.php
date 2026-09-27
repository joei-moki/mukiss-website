<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

requireLogin();

$pageTitle = 'My Account | MUKISS';
require_once __DIR__ . '/includes/header.php';
?>

<div class="auth-screen">
    <div class="auth-card">

        <div class="auth-card__logo">MUKISS</div>

        <h2>My Account</h2>

        <p class="subtitle">
            Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!
        </p>

        <div class="notice notice--success">
            You are successfully signed in to your MUKISS account.
        </div>

        <div style="margin-top: 24px;">

            <p>
                <strong>Name:</strong>
                <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
            </p>

            <p>
                <strong>Account Status:</strong>
                Verified
            </p>

        </div>

        <div style="margin-top: 24px;">
            <a href="/mukiss/index.php" class="btn btn-primary btn-block">
                Back to Home
            </a>

            <a href="/mukiss/logout.php"
               class="btn btn-block"
               style="margin-top: 10px;">
                Sign Out
            </a>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>