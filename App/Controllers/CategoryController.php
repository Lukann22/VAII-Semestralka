<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class CategoryController
 * Category management (CRUD) including the assignment of products to categories (M:N).
 *
 * @package App\Controllers
 */
class CategoryController extends BaseController
{
    /**
     * Login is not required in this assignment - every action is allowed.
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * READ - table of all categories with their products.
     */
    public function index(Request $request): Response
    {
        return $this->html([
            'categories' => Category::getAll(orderBy: '`name` ASC'),
        ]);
    }

    /**
     * CREATE (step 1) - empty form.
     */
    public function add(Request $request): Response
    {
        return $this->showForm(new Category(), [], []);
    }

    /**
     * UPDATE (step 1) - form filled with the category and its current products.
     */
    public function edit(Request $request): Response
    {
        $category = $this->getCategoryOr404((int)$request->value('id'));
        $selectedIds = array_map(fn(Product $p) => $p->getId(), $category->getProducts());
        return $this->showForm($category, $selectedIds, []);
    }

    /**
     * CREATE / UPDATE (step 2) - saves the category and its links to products.
     */
    public function save(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $id = (int)$request->post('id');
        $category = $id > 0 ? $this->getCategoryOr404($id) : new Category();

        $category->setName(trim((string)$request->post('name')));
        $category->setDescription(trim((string)$request->post('description')));

        // checked products: products[]=1&products[]=5 -> [1, 5]; nothing checked -> not sent at all
        $selectedIds = $request->post('products') ?? [];
        if (!is_array($selectedIds)) {
            $selectedIds = [];
        }
        $selectedIds = array_map('intval', $selectedIds);

        // keep only ids of existing products, otherwise the foreign key would reject them
        $existingIds = array_map(fn(Product $p) => $p->getId(), Product::getAll());
        $selectedIds = array_values(array_intersect($selectedIds, $existingIds));

        $errors = $this->validate($category);
        if (count($errors) > 0) {
            return $this->showForm($category, $selectedIds, $errors);
        }

        $category->save();                       // INSERT or UPDATE of the category
        $category->setProductIds($selectedIds);  // INSERT / DELETE in product_categories

        return $this->redirect($this->url('category.index'));
    }

    /**
     * DELETE - removes the category. Its links to products are removed by the DB (ON DELETE CASCADE),
     * the products themselves stay.
     */
    public function delete(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $category = $this->getCategoryOr404((int)$request->post('id'));
        $category->delete();
        return $this->redirect($this->url('category.index'));
    }

    /**
     * @param int[] $selectedIds ids of products that should be checked in the form
     * @param string[] $errors
     */
    private function showForm(Category $category, array $selectedIds, array $errors): Response
    {
        return $this->html([
            'category' => $category,
            'products' => Product::getAll(orderBy: '`name` ASC'),
            'selectedIds' => $selectedIds,
            'errors' => $errors,
        ], 'form');
    }

    private function getCategoryOr404(int $id): Category
    {
        $category = Category::getOne($id);
        if ($category === null) {
            throw new HttpException(404);
        }
        return $category;
    }

    /**
     * @return string[]
     */
    private function validate(Category $category): array
    {
        $errors = [];
        if ($category->getName() === '') {
            $errors[] = 'Name is required.';
        } elseif (mb_strlen($category->getName()) > 50) {
            $errors[] = 'Name can have at most 50 characters.';
        } elseif (Category::getCount('`name` = ? AND `id` <> ?', [$category->getName(), (int)$category->getId()]) > 0) {
            $errors[] = 'A category with this name already exists.';
        }
        if (mb_strlen($category->getDescription()) > 255) {
            $errors[] = 'Description can have at most 255 characters.';
        }
        return $errors;
    }
}