<?php

namespace Danielozano\ProductMessage\Model;

use Danielozano\ProductMessage\Api\Data\MessageExtensionInterface;
use Danielozano\ProductMessage\Api\Data\MessageInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Message extends AbstractExtensibleModel implements MessageInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Message::class);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->_getData(self::ID);
    }

    /**
     * Get message text
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_getData(self::MESSAGE);
    }

    /**
     * @inheritdoc
     */
    public function setMessage($message)
    {
        $this->setData(self::MESSAGE, $message);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        return $this->_getData(self::UPDATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @inheritdoc
     */
    public function getProductId()
    {
        return $this->_getData(self::PRODUCT_ID);
    }

    /**
     * @inheritdoc
     */
    public function setProductId($productId)
    {
        $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(\Danielozano\ProductMessage\Api\Data\MessageExtensionInterface $attributes)
    {
        $this->_setExtensionAttributes($attributes);
    }
}
