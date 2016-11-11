<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class VarnishManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllByUser(User $user)
    {
        // TODO: add logic here
        $userId = $user->getUserId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM varnishes WHERE user_id = :user');
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    public function getWebsites(Varnish $varnish)
    {
        // TODO: add logic here
        $varnishId = $varnish->getVarnishId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM websites INNER JOIN varnishes_websites ON varnishes_websites.website_id = websites.website_id  WHERE varnish_id = :varnish');
        $query->bindParam(':varnish', $varnishId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Website::class);
    }

    public function getByWebsite(Website $website)
    {
        // TODO: add logic here
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM varnishes INNER JOIN varnishes_websites ON varnishes_websites.varnish_id = varnishes.varnish_id WHERE website_id = :website');
        $query->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    public function create(User $user, $ip)
    {
        // TODO: add logic here
        $userId = $user->getUserId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO varnishes (address, user_id) VALUES (:address, :user)');
        $statement->bindParam(':address', $ip, \PDO::PARAM_STR);
        $statement->bindParam(':user', $userId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    public function link(Varnish $varnish, Website $website)
    {
        // TODO: add logic here
        array_filter($this->getByWebsite($website), function($assocVarnish) use ($website){

            array_filter($this->getWebsites($assocVarnish), function($assocWebsite) use ($assocVarnish, $website){
                if($assocWebsite->website_id == $website->website_id)$this->unlink($assocVarnish, $assocWebsite);
            });

        });

        $query = $this->database->prepare('INSERT INTO varnishes_websites (varnish_id, website_id) VALUES (:varnish, :website)');
        $query->bindParam(':varnish',$varnish->varnish_id, \PDO::PARAM_INT);
        $query->bindParam(':website',$website->website_id, \PDO::PARAM_INT);
        
        return $query->execute();
    }

    public function unlink(Varnish $varnish, Website $website)
    {
        // TODO: add logic here
        $query = $this->database->prepare('DELETE FROM varnishes_websites WHERE varnish_id = :varnish AND website_id = :website');
        $query->bindParam(':varnish',$varnish->varnish_id, \PDO::PARAM_INT);
        $query->bindParam(':website',$website->website_id, \PDO::PARAM_INT);
        return $query->execute();
    }

    public function getById($varnishId) {
        $query = $this->database->prepare('SELECT * FROM varnishes WHERE varnish_id = :id');
        $query->setFetchMode(\PDO::FETCH_CLASS, Varnish::class);
        $query->bindParam(':id', $varnishId, \PDO::PARAM_STR);
        $query->execute();
        $varnish = $query->fetch(\PDO::FETCH_CLASS);
        return $varnish;
    }

    public function getAssociatedVarnish(Website $website)
    {
        foreach($this->getByWebsite($website) as $varnish){
            return $varnish->getIP();
        };

        return null;
    }

}