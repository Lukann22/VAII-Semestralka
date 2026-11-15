<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */

// URL of the currently displayed action (without extra GET parameters) - used to highlight the active menu item
$currentUrl = $link->url([]);

/**
 * Returns attributes marking a navigation link as active, if it points to the current page.
 */
$activeAttr = function (string $destination) use ($link, $currentUrl): string {
    return $link->url($destination) === $currentUrl ? ' class="active" aria-current="page"' : '';
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= App\Configuration::APP_NAME ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= $link->asset('images/logo.svg') ?>">
    <link rel="stylesheet" href="<?= $link->asset('css/style.css') ?>">
    <script src="<?= $link->asset('js/script.js') ?>" defer></script>
</head>
<body>

<!-- ===== Header: logo, name, navigation ===== -->
<header class="site-header">
    <div class="container header-inner">
        <a href="<?= $link->url('home.index') ?>" class="brand">
            <img src="<?= $link->asset('images/logo.svg') ?>" alt="" class="brand-logo" width="30" height="30">
            <span class="brand-name"><?= App\Configuration::APP_NAME ?></span>
        </a>

        <!-- CSS-only mobile menu toggle (no JavaScript) -->
        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="nav-toggle-label" aria-label="Open menu">
            <span></span><span></span><span></span>
        </label>

        <nav class="main-nav" aria-label="Main navigation">
            <ul>
                <li><a href="<?= $link->url('home.index') ?>"<?= $activeAttr('home.index') ?>>Home</a></li>
                <li><a href="<?= $link->url('catalog.index') ?>"<?= $activeAttr('catalog.index') ?>>Catalog</a></li>
                <li><a href="<?= $link->url('product.index') ?>"<?= $activeAttr('product.index') ?>>Manage Products</a></li>
                <li><a href="<?= $link->url('category.index') ?>"<?= $activeAttr('category.index') ?>>Categories</a></li>
                <?php if ($user->isLoggedIn()) { ?>
                    <li><a href="<?= $link->url('auth.logout') ?>">Sign out (<?= e($user->getName()) ?>)</a></li>
                <?php } else { ?>
                    <li><a href="<?= App\Configuration::LOGIN_URL ?>">Sign in</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>

<!-- ===== Main content: output of the current view ===== -->
<main class="container page">
    <?= $contentHTML ?>
</main>

<!-- ===== Footer ===== -->
<footer class="site-footer">
    <div class="container">
        <p>
            &copy; <?= date('Y') ?> <?= App\Configuration::APP_NAME ?> |
            <a href="<?= $link->url('home.contact') ?>">Contact</a> |
            <a href="#">Terms &amp; Conditions</a>
        </p>
    </div>
</footer>

</body>
</html>
