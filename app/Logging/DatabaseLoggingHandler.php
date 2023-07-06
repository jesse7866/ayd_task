<?php

namespace App\Logging;

use App\Models\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class DatabaseLoggingHandler extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        try {
            $data = array(
                'message'     => $record['message'],
                'channel'     => $record['channel'],
                'level'       => $record['level'],
                'level_name'  => $record['level_name'],
                'context'     => json_encode($record['context']),
                'extra'       => json_encode($record['extra']),
                'formatted'   => $record['formatted'],
                'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent'  => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'created_at'  => date("Y-m-d H:i:s"),
            );

            Logger::suffix()->insert($data);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
