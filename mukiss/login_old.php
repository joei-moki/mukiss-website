<?php
/**
 * MUKISS - Sign In
 * Location: login.php
 */
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

if (isLoggedIn()) {
    header('Location: /mukiss/account.php');
    exit;
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfCheck($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Your session expired. Please try again.';
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Please enter your email and password.';
    }

    if (empty($errors)) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Incorrect email or password.';
        } elseif (!$user['is_verified']) {
            $_SESSION['pending_verification_user_id'] = $user['id'];
            header('Location: /mukiss/verify.php');
            exit;
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header('Location: ' . ($user['role'] === 'admin' ? '/mukiss/admin/index.php' : '/mukiss/account.php'));
            exit;
        }
    }
}

$pageTitle = 'Sign In | MUKISS';
require_once __DIR__ . '/includes/header.php';
?>
<div class="auth-screen">
  <div class="auth-card">
    <div class="auth-card__logo">MUKISS</div>
    <h2>Sign In</h2>
    <p class="subtitle">Welcome back to MUKISS. Sign in to access your account and manage your information.</p>

    <?php foreach ($errors as $error): ?>
      <div class="notice notice--error"><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>

    <form method="post" data-validate>
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" data-rule="required|email" value="<?php echo htmlspecialchars($email); ?>">
        <span class="form-error">Please enter a valid email address.</span>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="password-field">
          <input type="password" id="password" name="password" data-rule="required">
          <button type="button" class="password-toggle" data-target="password">SHOW</button>
        </div>
        <span class="form-error">Please enter your password.</span>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Sign In</button>

      <div class="form-links">
        <a href="#">Forgot your password?</a>
        <a href="/mukiss/register.php">Create Account</a>
      </div>
    </form>

    <p style="margin-top:24px; font-size:0.75rem; opacity:0.55; text-align:center;">
      Demo admin: admin@mukiss.test / Admin123!<br>Demo customer: demo@mukiss.test / Demo123!
    </p>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
