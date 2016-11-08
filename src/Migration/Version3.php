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
        $this->addTimeStampToPageTable();
    }

    private function addTimeStampToPageTable()
    {
        $createQuery = 'ALTER TABLE pages ADD lastVisitTime TIMESTAMP DEFAULT 0';
        $this->database->exec($createQuery);
    }
}