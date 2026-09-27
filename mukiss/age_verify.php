<?php
/**
 * MUKISS - Age Verification
 * Location: age_verify.php
 */
require_once __DIR__ . '/includes/auth.php'; // starts the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answer = $_POST['answer'] ?? '';

    if ($answer === 'yes') {
        $_SESSION['age_verified'] = true;
        header('Location: /mukiss/index.php');
        exit;
    }

    if ($answer === 'no') {
        $_SESSION['age_verified'] = false;
        header('Location: /mukiss/age_verify.php?denied=1');
        exit;
    }
}

$denied = isset($_GET['denied']);
$pageTitle = 'Age Verification | MUKISS';
require_once __DIR__ . '/includes/header.php';
?>
<div class="gate-screen">
  <div class="gate-card">
    <div class="gate-card__logo">MUKISS</div>

    <?php if ($denied): ?>
      <h1>ACCESS RESTRICTED</h1>
      <h2>You must meet the age requirement to continue.</h2>
      <p>This website contains information about age-restricted products and is not available to visitors who do not meet the legal age requirement in their location.</p>
      <div class="gate-card__actions">
        <a href="/mukiss/age_verify.php" class="btn btn-outline btn-block">GO BACK</a>
      </div>
    <?php else: ?>
      <h1>AGE VERIFICATION</h1>
      <h2>Are you 21 years of age or older?</h2>
      <p>This website contains information about age-restricted products. Please confirm that you meet the legal age requirement applicable in your location before continuing.</p>
      <form method="post" class="gate-card__actions">
        <button type="submit" name="answer" value="yes" class="btn btn-primary btn-block">YES, I AM 21+</button>
        <button type="submit" name="answer" value="no" class="btn btn-outline btn-block">NO, EXIT</button>
      </form>
    <?php endif; ?>

    <p class="gate-card__legal">MUKISS is a fictional brand created for an educational web development project. This gate is a session-based prototype only and is not a substitute for real identity or age verification.</p>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
