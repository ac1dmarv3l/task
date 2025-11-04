<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\Database;

final readonly class Product
{
    public function __construct(
        private Database $db,
    )
    {

    }

    /**
     * @param array $filters
     * @return array
     */
    public function getAll(array $filters = []): array
    {
        return $this->db->findAll('products', $filters);
    }

    /**
     * @param int $id
     * @return ?array
     */
    public function getOne(int $id): ?array
    {
        return $this->db->find('products', ['id' => $id]);
    }

    /**
     * @param array $data
     * @return int
     */
    public function add(array $data): int
    {
        return $this->db->insert('products', $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return int
     */
    public function edit(int $id, array $data): int
    {
        return $this->db->update('products', $data, 'id = ?', [$id]);
    }

    /**
     * @param int $id
     * @return int
     */
    public function remove(int $id): int
    {
        return $this->db->delete('products', 'id = ?', [$id]);
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->db->fetchColumn('category', 'products', ['status' => true]);
    }
}
