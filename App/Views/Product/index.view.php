<?php

/** @var \App\Models\Product[] $products */
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="page-header">
    <h1>Manage Products</h1>
    <a href="<?= $link->url('product.add') ?>" class="btn btn-primary">+ Add product</a>
</div>

<?php if (count($products) === 0) { ?>
    <p class="empty">No products yet. Add the first one.</p>
<?php } else { ?>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
                <th scope="col" class="num">Price</th>
                <th scope="col">In stock</th>
                <th scope="col"><span class="visually-hidden">Actions</span></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td class="col-id"><?= $product->getId() ?></td>
                    <td class="col-name">
                        <strong><?= e($product->getName()) ?></strong>
                        <div class="muted"><?= e($product->getDescription()) ?></div>
                    </td>
                    <td><span class="tag"><?= e($product->getTypeLabel()) ?></span></td>
                    <td class="num"><?= number_format((float)$product->getPrice(), 2, '.', ' ') ?> €</td>
                    <td data-label="In stock"><?= $product->isInStock() ? 'Yes' : 'No' ?></td>
                    <td class="actions">
                        <a href="<?= $link->url('product.edit', ['id' => $product->getId()]) ?>"
                           class="btn btn-ghost">Edit</a>
                        <form method="post" action="<?= $link->url('product.delete') ?>"
                              data-confirm="Really delete &quot;<?= e($product->getName()) ?>&quot;?">
                            <input type="hidden" name="id" value="<?= $product->getId() ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>