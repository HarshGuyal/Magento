<?php
declare(strict_types=1);

namespace Harsh\Blog\Controller\Post;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
// use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\ObjectManager;

class Detail implements HttpGetActionInterface
{   
    public function __construct(
        private Session $session,
        private RequestInterface $request,
    ){
         
    }
    public function execute(){ 
        // die("Harsh ka plus auro hogaya");
        // $om = ObjectManager::getInstance();
        // $session = $om->get(Session::class);
        echo '<pre>';
        var_dump($this->session->getData());
        var_dump($this->request->getParams());
        die();
    }
}