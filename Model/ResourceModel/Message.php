<?php

namespace Danielozano\ProductMessage\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Message extends AbstractDb
{
    const TABLE_NAME = 'product_message';

    const IDENTIFIER = 'entity_id';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::IDENTIFIER);
    }
}
