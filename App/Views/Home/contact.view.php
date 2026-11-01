<?php

/** @var \Framework\Support\LinkGenerator $link */
?>

<section class="content-section" aria-labelledby="contact-title">
    <h1 id="contact-title">Contact</h1>
    <div class="card feature">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt
            ut labore et dolore magna aliqua.</p>
        <p>
            <strong>TeaShop</strong><br>
            Lorem Street 1, 010 01 Žilina<br>
            <a href="mailto:info@teashop.example">info@teashop.example</a>
        </p>
        <a href="<?= $link->url('catalog.index') ?>" class="btn btn-primary">Back to catalog</a>
    </div>
</section>
