<?php

declare(strict_types=1);

namespace App\Core;

final class Validator
{
    /**
     * @param array $data
     * @return array
     */
    public static function validateProduct(array $data): array
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'Title is required.';
        } elseif (!is_string($data['title']) || strlen($data['title']) > 255) {
            $errors['title'] = 'Title must be string with maximum 255 characters.';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Description is required.';
        } elseif (!is_string($data['description'])) {
            $errors['description'] = 'Description must be string.';
        }

        if (empty($data['category'])) {
            $errors['category'] = 'Category is required';
        } elseif (!is_string($data['category']) || strlen($data['category']) > 100) {
            $errors['category'] = 'Category must be string with maximum 100 characters.';
        }

        if (!isset($data['price']) || $data['price'] === '') {
            $errors['price'] = 'Price is required.';
        } elseif (!is_numeric($data['price']) || $data['price'] < 0 || $data['price'] > 9999999.99) {
            $errors['price'] = 'Price must be positive number less than 999999.99.';
        }

        if (!empty($data['image']) && !filter_var($data['image'], FILTER_VALIDATE_URL)) {
            $errors['image'] = 'Image URL must be valid URL.';
        }

        return $errors;
    }

    /**
     * @param array $data
     * @return array
     */
    public static function validateLogin(array $data): array
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email.';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password is required.';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must contain at least 6 characters.';
        }

        return $errors;
    }
}
