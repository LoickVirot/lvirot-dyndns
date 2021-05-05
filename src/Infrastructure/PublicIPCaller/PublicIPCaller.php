<?php


namespace LVirot\Infrastructure\PublicIPCaller;


use GuzzleHttp\Client;
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
        $ipRes = $this->client->get('https://ifconfig.co/ip', ['decode_content' => false]);

        return trim($ipRes->getBody()->read(16));
    }
}