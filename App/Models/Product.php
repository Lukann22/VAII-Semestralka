<?php

namespace App\Models;

use Framework\Core\Model;

/**
 * Class Product
 * A tea sold in the TeaShop. Stored in the DB table `products`.
 *
 * @package App\Models
 */
class Product extends Model
{
    /** Allowed tea types: value stored in DB => label shown to the user. */
    public const TYPES = [
        'green' => 'Green tea',
        'black' => 'Black tea',
        'herbal' => 'Herbal tea',
        'white' => 'White tea',
    ];

    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $type = null;
    protected ?string $description = null;
    protected ?string $price = null;     // DECIMAL column -> string, e.g. "14.90"
    protected ?int $inStock = 1;         // TINYINT(1) column -> 0 / 1

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Human-readable name of the tea type, e.g. "Green tea".
     */
    public function getTypeLabel(): string
    {
        return self::TYPES[$this->type] ?? (string)$this->type;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function isInStock(): bool
    {
        return $this->inStock === 1;
    }

    public function setInStock(bool $inStock): void
    {
        $this->inStock = $inStock ? 1 : 0;
    }

        /**
     * Categories this product belongs to, sorted by name.
     * Works only for a product loaded from the DB (getOne / getAll).
     *
     * @return Category[]
     */
    public function getCategories(): array
    {
        $categories = [];
        foreach ($this->getAllRelated(ProductCategory::class) as $link) {
            $category = $link->getOneRelated(Category::class);
            if ($category !== null) {
                $categories[] = $category;
            }
        }
        usort($categories, fn(Category $a, Category $b) => strcasecmp($a->getName(), $b->getName()));
        return $categories;
    }
}

