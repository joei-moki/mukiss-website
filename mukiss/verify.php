<?php
/**
 * MUKISS - Verify Your Account
 * Location: verify.php
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

$pdo = getDBConnection();

$userId = $_SESSION['pending_verification_user_id'] ?? null;

if (!$userId) {
    header('Location: /mukiss/login.php');
    exit;
}

$errors = [];
$success = '';

/*
|--------------------------------------------------------------------------
| RESEND CODE
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['action'] ?? '') === 'resend') {

    $code = str_pad(
        (string) random_int(0, 999999),
        6,
        '0',
        STR_PAD_LEFT
    );

    $expiresAt = date(
        'Y-m-d H:i:s',
        strtotime('+15 minutes')
    );

    $stmt = $pdo->prepare(
        'INSERT INTO verification_codes
        (user_id, code, expires_at, verified)
        VALUES (?, ?, ?, 0)'
    );

    $stmt->execute([
        $userId,
        $code,
        $expiresAt
    ]);

    $success = 'A new verification code has been generated.';
}

/*
|--------------------------------------------------------------------------
| VERIFY CODE
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['action'] ?? '') === 'verify') {

    $submittedCode = trim($_POST['code'] ?? '');

    if (!preg_match('/^[0-9]{6}$/', $submittedCode)) {

        $errors[] = 'Please enter the 6-digit verification code.';

    } else {

        /*
        | Get the newest unverified code.
        */
        $stmt = $pdo->prepare(
            'SELECT *
             FROM verification_codes
             WHERE user_id = ?
             AND verified = 0
             ORDER BY id DESC
             LIMIT 1'
        );

        $stmt->execute([$userId]);

        $record = $stmt->fetch();

        if (!$record) {

            $errors[] = 'No active verification code was found. Please resend a new code.';

        } elseif ($record['code'] !== $submittedCode) {

            $errors[] = 'That code is incorrect. Please use the latest code shown on this page.';

        } elseif (strtotime($record['expires_at']) < time()) {

            $errors[] = 'That code has expired. Please resend a new code.';

        } else {

            /*
            | Mark verification code as used.
            */
            $updateCode = $pdo->prepare(
                'UPDATE verification_codes
                 SET verified = 1
                 WHERE id = ?'
            );

            $updateCode->execute([
                $record['id']
            ]);

            /*
            | Verify the user account.
            */
            $updateUser = $pdo->prepare(
                'UPDATE users
                 SET is_verified = 1
                 WHERE id = ?'
            );

            $updateUser->execute([
                $userId
            ]);

            /*
            | Get user information.
            */
            $userStmt = $pdo->prepare(
                'SELECT *
                 FROM users
                 WHERE id = ?'
            );

            $userStmt->execute([
                $userId
            ]);

            $user = $userStmt->fetch();

            /*
            | Log the user in.
            */
            unset($_SESSION['pending_verification_user_id']);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            /*
            | Redirect.
            */
            if ($user['role'] === 'admin') {

                header('Location: /mukiss/admin/index.php');

            } else {

                header('Location: /mukiss/account.php');

            }

            exit;
        }
    }
}

/*
|--------------------------------------------------------------------------
| GET LATEST CODE
|--------------------------------------------------------------------------
*/

$latestCodeStmt = $pdo->prepare(
    'SELECT code
     FROM verification_codes
     WHERE user_id = ?
     AND verified = 0
     ORDER BY id DESC
     LIMIT 1'
);

$latestCodeStmt->execute([
    $userId
]);

$latestCode = $latestCodeStmt->fetchColumn();

$pageTitle = 'Verify Your Account | MUKISS';

require_once __DIR__ . '/includes/header.php';
?>

<div class="auth-screen">

  <div class="auth-card">

    <div class="auth-card__logo">
      MUKISS
    </div>

    <h2>Verify Your Account</h2>

    <p class="subtitle">
      We've generated a verification code for your account.
      Enter the code below to continue.
    </p>

    <?php foreach ($errors as $error): ?>

      <div class="notice notice--error">
        <?php echo htmlspecialchars($error); ?>
      </div>

    <?php endforeach; ?>

    <?php if ($success): ?>

      <div class="notice notice--success">
        <?php echo htmlspecialchars($success); ?>
      </div>

    <?php endif; ?>

    <?php if ($latestCode): ?>

      <div class="notice notice--success">

        Demo mode:
        your current code is

        <strong>
          <?php echo htmlspecialchars($latestCode); ?>
        </strong>

      </div>

    <?php endif; ?>

    <form method="post">

      <input
        type="hidden"
        name="action"
        value="verify"
      >

      <div class="form-group">

        <label for="code">
          Verification Code
        </label>

        <input
          type="text"
          id="code"
          name="code"
          class="code-input"
          maxlength="6"
          inputmode="numeric"
          autocomplete="one-time-code"
          required
        >

      </div>

      <button
        type="submit"
        class="btn btn-primary btn-block"
      >
        Verify
      </button>

    </form>

    <form method="post" class="mt-24">

      <input
        type="hidden"
        name="action"
        value="resend"
      >

      <div class="auth-card__footer">

        Didn't receive the code?

        <button
          type="submit"
          style="background:none;border:none;color:var(--color-accent);font-weight:600;cursor:pointer;"
        >
          Resend Code
        </button>

      </div>

    </form>

  </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>