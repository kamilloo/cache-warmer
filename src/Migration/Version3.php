<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;

class Version3
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
        $this->createVarnishTable();
    }

    private function createVarnishTable()
    {
      $createQuery = <<<SQL
CREATE TABLE `varnishes` (
  `varnish_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`varnish_id`),
  UNIQUE KEY `address` (`address`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `varnish_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

}