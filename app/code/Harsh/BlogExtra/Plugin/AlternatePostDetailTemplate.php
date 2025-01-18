<?php declare (strict_types= 1);

namespace Harsh\blogExtra\Plugin;

use Harsh\Blog\Controller\Post\Sidebar;
use Magento\Framework\App\RequestInterface;

class AlternatePostDetailTemplate{
    public function __construct(
        private RequestInterface $request,
    ){}
    public function afterExecute(
        Sidebar $subject,
        $result,
    )
    {
        if($this->request->getParam('alternate')){
            $result->getLayout()
                ->getBlock('blog.post.detail')
                ->setTemplate('Harsh_BlogExtra::post/detail.phtml');
        }
        return $result;
    
    }
}