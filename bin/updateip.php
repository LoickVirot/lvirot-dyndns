<?php

use LVirot\Application\Command\Main;
use LVirot\Infrastructure\DNSCaller\CloudflareCaller;
use LVirot\Infrastructure\Logger\MonologLogger;
use LVirot\Infrastructure\PublicIPCaller\PublicIPCaller;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$logger = new MonologLogger();

$main = new Main(
    new CloudflareCaller($logger),
    new PublicIPCaller(),
    $logger
);
$main->launch();
