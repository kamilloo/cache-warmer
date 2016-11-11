<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;

class CreateVarnishAction
{
    /**
     * @var VarnishManager
     */
    private $varnishManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
    }

    public function execute()
    {
        $ip = $_POST['ip'];

        // TODO - add module logic here

        if(!empty($ip)) {
            if (isset($_SESSION['login'])) {
                $user = $this->userManager->getByLogin($_SESSION['login']);
                if ($user) {
                    if ($this->varnishManager->create($user, $ip)) {
                        $_SESSION['flash'] = 'Varnish ' . $ip . ' added!';
                    }
                }
            }
        } else {
            $_SESSION['flash'] = 'IP cannot be empty!';
        }

        header('Location: /varnish');
    }
}