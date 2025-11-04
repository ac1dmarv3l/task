<?php

declare(strict_types=1);

namespace App\Model;

use App\Core\Database;

final readonly class User
{
    public function __construct(
        private Database $db,
    )
    {
    }

    /**
     * @param string $email
     * @return ?array
     */
    public function findByEmail(string $email): ?array
    {
        return $this->db->find('users', ['email' => $email]);
    }

    /**
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        return $this->db->insert('users', $data);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function exists(string $email): bool
    {
        return $this->db->find('users', ['email' => $email]) !== null;
    }
}
