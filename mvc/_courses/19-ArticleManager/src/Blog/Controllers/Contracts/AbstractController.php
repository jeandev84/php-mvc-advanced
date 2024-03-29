<?php
namespace Blog\Controllers\Contracts;

use Blog\Models\Users\User;
use Blog\Services\UserAuthService;
use Framework\Templating\View;


/**
 * Class AbstractController
 * @package Blog\Controllers\Contracts
*/
abstract class AbstractController
{

    /** @var View */
    protected $view;

    /** @var User|null */
    protected $user;

    /**
     * AbstractController constructor.
    */
    public function __construct()
    {
        $this->user = UserAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../../templates');
        $this->view->setVar('user', $this->user);
    }
}
