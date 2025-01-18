<?php declare(strict_types=1);

namespace Harsh\Blog\Api;

use Harsh\Blog\Api\Data\PostInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;


/**
 * Summary of PoatRepositoryInterface
 * @api
 * @since 1.0.0
 */
interface PostRepositoryInterface{
    /**
     * Summary of getById
     * @param int $id
     * @return \Harsh\Blog\Api\Data\PostInterface
     * @throws LocalizedException 
     */
    public function getById(int $id): PostInterface;
    /**
     * Summary of save
     * @param \Harsh\Blog\Api\Data\PostInterface $post 
     * @return \Harsh\Blog\Api\Data\PostInterface
     * @throws LocalizedException
     */
    public function save(PostInterface $post): PostInterface;
    /**
     * Summary of deleteById
     * @param int $id
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool;
}