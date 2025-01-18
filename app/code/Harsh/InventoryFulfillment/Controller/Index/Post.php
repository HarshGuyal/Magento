<?php declare(strict_types=1);

namespace Harsh\InventoryFulfillment\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;

class Post implements HttpPostActionInterface{
    /**
     * Summary of jsonFactory
     * @var JsonFactory
     */
    private $jsonFactory;
    /**
     * Summary of __construct
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        JsonFactory $jsonFactory
    ){
        $this->jsonFactory = $jsonFactory;
    }
    /**
     * Summary of execute
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute():Json{
        $json = $this->jsonFactory->create(); 

        return $json->setData(['success'=> true]);
    }
}