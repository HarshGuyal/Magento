<?php
declare(strict_types=1);

namespace Harsh\Blog\Controller\Index;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;

class Index implements HttpGetActionInterface
{
    public function __construct(
        // private Session $session,
        private ForwardFactory $forwardFactory,
    ){}

    public function execute(): Forward{
        // // $om = ObjectManager::getInstance();
        // // $session = $om->get(Session::class);
        // echo "<pre>"; 
        // // var_dump($session->getData());
        // // var_dump(new Session());
        // var_dump($this->session->getCustomer());
        // die("Customers");
        $forward = $this->forwardFactory->create();
        return $forward->setController('post')->Forward('list');        
    }
}