<?php


namespace LVirot\Infrastructure\PublicIPCaller;


use GuzzleHttp\Client;
use LVirot\Domain\Model\DNSEntry;
use LVirot\Domain\Ports\IPublicIPCaller;

class PublicIPCaller implements IPublicIPCaller
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }


    public function getPublicIP(): string
    {
        $ipRes = $this->client->get('https://api.ipify.org', ['decode_content' => false]);

        $rawBody = $ipRes->getBody();

        $body = '';
        while (!$rawBody->eof()) {
            $body .= $rawBody->read(16);
        }

        return trim($body);
    }
}