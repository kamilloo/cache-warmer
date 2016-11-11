<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;
use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;

class Version2
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
    /**
     * @var PageManager
     */
    private $pageManager;

    public function __construct(
        Database $database,
        UserManager $userManager,
        WebsiteManager $websiteManager,
        PageManager $pageManager
    ) {
        $this->database = $database;
        $this->userManager = $userManager;
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
    }

    public function __invoke()
    {
        $this->createPageTable();
        $this->addPageData();
    }

    private function createPageTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `pages` (
  `page_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `website_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `page_website_fk` FOREIGN KEY (`website_id`) REFERENCES `websites` (`website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function addPageData()
    {
        $testUser = $this->userManager->getByLogin('test');
        foreach($this->websiteManager->getAllByUser($testUser) as $website) {
            $this->pageManager->create($website, 'index.html');
            $this->pageManager->create($website, 'index.en.html');
            $this->pageManager->create($website, 'contact-us.html');
        }

        $exampleUser = $this->userManager->getByLogin('example');
        foreach($this->websiteManager->getAllByUser($exampleUser) as $website) {
            $this->pageManager->create($website, 'index.php');
            $this->pageManager->create($website, 'product.php');
            $this->pageManager->create($website, 'category.php');
        }

        $demoUser = $this->userManager->getByLogin('demo');
        foreach($this->websiteManager->getAllByUser($demoUser) as $website) {
            $this->pageManager->create($website, 'home.jsp');
            $this->pageManager->create($website, 'contact.jsp');
        }
    }
}