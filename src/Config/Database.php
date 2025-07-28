<?php

namespace App\Config;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            $host     = $_ENV['DB_HOST'] ?? 'localhost';
            $port     = $_ENV['DB_PORT'] ?? '3306';
            $database = $_ENV['DB_DATABASE'] ?? '';
            $username = $_ENV['DB_USERNAME'] ?? '';
            $password = $_ENV['DB_PASSWORD'] ?? '';

            $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";

            try {
                self::$connection = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_PERSISTENT => false,
                ]);
            } catch (PDOException $e) {
                //Retornando erro na conexao
                throw new \RuntimeException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), 500, $e);
            }
        }
        return self::$connection;
    }
}
