<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;

class CreatePageAction
{

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->userManager = $userManager;
    }

    public function execute()
    {
        $url = $_POST['url'];
        $websiteId = $_POST['website_id'];

        if (isset($_SESSION['login'])) {
            $user = $this->userManager->getByLogin($_SESSION['login']);
            $website = $this->websiteManager->getById($websiteId);

            if ($website->getUserId() == $user->getUserId()) {
                if (empty($url)) {
                    $_SESSION['flash'] = 'URL cannot be empty!';
                } else {
                    if ($this->pageManager->create($website, $url)) {
                        $_SESSION['flash'] = 'URL ' . $url . ' added!';
                    }
                }
            }
        }

        header('Location: /website/' . $websiteId);
    }
}