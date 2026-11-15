<?php

namespace App\Models;

use Framework\Core\Model;

/**
 * Class Category
 * A group of products, e.g. "Bestsellers". Stored in the DB table `categories`.
 * Products and categories are in an M:N relationship through the table `product_categories`.
 *
 * @package App\Models
 */
class Category extends Model
{
    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Products in this category, sorted by name.
     * Works only for a category loaded from the DB (getOne / getAll).
     *
     * @return Product[]
     */
    public function getProducts(): array
    {
        $products = [];
        // rows of product_categories with categoryId = this category
        foreach ($this->getAllRelated(ProductCategory::class) as $link) {
            // product referenced by productId of the row
            $product = $link->getOneRelated(Product::class);
            if ($product !== null) {
                $products[] = $product;
            }
        }
        usort($products, fn(Product $a, Product $b) => strcasecmp($a->getName(), $b->getName()));
        return $products;
    }

    /**
     * Sets which products belong to this category: adds missing links and removes the others.
     * The category must already be saved (must have an id).
     *
     * @param int[] $productIds
     */
    public function setProductIds(array $productIds): void
    {
        $productIds = array_unique(array_map('intval', $productIds));
        $links = ProductCategory::getAll('`categoryId` = ?', [$this->id]);

        // remove links that are no longer selected
        $existingIds = [];
        foreach ($links as $link) {
            if (in_array($link->getProductId(), $productIds, true)) {
                $existingIds[] = $link->getProductId();
            } else {
                $link->delete();
            }
        }

        // add new links
        foreach (array_diff($productIds, $existingIds) as $productId) {
            $link = new ProductCategory();
            $link->setProductId($productId);
            $link->setCategoryId($this->id);
            $link->save();
        }
    }
}