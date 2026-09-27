<?php
/**
 * MUKISS - About Page
 * Location: about.php
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

$pageTitle = 'MUKISS | About';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- PAGE HEADER -->
<section class="page-hero">
    <span class="hero__eyebrow">ABOUT MUKISS</span>

    <h1>Modern Design. Distinctive Flavors.</h1>

    <p>
        Learn more about the concept behind the MUKISS
        educational web development project.
    </p>
</section>

<!-- ABOUT -->
<section class="section section--light">

    <div class="about-block">

        <div class="about-block__intro">

            <h2>What is MUKISS?</h2>

            <p>
                MUKISS is a fictional brand concept created as
                an educational web development project. The website
                demonstrates how a modern digital platform can
                organize product information, flavor profiles,
                specifications, and customer inquiries.
            </p>

            <p>
                The project focuses on creating a clean,
                responsive, and user-friendly interface while
                demonstrating the use of PHP, MySQL, HTML, CSS,
                and JavaScript.
            </p>

        </div>

    </div>

</section>

<!-- PROJECT FEATURES -->
<section class="section section--white">

    <div class="section__head">

        <h2>What This Website Demonstrates</h2>

        <p>
            The MUKISS website combines several web development
            concepts into one educational platform.
        </p>

    </div>

    <div class="feature-grid">

        <div class="feature-card">

            <h3>Modern Interface</h3>

            <p>
                A clean and responsive design that allows users
                to navigate the website comfortably across
                different screen sizes.
            </p>

        </div>

        <div class="feature-card">

            <h3>Product Information</h3>

            <p>
                Product names, flavor profiles, descriptions,
                categories, designs, and finishes are organized
                in a structured database.
            </p>

        </div>

        <div class="feature-card">

            <h3>Database Integration</h3>

            <p>
                PHP and MySQL are used to retrieve and display
                sample product information dynamically.
            </p>

        </div>

        <div class="feature-card">

            <h3>User Accounts</h3>

            <p>
                The project includes registration, account
                verification, login, sessions, and account
                information.
            </p>

        </div>

        <div class="feature-card">

            <h3>Search Function</h3>

            <p>
                Users can search the sample collection using
                keywords such as product names and flavor
                profiles.
            </p>

        </div>

        <div class="feature-card">

            <h3>Educational Purpose</h3>

            <p>
                The website is designed specifically to
                demonstrate web development concepts for
                coursework.
            </p>

        </div>

    </div>

</section>

<!-- TECHNOLOGIES -->
<section class="section section--light">

    <div class="section__head">

        <h2>Technologies Used</h2>

        <p>
            The project was developed using the following
            technologies and tools.
        </p>

    </div>

    <div class="feature-grid">

        <div class="feature-card">
            <h3>HTML</h3>
            <p>
                Used to structure the content and components
                of the website.
            </p>
        </div>

        <div class="feature-card">
            <h3>CSS</h3>
            <p>
                Used to create the visual design, layout,
                responsiveness, and overall appearance.
            </p>
        </div>

        <div class="feature-card">
            <h3>PHP</h3>
            <p>
                Used for server-side processing, authentication,
                database communication, and dynamic pages.
            </p>
        </div>

        <div class="feature-card">
            <h3>MySQL</h3>
            <p>
                Used to store sample product, user,
                verification, and inquiry information.
            </p>
        </div>

        <div class="feature-card">
            <h3>JavaScript</h3>
            <p>
                Used for client-side interactions and
                form validation.
            </p>
        </div>

        <div class="feature-card">
            <h3>XAMPP</h3>
            <p>
                Used as the local development environment
                for Apache and MySQL.
            </p>
        </div>

    </div>

</section>

<!-- PROJECT NOTICE -->
<section class="info-banner">

    <div class="info-banner__inner">

        <h2>EDUCATIONAL PROJECT</h2>

        <p>
            MUKISS is a fictional brand created solely for
            educational and web development coursework.
        </p>

        <p>
            The product information displayed on this website
            is sample data. This website does not sell real
            products or process real product transactions.
        </p>

    </div>

</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>