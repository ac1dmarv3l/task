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

        if (!empty($params['category'])) $filters['category'] = $params['category'];
        if (!empty($params['created_at_from']) || !empty($params['created_at_to'])) {
            if (!empty($params['created_at_from']) && !empty($params['created_at_to'])) {
                $filters['created_at'] = ['op' => 'BETWEEN', 'value' => [$params['created_at_from'], $params['created_at_to']]];
            } elseif (!empty($params['created_at_from'])) {
                $filters['created_at'] = ['op' => '>=', 'value' => $params['created_at_from']];
            } elseif (!empty($params['created_at_to'])) {
                $filters['created_at'] = ['op' => '<=', 'value' => $params['created_at_to']];
            }
        }

        $products = $this->product->getAll($filters);
        $categories = $this->product->getCategories();

        View::render('front/list', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'selected_category' => $params['category'] ?? '',
                'created_at_from' => $params['created_at_from'] ?? '',
                'created_at_to' => $params['created_at_to'] ?? '',
            ],
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
