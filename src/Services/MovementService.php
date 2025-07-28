<?php
namespace App\Services;

use App\Config\Database;
use PDO;

class MovementService
{
    public function handle($vars)
    {
        header('Content-Type: application/json');

        $movement = $vars['movement'] ?? null;

        if (empty($movement)) {
            http_response_code(400);
            echo json_encode(['error' => 'O endpoint deve receber como parâmetro o nome ou identificador de um movimento']);
            return;
        }

        try {
            $pdo = Database::connect();

            // Busca por id
            if (is_numeric($movement) && ctype_digit($movement)) {
                $stmt = $pdo->prepare('SELECT id, name FROM movement WHERE id = ?');
                $stmt->execute([(int)$movement]);
            } else {
                $stmt = $pdo->prepare('SELECT id, name FROM movement WHERE name LIKE ?');
                $stmt->execute([$movement]);
            }
            $movementRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$movementRow) {
                http_response_code(404);
                echo json_encode(['error' => 'Movimento não encontrado']);
                return;
            }

            // Ranking: maior recorde de cada usuário para esse movimento
            $sql = "
                SELECT
                    u.name AS user_name,
                    pr.value AS ranking,
                    pr.date AS date_ranking
                FROM personal_record pr
                INNER JOIN user u ON pr.user_id = u.id
                WHERE pr.movement_id = :movement_id
                  AND (pr.user_id, pr.value) IN (
                    SELECT pr2.user_id, MAX(pr2.value)
                    FROM personal_record pr2
                    WHERE pr2.movement_id = :movement_id
                    GROUP BY pr2.user_id
                )
                ORDER BY pr.value DESC, pr.date ASC
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['movement_id' => $movementRow['id']]);
            $rankingData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $ranking   = 0;
            $position  = 0;
            $positionP = 0;
            foreach ($rankingData as &$item) {
                if( $ranking <> $item['ranking'] ) {
                    $ranking = $item['ranking'];
                    $positionP++;
                    $position = $positionP;
                    $item['posicao_ranking'] = $position;
                } else {
                    $positionP++;
                    $item['posicao_ranking'] = $position;
                }
            }

            $result = [
                'nome_movimento' => $movementRow['name'],
                'ranking' => $rankingData
            ];

            echo json_encode($result, JSON_PRETTY_PRINT);

        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro interno',
                'details' => $e->getMessage()
            ]);
        }
    }


    public function handleFull($vars)
    {
        header('Content-Type: application/json');

        $movement = $vars['movement'] ?? null;

        if (empty($movement)) {
            http_response_code(400);
            echo json_encode(['error' => 'O endpoint deve receber como parâmetro o nome ou identificador de um movimento']);
            return;
        }

        try {
            $pdo = Database::connect();

            // Busca por id
            if (is_numeric($movement) && ctype_digit($movement)) {
                $stmt = $pdo->prepare('SELECT id, name FROM movement WHERE id = ?');
                $stmt->execute([(int)$movement]);
            } else {
                $stmt = $pdo->prepare('SELECT id, name FROM movement WHERE name LIKE ?');
                $stmt->execute([$movement]);
            }
            $movementRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$movementRow) {
                http_response_code(404);
                echo json_encode(['error' => 'Movimento não encontrado']);
                return;
            }

            // Ranking: maior recorde de cada usuário para esse movimento
            $sql = "
                SELECT
                    u.name AS user_name,
                    pr.value AS ranking,
                    pr.date AS date_ranking
                FROM personal_record pr
                INNER JOIN user u ON pr.user_id = u.id
                WHERE pr.movement_id = :movement_id
                ORDER BY pr.value DESC, pr.date ASC
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['movement_id' => $movementRow['id']]);
            $rankingData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $ranking   = 0;
            $position  = 0;
            $positionP = 0;
            foreach ($rankingData as &$item) {
                if( $ranking <> $item['ranking'] ) {
                    $ranking = $item['ranking'];
                    $positionP++;
                    $position = $positionP;
                    $item['posicao_ranking'] = $position;
                } else {
                    $positionP++;
                    $item['posicao_ranking'] = $position;
                }
            }

            $result = [
                'nome_movimento' => $movementRow['name'],
                'ranking' => $rankingData
            ];

            echo json_encode($result, JSON_PRETTY_PRINT);

        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Erro interno',
                'details' => $e->getMessage()
            ]);
        }
    }
}
