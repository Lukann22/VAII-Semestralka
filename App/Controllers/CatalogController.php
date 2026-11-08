<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class CatalogController
 * Displays the tea catalog of the TeaShop application. Products are loaded from the database.
 *
 * @package App\Controllers
 */
class CatalogController extends BaseController
{
    /** Number of products on one page. */
    private const PER_PAGE = 6;

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
        $totalCount = Product::getCount();
        $pageCount = max(1, (int)ceil($totalCount / self::PER_PAGE));

        $page = (int)$request->value('page');
        $page = max(1, min($pageCount, $page));

        $products = Product::getAll(
            orderBy: '`name` ASC',
            limit: self::PER_PAGE,
            offset: ($page - 1) * self::PER_PAGE
        );

        return $this->html([
            'teaTypes' => Product::TYPES,
            'products' => $products,
            'totalCount' => $totalCount,
            'currentPage' => $page,
            'pageCount' => $pageCount,
        ]);
    }
}