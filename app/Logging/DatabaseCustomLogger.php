<?php

namespace App\Logging;

use Monolog\Logger;

class DatabaseCustomLogger
{
    /**
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('DatabaseLoggingHandler');
        return $logger->pushHandler(new DatabaseLoggingHandler($config['level']));
    }
}
