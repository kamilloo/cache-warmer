<?php

namespace Snowdog\DevTest\Model;

class Page
{

    public $page_id;
    public $url;
    public $website_id;
    private $lastVisitTime;
    
    public function __construct()
    {
        $this->website_id = intval($this->website_id);
        $this->page_id = intval($this->page_id);
    
    }

    /**
     * @return int
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getWebsiteId()
    {
        return $this->website_id;
    }

    public function getLastVisitTime()
    {
        return (int)$this->lastVisitTime ? $this->lastVisitTime : 'no cache';
    }

    public function updateLastVisitTime()
    {
        $this->lastVisitTime = (new \DateTime)->format('Y-m-d H:m:s');

        return $this->lastVisitTime;
    }


    
}