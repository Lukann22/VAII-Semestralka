<?php

/** @var \App\Models\Product $product */
/** @var string[] $errors */
/** @var \Framework\Support\LinkGenerator $link */
?>

<h1><?= $product->getId() ? 'Edit product' : 'New product' ?></h1>

<?php if (count($errors) > 0) { ?>
    <div class="alert" role="alert">
        <?php foreach ($errors as $error) { ?>
            <div><?= e($error) ?></div>
        <?php } ?>
    </div>
<?php } ?>

<form method="post" action="<?= $link->url('product.save') ?>" class="card form-card">
    <input type="hidden" name="id" value="<?= $product->getId() ?>">

    <div class="form-row">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required maxlength="100"
               value="<?= e($product->getName()) ?>">
    </div>

    <div class="form-row">
        <label for="type">Tea type</label>
        <select id="type" name="type" required>
            <?php foreach (\App\Models\Product::TYPES as $value => $label) { ?>
                <option value="<?= e($value) ?>" <?= $product->getType() === $value ? 'selected' : '' ?>>
                    <?= e($label) ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-row">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3"
                  maxlength="255"><?= e($product->getDescription()) ?></textarea>
    </div>

    <div class="form-row">
        <label for="price">Price (€)</label>
        <input type="number" id="price" name="price" required min="0" step="0.01"
               value="<?= e($product->getPrice()) ?>">
    </div>

    <label class="checkbox">
        <input type="checkbox" name="inStock" value="1" <?= $product->isInStock() ? 'checked' : '' ?>>
        In stock
    </label>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= $link->url('product.index') ?>" class="btn btn-ghost">Cancel</a>
    </div>
</form>