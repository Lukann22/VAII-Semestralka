<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<section class="hero">
    <div class="hero-text">
        <h1>Fine loose-leaf tea, delivered</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
            exercitation ullamco laboris.</p>
        <a href="<?= $link->url('catalog.index') ?>" class="btn btn-primary">Browse catalog</a>
    </div>
    <div class="placeholder hero-image">[Hero image]</div>
</section>

<section class="content-section" aria-labelledby="why-title">
    <h2 id="why-title">Why TeaShop</h2>
    <div class="feature-grid">
        <article class="card feature">
            <div class="placeholder feature-icon">[Icon]</div>
            <h3>Direct from gardens</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio praesent libero.</p>
        </article>
        <article class="card feature">
            <div class="placeholder feature-icon">[Icon]</div>
            <h3>Fresh every season</h3>
            <p>Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.</p>
        </article>
        <article class="card feature">
            <div class="placeholder feature-icon">[Icon]</div>
            <h3>Fast delivery</h3>
            <p>Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta.</p>
        </article>
    </div>
</section>

<section class="content-section" aria-labelledby="content-title">
    <h2 id="content-title">Content area</h2>
    <div class="placeholder content-placeholder">
        [Main page content – placeholder]
    </div>
</section>
