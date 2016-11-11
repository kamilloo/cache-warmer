<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;

class Version1
{
    /**
     * @var Database|\PDO
     */
    private $database;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    public function __construct(Database $database, UserManager $userManager, WebsiteManager $websiteManager)
    {
        $this->database = $database;
        $this->userManager = $userManager;
        $this->websiteManager = $websiteManager;
    }

    public function __invoke()
    {
        $this->createUserTable();
        $this->createWebsiteTable();

        $this->addUsers();
        $this->addWebsites();
    }

    private function createUserTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password_hash` varchar(128) NOT NULL,
  `password_salt` varchar(128) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function createWebsiteTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `websites` (
  `website_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`website_id`),
  UNIQUE KEY `hostname` (`hostname`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `website_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function addUsers()
    {
        $this->userManager->create('test', 'password', 'First Test User');
        $this->userManager->create('example', 'password123', 'Example User');
        $this->userManager->create('demo', '123password123', 'Demo User');
    }

    private function addWebsites()
    {
        $testUser = $this->userManager->getByLogin('test');
        $this->websiteManager->create($testUser, 'Test', 'test.com');
        $this->websiteManager->create($testUser, 'Test Store', 'store.test.com');
        $this->websiteManager->create($testUser, 'Test Blog', 'blog.test.com');

        $exampleUser = $this->userManager->getByLogin('example');
        $this->websiteManager->create($exampleUser, 'Example (dot) Com', 'www.example.com');
        $this->websiteManager->create($exampleUser, 'Example Store', 'store.example.com');

        $demoUser = $this->userManager->getByLogin('demo');
        $this->websiteManager->create($demoUser, 'Demo', 'demo.org');
    }
}