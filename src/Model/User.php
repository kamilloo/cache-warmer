<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Model\PageStat;


class User
{
    public $user_id;
    public $login;
    public $password_hash;
    public $password_salt;
    public $display_name;
     /**
     * @user website stats
     */
    private $stats;

    public function __construct()
    {
        $this->user_id = intval($this->user_id);
        $this->stats = new PageStat($this);
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    /**
     * @return string
     */
    public function getPasswordSalt()
    {
        return $this->password_salt;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }
    
    /**
     * @return int
    */
    public function getTotalUserPages()
    {
        return $this->stats->getTotalUserPages();
    }
    /**
     * @return DateTime
    */
    public function getLeastRecentlyPage() 
    {
        return $this->stats->getLeastRecentlyPage();
    }
    /**
     * @return DateTime
    */
    public function getMostRecentlyPage()
    {
        return $this->stats->getMostRecentlyPage();
    }

    

}