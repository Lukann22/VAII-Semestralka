<?php

/** @var \App\Models\Category $category */
/** @var \App\Models\Product[] $products */
/** @var int[] $selectedIds */
/** @var string[] $errors */
/** @var \Framework\Support\LinkGenerator $link */
?>

<h1><?= $category->getId() ? 'Edit category' : 'New category' ?></h1>

<?php if (count($errors) > 0) { ?>
    <div class="alert" role="alert">
        <?php foreach ($errors as $error) { ?>
            <div><?= e($error) ?></div>
        <?php } ?>
    </div>
<?php } ?>

<form method="post" action="<?= $link->url('category.save') ?>" class="card form-card">
    <input type="hidden" name="id" value="<?= $category->getId() ?>">

    <div class="form-row">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required maxlength="50"
               value="<?= e($category->getName()) ?>">
    </div>

    <div class="form-row">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="2"
                  maxlength="255"><?= e($category->getDescription()) ?></textarea>
    </div>

    <fieldset class="related-picker">
        <legend>Products in this category</legend>
        <?php if (count($products) === 0) { ?>
            <p class="muted">There are no products yet.</p>
        <?php } else { ?>
            <div class="checkbox-grid">
                <?php foreach ($products as $product) { ?>
                    <label class="checkbox">
                        <input type="checkbox" name="products[]" value="<?= $product->getId() ?>"
                            <?= in_array($product->getId(), $selectedIds, true) ? 'checked' : '' ?>>
                        <span>
                            <?= e($product->getName()) ?>
                            <span class="muted">· <?= e($product->getTypeLabel()) ?></span>
                        </span>
                    </label>
                <?php } ?>
            </div>
        <?php } ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= $link->url('category.index') ?>" class="btn btn-ghost">Cancel</a>
    </div>
</form>