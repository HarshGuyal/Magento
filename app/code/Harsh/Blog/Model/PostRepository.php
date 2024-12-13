<?php declare(strict_types=1);

namespace Harsh\Blog\Model;

use Harsh\Blog\Api\Data\PostInterface;
use Harsh\Blog\Api\PostRepositoryInterface;  
use Harsh\Blog\Model\ResourceModel\Post as PostResourceModel;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PostRepository implements PostRepositoryInterface{

    public function __construct(
        private PostFactory $postFactory,
        private PostResourceModel $postResourceModel,
    ){

    }
    public function getById(int $id): PostInterface
    {
        $post = $this->postFactory->create();
        $this->postResourceModel->load($post,$id);

        if(!$post->getId()){
            throw new NoSuchEntityException(__('the blog post with "%1" ID doesn\t exist.', $id));
        }
        return $post;
    }

    public function save(PostInterface $post): PostInterface
    {
        try{
            $this->postResourceModel->save($post);
        }catch(\Exception $exception){
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $post;
    }

    public function deleteById(int $id): bool
    {
        $post = $this->getById($id);
        try{
            $this->postResourceModel->delete($post);
        }catch(\Exception $exception){
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return true;
    }
}