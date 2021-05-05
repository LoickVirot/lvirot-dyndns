<?php


namespace LVirot\Infrastructure\Logger;


use LVirot\Domain\Ports\dtring;
use LVirot\Domain\Ports\ILogger;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MonologLogger implements ILogger
{

    private Logger $logger;

    public function __construct()
    {
        // Create the logger
        $this->logger = new Logger('command_log');
        $this->logger->pushHandler(new StreamHandler(__DIR__.'/../../../logs/lvirotdyndns.log'));

    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }
}