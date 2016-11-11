<?php

namespace Snowdog\DevTest\Model;

class User
{
    public $user_id;
    public $login;
    public $password_hash;
    public $password_salt;
    public $display_name;

    public function __construct()
    {
        $this->user_id = intval($this->user_id);
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
    

}