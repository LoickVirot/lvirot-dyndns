<?php


namespace LVirot\Domain\Ports;


interface IPublicIPCaller
{

    public function getPublicIP(): string;

}