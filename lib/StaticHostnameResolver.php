<?php

class Old_Legacy_CacheWarmer_Resolver_Static implements Old_Legacy_CacheWarmer_Resolver_Interface
{
    private $ip;

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getIp($hostname)
    {
        return $this->ip;
    }
}