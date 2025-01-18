<?php declare(strict_types= 1);

namespace Harsh\Blog\ViewModel;

use Harsh\Blog\Api\Data\PostInterface;
use Harsh\Blog\Api\PostRepositoryInterface;
use Harsh\Blog\Model\PostRepository;
use Harsh\Blog\Model\ResourceModel\Post\Collection;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Post implements ArgumentInterface
{   
    public function __construct(
        private Collection $collection,
        private PostRepositoryInterface $postRepository,
        private RequestInterface $request,
    ){}
    public function getlist(): array
    {
        // return [
        //     new DataObject(['id'=>1, 'title'=>'Post A']),
        //     new DataObject(['id'=>2, 'title'=>'Post B']),
        //     // new DataObject(['id'=>3, 'title'=>'Post C']),
        //     // new DataObject(['id'=>4, 'title'=>'Post D']),
        // ];

        return $this->collection->getItems();
    }

    public function getcount(): int
    {
        // return (int) count($this->getlist());
        return $this->collection->count();
    }

    public function getDetail():PostInterface {
        $id = (int)$this->request->getParam('id');
        return $this->postRepository->getById($id);
    }
}