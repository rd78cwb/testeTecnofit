<?php
namespace App\Services;

use App\Config\Database;
use App\Model\HealthModel;

class HealthService
{
    public function handle()
    {
        header('Content-Type: application/json');
        try {
            $pdo = Database::connect();
            $healthModel = new HealthModel($pdo);

            //Verificando as tabelas
            $requiredTables = ['user', 'movement', 'personal_record'];
            $result = $healthModel->checkTables($requiredTables);

            if ($result['ok']) {
                http_response_code(200);
                echo json_encode(['status' => 'ok', 'message' => 'Conexão e tabelas ok.']);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Tabelas ausentes.',
                    'missing_tables' => $result['missing']
                ]);
            }
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Falha na conexão.',
                'details' => $e->getMessage()
            ]);
        }
    }

}
