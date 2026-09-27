<?php
/**
 * MUKISS - Specifications Page
 * Location: specifications.php
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

$pdo = getDBConnection();

// Get all active products
$stmt = $pdo->query(
    "SELECT * FROM products
     WHERE status = 'active'
     ORDER BY created_at ASC"
);

$products = $stmt->fetchAll();

$pageTitle = 'MUKISS | Specifications';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- PAGE HEADER -->
<section class="page-hero">
    <span class="hero__eyebrow">MUKISS COLLECTION</span>

    <h1>Product Specifications</h1>

    <p>
        Explore the design details, categories, flavor profiles,
        and finishes represented in the MUKISS educational collection.
    </p>
</section>

<!-- SPECIFICATIONS -->
<section class="section section--white">

    <div class="section__head">

        <h2>Collection Specifications</h2>

        <p>
            View the available specifications for each fictional
            sample product in the MUKISS collection.
        </p>

    </div>

    <?php if (empty($products)): ?>

        <div class="form-card">

            <h3>No specifications available</h3>

            <p>
                There are currently no active products in the
                educational collection.
            </p>

        </div>

    <?php else: ?>

        <div class="spec-grid">

            <?php foreach ($products as $product): ?>

                <div class="spec-card">

                    <h3>
                        <?php
                        echo htmlspecialchars($product['name']);
                        ?>
                    </h3>

                    <p class="product-card__profile">
                        <?php
                        echo htmlspecialchars($product['flavor_profile']);
                        ?>
                    </p>

                    <dl>

                        <div>
                            <dt>Category</dt>
                            <dd>
                                <?php
                                echo htmlspecialchars($product['category']);
                                ?>
                            </dd>
                        </div>

                        <div>
                            <dt>Flavor Profile</dt>
                            <dd>
                                <?php
                                echo htmlspecialchars($product['flavor_profile']);
                                ?>
                            </dd>
                        </div>

                        <div>
                            <dt>Design</dt>
                            <dd>
                                <?php
                                echo htmlspecialchars($product['design']);
                                ?>
                            </dd>
                        </div>

                        <div>
                            <dt>Finish</dt>
                            <dd>
                                <?php
                                echo htmlspecialchars($product['finish']);
                                ?>
                            </dd>
                        </div>

                        <div>
                            <dt>Status</dt>
                            <dd>
                                <?php
                                echo htmlspecialchars(
                                    ucfirst($product['status'])
                                );
                                ?>
                            </dd>
                        </div>

                    </dl>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>

<!-- INFORMATION -->
<section class="section section--light">

    <div class="about-block">

        <div class="about-block__intro">

            <h2>About These Specifications</h2>

            <p>
                The specifications displayed on this page are
                sample information created specifically for the
                MUKISS educational web development project.
            </p>

            <p>
                The website is a fictional prototype and does not
                represent real product sales or transactions.
            </p>

        </div>

    </div>

</section>

<!-- IMPORTANT INFORMATION -->
<section class="info-banner">

    <div class="info-banner__inner">

        <h2>EDUCATIONAL PROJECT</h2>

        <p>
            MUKISS is a fictional brand concept developed for
            coursework and web development demonstration purposes.
        </p>

        <p>
            All product names, descriptions, and specifications
            shown on this website are sample data.
        </p>

    </div>

</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>