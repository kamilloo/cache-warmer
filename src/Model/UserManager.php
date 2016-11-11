<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class UserManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getByLogin($login)
    {
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM users WHERE login = :login');
        $query->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $query->bindParam(':login', $login, \PDO::PARAM_STR);
        $query->execute();
        /** @var User $user */
        $user = $query->fetch(\PDO::FETCH_CLASS);
        return $user;
    }

    public function create($login, $password, $displayName)
    {
        $salt = hash('sha512', microtime());
        $hash = $this->hashPassword($password, $salt);
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO users (login, password_hash, password_salt, display_name) VALUES (:login, :hash, :salt, :name)');
        $statement->bindParam(':login', $login, \PDO::PARAM_STR);
        $statement->bindParam(':hash', $hash, \PDO::PARAM_STR);
        $statement->bindParam(':salt', $salt, \PDO::PARAM_STR);
        $statement->bindParam(':name', $displayName, \PDO::PARAM_STR);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    public function verifyPassword(User $user, $password)
    {
        $hash = $this->hashPassword($password, $user->getPasswordSalt());
        return $hash === $user->getPasswordHash();
    }

    protected function hashPassword($password, $salt)
    {
        return hash('sha512', $password . $salt);
    }
}