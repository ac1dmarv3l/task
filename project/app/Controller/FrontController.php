<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\View;
use App\Model\Product;

final readonly class FrontController
{
    public function __construct(
        private Product  $product,
    )
    {
    }

    public function index(array $params): void
    {
        $filters = [];

        if (!empty($params['category'])) {
            $filters['category'] = $params['category'];
        }

        $products = $this->product->getAll($filters);
        $categories = $this->product->getCategories();

        View::render('front/list', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    public function view(array $params): void
    {
        $id = (int)$params['id'] ?? null;

        if (!$id) {
            View::redirectTo('/');
        }

        $product = $this->product->getOne($id);

        if (!$product) {
            View::redirectTo('/');
        }

        View::render('front/view', ['product' => $product]);
    }
}
