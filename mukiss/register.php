<?php
/**
 * MUKISS - Create Account
 * Location: register.php
 */
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

if (isLoggedIn()) {
    header('Location: /mukiss/account.php');
    exit;
}

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Your session expired. Please try again.';
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($name === '') {
        $errors[] = 'Full name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $pdo = getDBConnection();

        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'An account with that email already exists.';
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            'INSERT INTO users (name, email, password, role, is_verified) VALUES (?, ?, ?, ?, 0)'
        );
        $stmt->execute([$name, $email, $hashedPassword, 'customer']);
        $userId = (int) $pdo->lastInsertId();

        // Generate a demo verification code (prototype: no real email service).
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $stmt = $pdo->prepare(
            'INSERT INTO verification_codes (user_id, code, expires_at, verified) VALUES (?, ?, ?, 0)'
        );
        $stmt->execute([$userId, $code, $expiresAt]);

        $_SESSION['pending_verification_user_id'] = $userId;
        header('Location: /mukiss/verify.php');
        exit;
    }
}

$pageTitle = 'Create Account | MUKISS';
require_once __DIR__ . '/includes/header.php';
?>
<div class="auth-screen">
  <div class="auth-card">
    <div class="auth-card__logo">MUKISS</div>
    <h2>Create Account</h2>
    <p class="subtitle">Join MUKISS to save your details and manage your account.</p>

    <?php foreach ($errors as $error): ?>
      <div class="notice notice--error"><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>

    <form method="post" data-validate>
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">

      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" data-rule="required" value="<?php echo htmlspecialchars($name); ?>">
        <span class="form-error">Please enter your full name.</span>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" data-rule="required|email" value="<?php echo htmlspecialchars($email); ?>">
        <span class="form-error">Please enter a valid email address.</span>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="password-field">
          <input type="password" id="password" name="password" data-rule="required|minlength:8">
          <button type="button" class="password-toggle" data-target="password">SHOW</button>
        </div>
        <span class="form-error">Password must be at least 8 characters.</span>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <div class="password-field">
          <input type="password" id="confirm_password" name="confirm_password" data-rule="required">
          <button type="button" class="password-toggle" data-target="confirm_password">SHOW</button>
        </div>
        <span class="form-error">Please confirm your password.</span>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Create Account</button>
    </form>

    <div class="auth-card__footer">
      Already have an account? <a href="/mukiss/login.php">Sign In</a>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
