<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Validator;
use App\Core\View;
use App\Model\Product;
use App\Model\User;

final readonly class AdminController
{
    public function __construct(
        private User $user,
        private Product $product,
    ) {}

    /**
     * dashboard
     * @param array $params
     * @return void
     */
    public function index(array $params): void
    {
        if (!isset($_SESSION['admin'])) {
            View::redirectTo('/admin/login');
        }

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

        $data = [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'selected_category' => $params['category'] ?? '',
                'created_at_from' => $params['created_at_from'] ?? '',
                'created_at_to' => $params['created_at_to'] ?? '',
            ],
        ];

        View::render('admin/list', $data);
    }

    /**
     * @param array $params
     * @return void
     */
    public function create(array $params): void
    {
        if (!isset($_SESSION['admin'])) {
            View::redirectTo('/admin/login');
        }

        $product = [];
        View::render('admin/product', ['product' => $product, 'action' => '/admin/product/create']);
    }

    /**
     * @param array $params
     * @return void
     */
    public function store(array $params): void
    {
        if (!isset($_SESSION['admin'])) {
            View::redirectTo('/admin/login');
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category' => $_POST['category'] ?? '',
            'price' => $_POST['price'] ?? '',
            'image' => $_POST['image'] ?? '',
        ];

        $errors = Validator::validateProduct($data);

        if (!empty($errors)) {
            $_SESSION['error'] = implode(', ', $errors);
            View::redirectTo('/admin/product/create');
        }

        $data['price'] = (float)$data['price'];
        $data['status'] = !empty($_POST['status']);

        $this->product->add($data);

        View::redirectTo('/admin');
    }

    /**
     * @param array $params
     * @return void
     */
    public function editForm(array $params): void
    {
        if (!isset($_SESSION['admin'])) {
            View::redirectTo('/admin/login');
        }

        $id = $params['id'] ?? null;

        if ($id === null)
        {
            View::redirectTo('/admin');
        }

        $product = $this->product->getOne((int)$id);

        if (!$product)
        {
            View::redirectTo('/admin');
        }

        View::render('admin/product', ['product' => $product, 'action' => '/admin/product/edit?id=' . $id]);
    }

    /**
     * @param array $params
     * @return void
     */
    public function edit(array $params): void
    {
        if (!isset($_SESSION['admin'])) {
            View::redirectTo('/admin/login');
        }

        $id = $params['id'] ?? null;
        if (!$id) View::redirectTo('/admin');

        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category' => $_POST['category'] ?? '',
            'price' => $_POST['price'] ?? '',
            'image' => $_POST['image'] ?? '',
        ];

        $errors = Validator::validateProduct($data);

        if (!empty($errors)) {
            $_SESSION['error'] = implode(', ', $errors);
            View::redirectTo('/admin/product/edit?id' . $id);
        }

        $data['price'] = (float)$data['price'];
        $data['status'] = !empty($_POST['status']);

        $this->product->edit((int)$id, $data);

        View::redirectTo('/admin');
    }

    /**
     * @param array $params
     * @return void
     */
    public function delete(array $params): void
    {
        if (!isset($_SESSION['admin'])) {
            View::redirectTo('/admin/login');
        }

        $id = $params['id'] ?? null;
        if (!$id) View::redirectTo('/admin');

        $this->product->remove((int)$id);

        View::redirectTo('/admin');
    }

    /**
     * @param array $params
     * @return void
     */
    public function registerAdminForm(array $params): void
    {
        View::render('admin/login', ['is_register' => true]);
    }

    /**
     * @param array $params
     * @return void
     */
    public function register(array $params): void
    {
        $data = [
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
        ];

        $errors = Validator::validateLogin($data);

        if (!empty($errors)) {
            $_SESSION['error'] = implode(', ', $errors);

            View::redirectTo('/admin/register');
        }

        if ($this->user->exists($data['email'])) {
            $_SESSION['error'] = 'User already exists.';

            View::redirectTo('/admin/register');
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->user->create(['email' => $data['email'], 'password' => $hashedPassword]);

        $_SESSION['admin'] = true;

        View::redirectTo('/admin');
    }

    /**
     * @param array $params
     * @return void
     */
    public function loginForm(array $params): void
    {
        View::render('admin/login');
    }

    /**
     * @param array $params
     * @return void
     */
    public function login(array $params): void
    {
        $data = [
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
        ];

        $errors = Validator::validateLogin($data);

        if (!empty($errors)) {
            $_SESSION['error'] = implode(', ', $errors);
            View::redirectTo('/admin/login');
        }

        $user = $this->user->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            $_SESSION['error'] = 'Invalid credentials';
            View::redirectTo('/admin/login');
        }

        $_SESSION['admin'] = true;

        View::redirectTo('/admin');
    }

    /**
     * @param array $params
     * @return void
     */
    public function logout(array $params): void
    {
        session_destroy();

        View::redirectTo('/');
    }
}
