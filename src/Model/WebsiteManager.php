<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class WebsiteManager
{
    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    public function getById($websiteId) {
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM websites WHERE website_id = :id');
        $query->setFetchMode(\PDO::FETCH_CLASS, Website::class);
        $query->bindParam(':id', $websiteId, \PDO::PARAM_STR);
        $query->execute();
        /** @var Website $website */
        $website = $query->fetch(\PDO::FETCH_CLASS);
        return $website;
    }

    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM websites WHERE user_id = :user');
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Website::class);
    }

    public function create(User $user, $name, $hostname)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO websites (name, hostname, user_id) VALUES (:name, :host, :user)');
        $statement->bindParam(':name', $name, \PDO::PARAM_STR);
        $statement->bindParam(':host', $hostname, \PDO::PARAM_STR);
        $statement->bindParam(':user', $userId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

}