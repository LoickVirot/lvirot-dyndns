<?php


namespace LVirot\Domain\Model;


class DNSEntry
{

    private string $name;

    private string $ip;

    private string $type;

    private bool $proxied;

    private int $ttl;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DNSEntry
     */
    public function setName(string $name): DNSEntry
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return DNSEntry
     */
    public function setIp(string $ip): DNSEntry
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return DNSEntry
     */
    public function setType(string $type): DNSEntry
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProxied(): bool
    {
        return $this->proxied;
    }

    /**
     * @param bool $proxied
     * @return DNSEntry
     */
    public function setProxied(bool $proxied): DNSEntry
    {
        $this->proxied = $proxied;
        return $this;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @param int $ttl
     * @return DNSEntry
     */
    public function setTtl(int $ttl): DNSEntry
    {
        $this->ttl = $ttl;
        return $this;
    }



}