<?php

namespace App\Models;

use Framework\Core\Model;

/**
 * Class ProductCategory
 * One row of the junction table of the M:N relationship between products and categories:
 * "product X belongs to category Y".
 *
 * @package App\Models
 */
class ProductCategory extends Model
{
    /** The name would be "productcategories" by convention, so it is set explicitly. */
    protected static ?string $tableName = 'product_categories';

    protected ?int $id = null;
    protected ?int $productId = null;
    protected ?int $categoryId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
}