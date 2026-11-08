<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class ProductController
 * Product management (CRUD): list, add, edit and delete teas.
 *
 * @package App\Controllers
 */
class ProductController extends BaseController
{
    /**
     * Login is not required in this assignment - every action is allowed.
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * READ - table of all products.
     */
    public function index(Request $request): Response
    {
        return $this->html([
            'products' => Product::getAll(orderBy: '`id` DESC'),
        ]);
    }

    /**
     * CREATE (step 1) - empty form.
     */
    public function add(Request $request): Response
    {
        return $this->html(['product' => new Product(), 'errors' => []], 'form');
    }

    /**
     * UPDATE (step 1) - form filled with data of an existing product.
     */
    public function edit(Request $request): Response
    {
        $product = $this->getProductOr404((int)$request->value('id'));
        return $this->html(['product' => $product, 'errors' => []], 'form');
    }

    /**
     * CREATE / UPDATE (step 2) - saves the submitted form.
     */
    public function save(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        // hidden field "id": empty = new product, number = edit an existing one
        $id = (int)$request->post('id');
        $product = $id > 0 ? $this->getProductOr404($id) : new Product();

        $product->setName(trim((string)$request->post('name')));
        $product->setType((string)$request->post('type'));
        $product->setDescription(trim((string)$request->post('description')));
        $product->setPrice(str_replace(',', '.', trim((string)$request->post('price'))));
        // an unchecked checkbox is not sent at all -> null -> false
        $product->setInStock($request->post('inStock') !== null);

        $errors = $this->validate($product);
        if (count($errors) > 0) {
            return $this->html(['product' => $product, 'errors' => $errors], 'form');
        }

        $product->save();
        return $this->redirect($this->url('product.index'));
    }

    /**
     * DELETE - removes the product and returns to the list.
     */
    public function delete(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $product = $this->getProductOr404((int)$request->post('id'));
        $product->delete();
        return $this->redirect($this->url('product.index'));
    }

    private function getProductOr404(int $id): Product
    {
        $product = Product::getOne($id);
        if ($product === null) {
            throw new HttpException(404);
        }
        return $product;
    }

    /**
     * Basic checks, so that the database does not reject the values.
     *
     * @return string[]
     */
    private function validate(Product $product): array
    {
        $errors = [];
        if ($product->getName() === '') {
            $errors[] = 'Name is required.';
        } elseif (mb_strlen($product->getName()) > 100) {
            $errors[] = 'Name can have at most 100 characters.';
        }
        if (!array_key_exists($product->getType(), Product::TYPES)) {
            $errors[] = 'Choose a valid tea type.';
        }
        if (mb_strlen($product->getDescription()) > 255) {
            $errors[] = 'Description can have at most 255 characters.';
        }
        if (!is_numeric($product->getPrice()) || $product->getPrice() < 0 || $product->getPrice() > 999999) {
            $errors[] = 'Price must be a number from 0 to 999999.';
        }
        return $errors;
    }
}