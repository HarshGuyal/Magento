<?php declare(strict_types=1);

namespace Harsh\Blog\Setup\Patch\Data;

use Harsh\Blog\Api\PostRepositoryInterface;
use Harsh\Blog\Model\PostFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class PopulateBlogPosts implements DataPatchInterface{

    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private PostFactory $postFactory,
        private PostRepositoryInterface $postRepository,
    ){}
    public static function getDependencies(): array
    {
        return [];
    } 

    public function getAliases(): array{
        return [];
    }

    public function apply(){
        // $this->moduleDataSetup->startSetup();
        // //code
        // $post = $this->postFactory->create();
        // $post->setdata(
        //     [
        //         'title'=> 'an awesome post',
        //         'content'=>'this is toatally awesome',
        //     ],
        // );
        // $this->postRepository->save($post);
        // $this->moduleDataSetup->endSetup();

        $this->moduleDataSetup->startSetup();

        $posts = [
            [
                'title' => 'Today is sunny',
                'content' => 'The weather has been great all week.',
            ],
            [
                'title' => 'My movie review',
                'content' => 'I give this movie 5 out of 5 stars!',
            ],
        ];

        foreach ($posts as $postData) {
            $post = $this->postFactory->create();
            $post->setData($postData);
            $this->postRepository->save($post);
        }

        $this->moduleDataSetup->endSetup();
    }
}
