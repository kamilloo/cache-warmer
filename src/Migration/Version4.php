<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;

class Version4
{
    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function __invoke()
    {
        $this->createVarnishWebsiteTable();
    }

    private function createVarnishWebsiteTable()
    {
      $createQuery = <<<SQL
CREATE TABLE `varnishes_websites` (
  `varnish_id` int(11) unsigned NOT NULL,
  `website_id` int(11) unsigned NOT NULL,
  KEY `varnish_id` (`varnish_id`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `website_warnish_fk` FOREIGN KEY (`varnish_id`) REFERENCES `varnishes` (`varnish_id`),
  CONSTRAINT `varnish_website_fk` FOREIGN KEY (`website_id`) REFERENCES `websites` (`website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

}