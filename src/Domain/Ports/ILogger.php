<?php


namespace LVirot\Domain\Ports;


interface ILogger
{
    public function info(string $message, array $context = []) : void;
    public function critical(string $message, array $context = []) : void;

}