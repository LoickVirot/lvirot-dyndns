<?php


namespace LVirot\Application\Command;


use LVirot\Domain\Ports\IDNSCaller;
use LVirot\Domain\Ports\ILogger;
use LVirot\Domain\Ports\IPublicIPCaller;

class Main
{

    private IDNSCaller $dnsCaller;

    private IPublicIPCaller $publicIPCaller;

    private ILogger $logger;

    public function __construct(IDNSCaller $dnsCaller, IPublicIPCaller $publicIPCaller, ILogger $logger)
    {
        $this->dnsCaller = $dnsCaller;
        $this->publicIPCaller = $publicIPCaller;
        $this->logger = $logger;
    }

    public function launch() {

        $this->logger->info('Launch lvirot/dyndns command');

        $dns = $this->dnsCaller->getRecord();
        $ip = $this->publicIPCaller->getPublicIP();

        if ($ip !== $dns->getIp()) {
            $res = $this->dnsCaller->refreshDns($ip);
        } else {
            $this->logger->info("IP has not been changed. Skipping.");
        }
    }
}