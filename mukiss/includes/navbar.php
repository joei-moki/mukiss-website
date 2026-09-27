<?php
/**
 * MUKISS - Navbar
 * Location: includes/navbar.php
 *
 * Requires includes/auth.php to already be included (for isLoggedIn()).
 */
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
  <div class="navbar">
    <a href="/mukiss/index.php" class="navbar__logo">MUKISS</a>

    <nav class="navbar__links" id="navLinks">
      <a href="/mukiss/index.php" class="<?php echo $currentPage === 'index.php' ? 'is-active' : ''; ?>">Home</a>
      <a href="/mukiss/flavors.php" class="<?php echo $currentPage === 'flavors.php' ? 'is-active' : ''; ?>">Flavors</a>
      <a href="/mukiss/specifications.php" class="<?php echo $currentPage === 'specifications.php' ? 'is-active' : ''; ?>">Specifications</a>
      <a href="/mukiss/about.php" class="<?php echo $currentPage === 'about.php' ? 'is-active' : ''; ?>">About</a>
    </nav>

    <div class="navbar__actions">
      <button class="icon-btn" id="searchToggle" aria-label="Search" title="Search">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </button>
      <a href="/mukiss/contact.php" class="icon-btn" aria-label="Shopping Bag" title="Shopping Bag">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 8h12l-1 12H7L6 8z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
      </a>
      <a href="/mukiss/<?php echo isLoggedIn() ? 'account.php' : 'login.php'; ?>" class="icon-btn" aria-label="Account" title="Account">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.5-4 5-6 8-6s6.5 2 8 6"/></svg>
      </a>
      <button class="hamburger" id="hamburgerBtn" aria-label="Menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>

  <div class="navbar__search" id="navSearch">
    <form action="/mukiss/flavors.php" method="get">
      <input type="text" name="q" placeholder="Search flavors...">
      <button type="submit">Search</button>
    </form>
  </div>
</header>
