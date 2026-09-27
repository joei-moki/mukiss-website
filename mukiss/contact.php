<?php
/**
 * MUKISS - Contact & Inquiry Page
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

$pdo = getDBConnection();

$success = '';
$error = '';

$name = '';
$email = '';
$subject = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $subject === '' || $message === '') {

        $error = 'Please complete all required fields.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = 'Please enter a valid email address.';

    } elseif (strlen($message) < 10) {

        $error = 'Your message must be at least 10 characters long.';

    } else {

        try {

            $stmt = $pdo->prepare(
                "INSERT INTO inquiries
                (name, email, subject, message)
                VALUES
                (:name, :email, :subject, :message)"
            );

            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message
            ]);

            $success = 'Your inquiry has been submitted successfully!';

            $name = '';
            $email = '';
            $subject = '';
            $message = '';

        } catch (PDOException $e) {

            $error = 'Unable to submit your inquiry right now. Please try again.';
        }
    }
}

$pageTitle = 'MUKISS | Contact';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- PAGE HEADER -->
<section class="page-hero">

    <span class="hero__eyebrow">GET IN TOUCH</span>

    <h1>Contact &amp; Inquiries</h1>

    <p>
        Have a question about the MUKISS educational project?
        Send us a message using the form below.
    </p>

</section>

<!-- CONTACT FORM -->
<section class="section section--light">

    <div class="section__head">

        <h2>Send an Inquiry</h2>

        <p>
            Complete the form below and your inquiry will be
            saved to the website database.
        </p>

    </div>

    <div class="form-card">

        <?php if ($success !== ''): ?>

            <div style="
                background: #dff5e1;
                color: #245b2a;
                border: 1px solid #8bc48f;
                padding: 15px 20px;
                margin-bottom: 20px;
                border-radius: 8px;
                font-weight: 600;
                text-align: center;
            ">
                ✓ <?php echo htmlspecialchars($success); ?>
            </div>

        <?php endif; ?>

        <?php if ($error !== ''): ?>

            <div style="
                background: #fbe2e2;
                color: #8a2525;
                border: 1px solid #d99a9a;
                padding: 15px 20px;
                margin-bottom: 20px;
                border-radius: 8px;
                font-weight: 600;
                text-align: center;
            ">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>

        <form action="/mukiss/contact.php" method="post">

            <div class="form-group">

                <label for="fullName">Full Name</label>

                <input
                    type="text"
                    id="fullName"
                    name="name"
                    value="<?php echo htmlspecialchars($name); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars($email); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="subject">Subject</label>

                <input
                    type="text"
                    id="subject"
                    name="subject"
                    value="<?php echo htmlspecialchars($subject); ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="message">Message</label>

                <textarea
                    id="message"
                    name="message"
                    required
                ><?php echo htmlspecialchars($message); ?></textarea>

            </div>

            <button
                type="submit"
                class="btn btn-primary btn-block"
            >
                SUBMIT INQUIRY
            </button>

        </form>

    </div>

</section>

<!-- PROJECT INFORMATION -->
<section class="info-banner">

    <div class="info-banner__inner">

        <h2>EDUCATIONAL PROJECT</h2>

        <p>
            This contact form is part of the MUKISS educational
            web development prototype.
        </p>

        <p>
            Submitted information is stored in the project's
            local MySQL database for demonstration purposes.
        </p>

    </div>

</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>