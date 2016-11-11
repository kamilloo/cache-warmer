<?php

namespace Snowdog\DevTest\Model;

class Varnish
{

    public $varnish_id;
    public $name;
    public $address;
    public $user_id;

    public function __construct()
    {
        $this->user_id = intval($this->user_id);
        $this->varnish_id = intval($this->varnish_id);
    }

    /**
     * @return int
     */
    public function getVarnishId()
    {
        return $this->varnish_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getIP()
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}