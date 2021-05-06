<?php

namespace LVirot\Infrastructure\DNSCaller;

use Exception;
use GuzzleHttp\Client;
use LVirot\Domain\Model\DNSEntry;
use LVirot\Domain\Ports\IDNSCaller;
use LVirot\Domain\Ports\ILogger;

class CloudflareCaller implements IDNSCaller
{

    private Client $client;

    private ILogger $logger;

    private string $dnsEntryName;

    private string $apikey;

    private string $zoneId;

    private string $recordId;

    public function __construct(ILogger $logger) {
        $this->logger = $logger;

        $this->client = new Client([
            'base_uri' => $_ENV['CF_URL'],
        ]);

        $this->apikey = $_ENV['CF_APIKEY'];
        $this->dnsEntryName = $_ENV['CF_RECORD'];
        $this->zoneId = $_ENV['CF_ZONE_ID'];
        $this->recordId = $_ENV['CF_RECORD_ID'];

    }

    public function getRecord(): DNSEntry {

        $this->logger->info('Getting ' . $this->dnsEntryName . ' infos.');

        try {
            $request = $this->client->get('/client/v4/zones/' . $this->zoneId . '/dns_records/' . $this->recordId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apikey
                ]
            ]);
            return $this->parseResponse($request);
        } catch (Exception $e) {
            $this->logger->critical('Error while retrieving DNS infos.', [
                'exception' => $e
            ]);
        }
        return new DNSEntry();
    }

    public function refreshDns(string $ip): DNSEntry {
        $this->logger->info("Changing DNS ip to {$ip}.");

        $type = "A";
        if (strlen($ip) > 15) {
            $type = "AAAA";
        }

        $request = $this->client->put('/client/v4/zones/' . $this->zoneId . '/dns_records/' . $this->recordId, [
        'headers' => [
            'Authorization' => 'Bearer ' . $this->apikey
        ],
        'body'    => json_encode([
            'type'    => $type,
            'name'    => $this->dnsEntryName,
            'proxied' => true,
            'content' => $ip,
            'ttl'     => 1
            ])
        ]);
        $dnsEntry = $this->parseResponse($request);

        $this->logger->info("new DNS IP: {$dnsEntry->getIp()}.");

        return $dnsEntry;
    }

    private function parseResponse($request) : DNSEntry
    {
        $rawBody = $request->getBody();

        $recordResult = '';
        while (!$rawBody->eof()) {
            $recordResult .= $rawBody->read(1024);
        }
        $recordResult = json_decode($recordResult, true);

        $dnsEntry = new DNSEntry();
        $dnsEntry
            ->setName($recordResult['result']['name'])
            ->setIp($recordResult['result']['content'])
            ->setType($recordResult['result']['type'])
            ->setProxied($recordResult['result']['proxied'])
            ->setTtl($recordResult['result']['ttl'])
        ;

        return $dnsEntry;
    }

}
