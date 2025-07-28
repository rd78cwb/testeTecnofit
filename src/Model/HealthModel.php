<?php
namespace App\Model;

use PDO;

class HealthModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Checa se todas as tabelas existem.
     * @param array $requiredTables Nomes das tabelas que devem existir.
     * @return array
     *   [
     *      'ok' => bool,
     *      'missing' => [tabelas faltando],
     *      'found' => [tabelas encontradas]
     *   ]
     */
    public function checkTables(array $requiredTables)
    {
        $placeholders = implode(',', array_fill(0, count($requiredTables), '?'));
        $sql = "SELECT table_name
                FROM information_schema.tables
                WHERE table_schema = DATABASE()
                  AND table_name IN ($placeholders)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($requiredTables);
        $foundTables = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $missing = array_diff($requiredTables, $foundTables);

        return [
            'ok' => empty($missing),
            'missing' => array_values($missing),
            'found' => $foundTables
        ];
    }
}
