<?php
/**
 * MUKISS - Flavors Page
 * Location: flavors.php
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/age_check.php';

$pdo = getDBConnection();

// Search
$search = trim($_GET['q'] ?? '');

// Get active products
if ($search !== '') {

    $stmt = $pdo->prepare(
        "SELECT * FROM products
         WHERE status = 'active'
         AND (
             name LIKE :search1
             OR flavor_profile LIKE :search2
             OR description LIKE :search3
             OR category LIKE :search4
         )
         ORDER BY created_at DESC"
    );

    $searchTerm = '%' . $search . '%';

    $stmt->execute([
        'search1' => $searchTerm,
        'search2' => $searchTerm,
        'search3' => $searchTerm,
        'search4' => $searchTerm
    ]);

    $products = $stmt->fetchAll();

} else {

    // Show all active products when there is no search
    $stmt = $pdo->query(
        "SELECT * FROM products
         WHERE status = 'active'
         ORDER BY created_at DESC"
    );

    $products = $stmt->fetchAll();
}

$pageTitle = 'MUKISS | Flavors';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- PAGE HEADER -->
<section class="page-hero">

    <span class="hero__eyebrow">MUKISS COLLECTION</span>

    <h1>Explore Our Flavors</h1>

    <p>
        Discover the flavor profiles and product information
        represented in the MUKISS educational collection.
    </p>

</section>

<!-- SEARCH RESULT -->
<section class="section section--light">

    <div class="section__head">

        <?php if ($search !== ''): ?>

            <h2>Search Results</h2>

            <p>
                Showing results for:
                <strong><?php echo htmlspecialchars($search); ?></strong>
            </p>

        <?php else: ?>

            <h2>Signature Flavors</h2>

            <p>
                Explore the different flavor profiles included
                in the MUKISS sample collection.
            </p>

        <?php endif; ?>

    </div>

    <?php if (empty($products)): ?>

        <div class="form-card">

            <h3>No flavors found</h3>

            <p>
                We couldn't find a matching flavor in the
                current educational collection.
            </p>

            <a href="/mukiss/flavors.php" class="btn btn-primary">
                VIEW ALL FLAVORS
            </a>

        </div>

    <?php else: ?>

        <div class="card-grid">

            <?php foreach ($products as $product): ?>

                <div class="product-card">

                    <!-- PRODUCT IMAGE -->
                    <div class="product-card__image">

                        <?php if (!empty($product['image'])): ?>

                            <img
                                src="/mukiss/assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>"
                            >

                        <?php else: ?>

                            <span>
                                <?php
                                echo htmlspecialchars(
                                    substr($product['name'], 0, 1)
                                );
                                ?>
                            </span>

                        <?php endif; ?>

                    </div>

                    <!-- PRODUCT INFORMATION -->
                    <div class="product-card__body">

                        <h3>
                            <?php
                            echo htmlspecialchars($product['name']);
                            ?>
                        </h3>

                        <span class="product-card__profile">
                            <?php
                            echo htmlspecialchars(
                                $product['flavor_profile']
                            );
                            ?>
                        </span>

                        <p class="desc">
                            <?php
                            echo htmlspecialchars(
                                $product['description']
                            );
                            ?>
                        </p>

                        <dl class="product-details">

                            <div>
                                <dt>Category</dt>
                                <dd>
                                    <?php
                                    echo htmlspecialchars(
                                        $product['category']
                                    );
                                    ?>
                                </dd>
                            </div>

                            <div>
                                <dt>Design</dt>
                                <dd>
                                    <?php
                                    echo htmlspecialchars(
                                        $product['design']
                                    );
                                    ?>
                                </dd>
                            </div>

                            <div>
                                <dt>Finish</dt>
                                <dd>
                                    <?php
                                    echo htmlspecialchars(
                                        $product['finish']
                                    );
                                    ?>
                                </dd>
                            </div>

                        </dl>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>

<!-- INFORMATION -->
<section class="info-banner">

    <div class="info-banner__inner">

        <h2>ABOUT THE COLLECTION</h2>

        <p>
            The flavors displayed on this page are fictional
            sample data created for this educational web
            development project.
        </p>

        <p>
            This website does not sell real products.
            All information is presented for demonstration
            and coursework purposes only.
        </p>

    </div>

</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>