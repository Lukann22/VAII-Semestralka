<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class HomeController
 * Handles the public pages of the TeaShop application (home page and contact page).
 *
 * @package App\Controllers
 */
class HomeController extends BaseController
{
    /**
     * All actions of this controller are public.
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * Displays the home page (App/Views/Home/index.view.php).
     */
    public function index(Request $request): Response
    {
        return $this->html();
    }

    /**
     * Displays the contact page (App/Views/Home/contact.view.php).
     */
    public function contact(Request $request): Response
    {
        return $this->html();
    }
}
