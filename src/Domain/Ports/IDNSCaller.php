<?php 

namespace LVirot\Domain\Ports;

use LVirot\Domain\Model\DNSEntry;

interface IDNSCaller {
  
  public function getRecord(): DNSEntry;
  
  public function refreshDns(string $ip): DNSEntry;
  
}