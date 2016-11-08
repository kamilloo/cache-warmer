<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Core\Database;

class PageStat
{


    /**
     * @var Database|\PDO
     */
    private $database;
    /**
     * @var user
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->database = new Database;

    }

    public function getTotalUserPages()
    {
        $query = $this->database->prepare('SELECT COUNT(page_id) as total_pages FROM pages INNER JOIN websites ON websites.website_id = pages.website_id WHERE user_id = :user_id');
        $query->bindParam('user_id',$this->user->user_id, \PDO::PARAM_INT);

        $result = $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $result['total_pages'];
    }

    public function getLeastRecentlyPage()
    {
        $query = $this->database->prepare('SELECT CONCAT_WS("/",hostname,url) as least_recently FROM pages INNER JOIN websites ON websites.website_id = pages.website_id WHERE user_id = :user_id ORDER BY lastVisitTime ASC LIMIT 1');
        $query->bindParam('user_id',$this->user->user_id, \PDO::PARAM_INT);

        $result = $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        return $result['least_recently'];
    }

    public function getMostRecentlyPage()
    {
        $query = $this->database->prepare('SELECT CONCAT_WS("/",hostname,url) as most_recently FROM pages INNER JOIN websites ON websites.website_id = pages.website_id WHERE user_id = :user_id ORDER BY lastVisitTime DESC LIMIT 1');
        $query->bindParam('user_id',$this->user->user_id, \PDO::PARAM_INT);

        $result = $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $result['most_recently'];
    }


}