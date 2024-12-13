<?php declare(strict_types=1);

namespace Harsh\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb{


    const TABLE_NAME = "harsh_blog_post";
    const ID_FIELD_NAME = "id";
    protected function _construct(){
        $this->_init( self::TABLE_NAME, self::ID_FIELD_NAME );
    }
}