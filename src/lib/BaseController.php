<?php

namespace App\BaseController;

class BaseController
{
    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    protected function errorResponse($message, $statusCode = 400)
    {
        $this->jsonResponse([
            'error' => true,
            'message' => $message
        ], $statusCode);
    }

    // Exemplo de função para leitura do corpo JSON da requisição
    protected function getJsonBody()
    {
        $input = file_get_contents('php://input');
        if (!$input) {
            return [];
        }
        $data = json_decode($input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->errorResponse('Invalid JSON input', 400);
        }
        return $data;
    }
}
