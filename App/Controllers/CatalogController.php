<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class CatalogController
 * Displays the tea catalog of the TeaShop application.
 *
 * For now the products are static sample data. Later they will be loaded from the database
 * using a model, the view will stay the same.
 *
 * @package App\Controllers
 */
class CatalogController extends BaseController
{
    /** Number of pages shown in the pagination (static for now). */
    private const PAGE_COUNT = 4;

    /**
     * The catalog is public - everybody can browse it.
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * Displays the tea catalog (App/Views/Catalog/index.view.php).
     */
    public function index(Request $request): Response
    {
        $page = (int)$request->value('page');
        $page = max(1, min(self::PAGE_COUNT, $page));

        return $this->html([
            'teaTypes' => [
                'green' => 'Green tea',
                'black' => 'Black tea',
                'herbal' => 'Herbal tea',
                'white' => 'White tea',
            ],
            'products' => $this->getSampleProducts(),
            'totalCount' => 24,
            'currentPage' => $page,
            'pageCount' => self::PAGE_COUNT,
        ]);
    }

    /**
     * Static sample products - placeholder until the database and models are implemented.
     *
     * @return array<int, array{name: string, type: string, description: string, price: float, inStock: bool}>
     */
    private function getSampleProducts(): array
    {
        return [
            [
                'name' => 'Darjeeling First Flush',
                'type' => 'Black tea',
                'description' => 'Delicate floral aroma with muscatel notes',
                'price' => 14.90,
                'inStock' => true,
            ],
            [
                'name' => 'Sencha Uji',
                'type' => 'Green tea',
                'description' => 'Fresh, grassy taste with a sweet finish',
                'price' => 12.50,
                'inStock' => true,
            ],
            [
                'name' => 'Bai Mu Dan',
                'type' => 'White tea',
                'description' => 'Light and honeyed with gentle fruity notes',
                'price' => 16.40,
                'inStock' => true,
            ],
            [
                'name' => 'Rooibos Vanilla',
                'type' => 'Herbal tea',
                'description' => 'Caffeine-free, creamy and naturally sweet',
                'price' => 8.90,
                'inStock' => true,
            ],
            [
                'name' => 'Gyokuro Asahi',
                'type' => 'Green tea',
                'description' => 'Shade-grown tea with a rich umami character',
                'price' => 24.90,
                'inStock' => false,
            ],
            [
                'name' => 'Assam Breakfast',
                'type' => 'Black tea',
                'description' => 'Malty and bold, perfect with a splash of milk',
                'price' => 9.80,
                'inStock' => true,
            ],
        ];
    }
}
