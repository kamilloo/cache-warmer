<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\Varnish;
use Snowdog\DevTest\Model\VarnishManager;
use Snowdog\DevTest\Model\WebsiteManager;

class CreateVarnishLinkAction
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var VarnishManager
     */
    private $varnishManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager, WebsiteManager $websiteManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
        $this->websiteManager = $websiteManager;
    }

    public function execute()
    {
        // TODO: add module logic here
        $checked = $_POST['checked'];
        $varnish_id = $_POST['varnish_id'];
        $website_id = $_POST['website_id']; 

        $this->message = '';
        if(isset($checked) && !empty($varnish_id) && !empty($website_id)) {
            if (isset($_SESSION['login'])) {
                $user = $this->userManager->getByLogin($_SESSION['login']);
                if ($user) {
                    $varnish = $this->varnishManager->getById($varnish_id);
                    $website = $this->websiteManager->getById($website_id);
                    if ($checked)
                    {
                        if($this->varnishManager->link($varnish, $website))
                        {
                            $this->message = 'Varnish and webside were associated';
                        }
                    }else{
                        if($this->varnishManager->unlink($varnish, $website))
                        {
                            $this->message = 'Varnish and webside were disassociated';
                        }
                    }
                }
            }
        }else{
            
            $this->message = 'Lost data!';

        }

        echo $this->message;
    }
}