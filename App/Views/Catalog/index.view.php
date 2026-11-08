<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var array<string, string> $teaTypes */
/** @var \App\Models\Product[] $products */
/** @var int $totalCount */
/** @var int $currentPage */
/** @var int $pageCount */
?>

<div class="catalog-header">
    <h1>Tea Catalog</h1>
    <form class="search-form" role="search" action="<?= $link->url('catalog.index') ?>" method="get">
        <input type="hidden" name="c" value="catalog">
        <label for="search" class="visually-hidden">Search products</label>
        <input type="search" id="search" name="q" placeholder="Search products...">
    </form>
</div>

<div class="catalog-layout">

    <!-- ----- Filters sidebar ----- -->
    <aside class="filters" aria-label="Product filters">
        <details open>
            <summary>Filters</summary>

            <form action="<?= $link->url('catalog.index') ?>" method="get" class="filters-form">
                <input type="hidden" name="c" value="catalog">

                <fieldset class="filter-group">
                    <legend>Tea Type</legend>
                    <div class="checkbox-list">
                        <?php foreach ($teaTypes as $value => $label) { ?>
                            <label class="checkbox">
                                <input type="checkbox" name="type[]" value="<?= e($value) ?>"> <?= e($label) ?>
                            </label>
                        <?php } ?>
                    </div>
                </fieldset>

                <fieldset class="filter-group">
                    <legend>Price Range</legend>
                    <div class="price-range">
                        <label for="price-min" class="visually-hidden">Minimum price</label>
                        <input type="number" id="price-min" name="min" min="0" placeholder="Min €">
                        <label for="price-max" class="visually-hidden">Maximum price</label>
                        <input type="number" id="price-max" name="max" min="0" placeholder="Max €">
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                <button type="reset" class="btn btn-ghost btn-block">Clear filters</button>
            </form>
        </details>
    </aside>

    <!-- ----- Product list ----- -->
    <section class="products" aria-labelledby="products-title">
        <h2 id="products-title" class="visually-hidden">Products</h2>

        <div class="products-toolbar">
            <p class="results-count">Showing <strong><?= count($products) ?></strong> of <?= $totalCount ?> teas</p>
            <div class="sort">
                <label for="sort">Sort by</label>
                <select id="sort" name="sort">
                    <option>Recommended</option>
                    <option>Price: low to high</option>
                    <option>Price: high to low</option>
                    <option>Name A–Z</option>
                </select>
            </div>
        </div>

        <ul class="product-grid">
            <?php foreach ($products as $product) { ?>
                <li>
                    <article class="card product-card">
                        <div class="placeholder product-image">[Product image]</div>
                        <div class="product-body">
                            <span class="tag"><?= e($product->getTypeLabel()) ?></span>
                            <h3><?= e($product->getName()) ?></h3>
                            <p><?= e($product->getDescription()) ?></p>
                            <div class="product-footer">
                                <span class="price"><?= number_format((float)$product->getPrice(), 2, '.', ' ') ?> €</span>
                                <?php if ($product->isInStock()) { ?>
                                    <button type="button" class="btn btn-primary">Add to cart 🛒</button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-primary" disabled>Sold out</button>
                                <?php } ?>
                            </div>
                        </div>
                    </article>
                </li>
            <?php } ?>
        </ul>

        <nav class="pagination" aria-label="Pagination">
            <?php if ($currentPage > 1) { ?>
                <a href="<?= $link->url(['page' => $currentPage - 1]) ?>" class="page-link">&laquo; Prev</a>
            <?php } else { ?>
                <span class="page-link" aria-disabled="true">&laquo; Prev</span>
            <?php } ?>

            <?php for ($i = 1; $i <= $pageCount; $i++) { ?>
                <?php if ($i === $currentPage) { ?>
                    <span class="page-link current" aria-current="page"><?= $i ?></span>
                <?php } else { ?>
                    <a href="<?= $link->url(['page' => $i]) ?>" class="page-link"><?= $i ?></a>
                <?php } ?>
            <?php } ?>

            <?php if ($currentPage < $pageCount) { ?>
                <a href="<?= $link->url(['page' => $currentPage + 1]) ?>" class="page-link">Next &raquo;</a>
            <?php } else { ?>
                <span class="page-link" aria-disabled="true">Next &raquo;</span>
            <?php } ?>
        </nav>
    </section>

</div>
