<?php declare(strict_types=1);
namespace Harsh\Minerva\Model\ResourceModel\Faq;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Harsh\Minerva\Model\Faq;
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Faq::class, \Harsh\Minerva\Model\ResourceModel\Faq::class);
    }
}