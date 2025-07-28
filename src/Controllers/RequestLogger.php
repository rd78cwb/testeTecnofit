<?php

class RequestLogger
{
    private $logFile;

    public function __construct($logDir = '/var/log/php', $logFileName = 'requests.log')
    {
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $this->logFile = rtrim($logDir, '/') . '/' . $logFileName;
    }

    public function log()
    {
        $data = [
            'datetime'  => date('Y-m-d H:i:s'),
            'ip'        => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'method'    => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
            'uri'       => $_SERVER['REQUEST_URI'] ?? 'unknown',
            'user_agent'=> $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'body'      => file_get_contents('php://input')
        ];

        $logLine = json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL;
        file_put_contents($this->logFile, $logLine, FILE_APPEND | LOCK_EX);
    }
}
