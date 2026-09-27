<?php
/**
 * MUKISS - Home Page
 * Location: index.php
 */
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

$pdo = getDBConnection();

// Featured flavors (first 4 active products)
$featuredProducts = $pdo->query(
    "SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC LIMIT 4"
)->fetchAll();

// Specification preview (first 4 active products)
$specProducts = $pdo->query(
    "SELECT * FROM products WHERE status = 'active' ORDER BY created_at ASC LIMIT 4"
)->fetchAll();

$pageTitle = 'MUKISS | Modern Design. Distinctive Flavors.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- HERO -->
<section class="hero">
  <span class="hero__eyebrow">PREMIUM COLLECTION</span>
  <h1>Elevate Your Vibe with MUKISS</h1>
  <p>Discover the MUKISS collection through a modern selection of flavors and product designs. Explore our signature collection and learn more about each product's features and specifications.</p>
  <div class="hero__actions">
    <a href="/mukiss/flavors.php" class="btn btn-primary">EXPLORE COLLECTION</a>
    <a href="/mukiss/flavors.php" class="btn btn-outline">VIEW FLAVORS</a>
  </div>
</section>

<!-- FEATURED FLAVORS -->
<section class="section section--light">
  <div class="section__head">
    <h2>Signature Flavor Lineup</h2>
    <p>Explore the MUKISS signature collection and discover different flavor profiles through our organized product catalog.</p>
  </div>
  <div class="card-grid">
    <?php foreach ($featuredProducts as $product): ?>
      <div class="product-card">
        <div class="product-card__image"><?php echo htmlspecialchars(substr($product['name'], 0, 1)); ?></div>
        <div class="product-card__body">
          <h3><?php echo htmlspecialchars($product['name']); ?></h3>
          <span class="product-card__profile"><?php echo htmlspecialchars($product['flavor_profile']); ?></span>
          <p class="desc"><?php echo htmlspecialchars($product['description']); ?></p>
          <a href="/mukiss/flavors.php" class="btn btn-outline btn-sm">View Details</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- SPECIFICATIONS PREVIEW -->
<section class="section section--white">
  <div class="section__head">
    <h2>Device Specifications</h2>
    <p>Learn more about the design and key specifications represented in the MUKISS collection.</p>
  </div>
  <div class="spec-grid">
    <?php foreach ($specProducts as $product): ?>
      <div class="spec-card">
        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
        <dl>
          <div><dt>Category</dt><dd><?php echo htmlspecialchars($product['category']); ?></dd></div>
          <div><dt>Design</dt><dd><?php echo htmlspecialchars($product['design']); ?></dd></div>
          <div><dt>Finish</dt><dd><?php echo htmlspecialchars($product['finish']); ?></dd></div>
          <div><dt>Demo Status</dt><dd><?php echo htmlspecialchars(ucfirst($product['status'])); ?></dd></div>
        </dl>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="section__footer">
    <a href="/mukiss/specifications.php" class="btn btn-primary">VIEW SPECIFICATIONS</a>
  </div>
</section>

<!-- ABOUT -->
<section class="section section--light">
  <div class="about-block">
    <div class="about-block__intro">
      <h2>About MUKISS</h2>
      <p>MUKISS is a fictional brand concept created for an educational web development project. The website demonstrates how product information, flavor profiles, specifications, and customer inquiries can be organized into a modern digital platform.</p>
    </div>
    <div class="section__head">
      <h2 style="font-size:1.4rem;">Why Choose MUKISS?</h2>
    </div>
    <div class="feature-grid">
      <div class="feature-card">
        <h3>Flavor Variety</h3>
        <p>Explore a collection of different flavor profiles organized in an easy-to-browse catalog.</p>
      </div>
      <div class="feature-card">
        <h3>Modern Design</h3>
        <p>Product information is presented through a clean and responsive interface.</p>
      </div>
      <div class="feature-card">
        <h3>Easy Information Access</h3>
        <p>Find product descriptions, flavor profiles, and specifications in one organized platform.</p>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT / INQUIRY -->
<section class="section section--white">
  <div class="section__head">
    <h2>Contact &amp; Inquiries</h2>
    <p><strong>Have a Question?</strong><br>Have a question about our product information or website? Send us a message through the form below.</p>
  </div>
  <div class="form-card">
    <div id="inquiryMessage"></div>
    <form action="/mukiss/contact.php" method="post" data-validate>
      <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="name" data-rule="required">
        <span class="form-error">Please enter your full name.</span>
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" data-rule="required|email">
        <span class="form-error">Please enter a valid email address.</span>
      </div>
      <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" data-rule="required">
        <span class="form-error">Please enter a subject.</span>
      </div>
      <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" data-rule="required|minlength:10"></textarea>
        <span class="form-error">Message must be at least 10 characters.</span>
      </div>
      <button type="submit" class="btn btn-primary btn-block">SUBMIT INQUIRY</button>
    </form>
  </div>
</section>

<!-- IMPORTANT INFORMATION -->
<section class="info-banner">
  <div class="info-banner__inner">
    <h2>IMPORTANT INFORMATION</h2>
    <p>This website is a student-developed educational prototype. Product information displayed on this website is for demonstration purposes only.</p>
    <p>MUKISS depicts fictional age-restricted products. This site does not sell real products, and all content is intended solely for a web development coursework demonstration.</p>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
