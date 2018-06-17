<?php

namespace Danielozano\ProductMessage\Model\ResourceModel\Message;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Danielozano\ProductMessage\Model\Message;
use Danielozano\ProductMessage\Model\ResourceModel\Message as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $this->_init(Message::class, ResourceModel::class);
    }
}

