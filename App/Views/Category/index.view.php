<?php

/** @var \App\Models\Category[] $categories */
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="page-header">
    <h1>Manage Categories</h1>
    <a href="<?= $link->url('category.add') ?>" class="btn btn-primary">+ Add category</a>
</div>

<?php if (count($categories) === 0) { ?>
    <p class="empty">No categories yet. Add the first one.</p>
<?php } else { ?>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Products</th>
                <th scope="col"><span class="visually-hidden">Actions</span></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category) { ?>
                <?php $products = $category->getProducts(); ?>
                <tr>
                    <td class="col-name">
                        <strong><?= e($category->getName()) ?></strong>
                        <div class="muted"><?= e($category->getDescription()) ?></div>
                    </td>
                    <td class="col-related">
                        <?php if (count($products) === 0) { ?>
                            <span class="muted">No products</span>
                        <?php } else { ?>
                            <ul class="tag-list">
                                <?php foreach ($products as $product) { ?>
                                    <li><span class="tag tag-neutral"><?= e($product->getName()) ?></span></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </td>
                    <td class="actions">
                        <a href="<?= $link->url('category.edit', ['id' => $category->getId()]) ?>"
                           class="btn btn-ghost">Edit</a>
                        <form method="post" action="<?= $link->url('category.delete') ?>"
                              data-confirm="Really delete the category &quot;<?= e($category->getName()) ?>&quot;? The products will stay.">
                            <input type="hidden" name="id" value="<?= $category->getId() ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>