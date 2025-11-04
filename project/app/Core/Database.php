<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;

final class Database
{
    private static ?self $instance = null;

    private PDO $pdo;

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $dbParams = require ROOT_PATH . '/config/database.php';

        $host = $dbParams['host'];
        $port = $dbParams['port'];
        $dbname = $dbParams['dbname'];
        $username = $dbParams['username'];
        $password = $dbParams['password'];
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * @param string $type
     * @param array $params
     * @return string
     */
    private function buildQuery(string $type, array $params): string
    {
        $table = $params['table'];

        switch ($type) {
            case 'select':
                $select = $params['select'] ?? '*';
                $where = $params['where'] ?? '';
                $limit = $params['limit'] ?? '';
                $query = "SELECT $select FROM $table";

                if ($where) {
                    $query .= " WHERE $where";
                }

                if ($limit) {
                    $query .= " LIMIT $limit";
                }

                return $query;

            case 'insert':
                $columns = implode(',', $params['columns']);
                $placeholders = implode(',', array_fill(0, count($params['columns']), '?'));

                return "INSERT INTO $table ($columns) VALUES ($placeholders)";

            case 'update':
                $set = implode(',', $params['set']);
                $where = $params['where'];

                return "UPDATE $table SET $set WHERE $where";

            case 'delete':
                $where = $params['where'];

                return "DELETE FROM $table WHERE $where";

            case 'fetchColumn':
                $column = $params['column'];
                $where = $params['where'] ?? '';
                $query = "SELECT DISTINCT $column FROM $table";
                if ($where) {
                    $query .= " WHERE $where";
                }

                return $query;
        }

        return '';
    }

    /**
     * @param array $conditions
     * @param array $params
     * @return string
     */
    private function buildWhere(array $conditions, array &$params): string
    {
        $whereParams = [];

        foreach ($conditions as $column => $val) {
            if (is_array($val)) {
                if (isset($val['op']) && $val['op'] === 'BETWEEN') {
                    $whereParams[] = $column . ' BETWEEN ? AND ?';
                    $params[] = $val['value'][0];
                    $params[] = $val['value'][1];
                } else {
                    $op = $val['op'] ?? '=';
                    $value = $val['value'] ?? $val;
                    $whereParams[] = $column . ' ' . $op . ' ?';
                    $params[] = $value;
                }
            } else {
                $whereParams[] = $column . ' = ?';
                $params[] = $val;
            }
        }

        return implode(' AND ', $whereParams);
    }

    /**
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    private function execute(string $query, array $params = []): PDOStatement
    {
        $statement = $this->pdo->prepare($query);

        if ($statement === false) {
            throw new PDOException("Prepare failed: " . $query);
        }

        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $type = PDO::PARAM_NULL;
            } else {
                $type = PDO::PARAM_STR;
            }

            $paramKey = is_int($key) ? $key + 1 : $key;

            $statement->bindValue($paramKey, $value, $type);
        }

        $statement->execute();

        return $statement;
    }

    /**
     * @param string $table
     * @param array $data
     * @return int
     */
    public function insert(string $table, array $data): int
    {
        $columns = array_keys($data);
        $query = $this->buildQuery('insert', ['table' => $table, 'columns' => $columns]);
        $values = array_values($data);

        $this->execute($query, $values);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * @param string $table
     * @param array $data
     * @param string $where
     * @param array $whereParams
     * @return int
     */
    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $columns = array_keys($data);
        $set = [];

        foreach ($columns as $column) {
            $set[] = $column . ' = ?';
        }

        $query = $this->buildQuery('update', ['table' => $table, 'set' => $set, 'where' => $where]);

        $params = array_merge(array_values($data), $whereParams);

        $statement = $this->execute($query, $params);

        return $statement->rowCount();
    }

    /**
     * @param string $table
     * @param string $where
     * @param array $whereParams
     * @return int
     */
    public function delete(string $table, string $where, array $whereParams = []): int
    {
        $query = $this->buildQuery('delete', ['table' => $table, 'where' => $where]);

        $statement = $this->execute($query, $whereParams);

        return $statement->rowCount();
    }

    /**
     * @param string $table
     * @param array $conditions
     * @return ?array
     */
    public function find(string $table, array $conditions = []): ?array
    {
        $params = [];
        $where = '';

        if (!empty($conditions)) {
            $where = $this->buildWhere($conditions, $params);
        }

        $query = $this->buildQuery('select', ['table' => $table, 'where' => $where, 'limit' => 1]);

        $statement = $this->execute($query, $params);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    /**
     * @param string $table
     * @param array $conditions
     * @return array
     */
    public function findAll(string $table, array $conditions = []): array
    {
        $params = [];
        $where = '';

        if (!empty($conditions)) {
            $where = $this->buildWhere($conditions, $params);
        }

        $query = $this->buildQuery('select', ['table' => $table, 'where' => $where]);

        $statement = $this->execute($query, $params);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $column
     * @param string $table
     * @param array $conditions
     * @return array
     */
    public function fetchColumn(string $column, string $table, array $conditions = []): array
    {
        $params = [];
        $where = '';

        if (!empty($conditions)) {
            $where = $this->buildWhere($conditions, $params);
        }

        $query = $this->buildQuery('fetchColumn', ['table' => $table, 'column' => $column, 'where' => $where]);

        $statement = $this->execute($query, $params);

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    final public function __clone(): void
    {
    }

    final public function __wakeup(): void
    {
    }
}
