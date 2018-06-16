<?php

namespace Danielozano\ProductMessage\Api\Data;

use Magento\Framework\Api\CustomAttributesDataInterface;

interface MessageInterface extends CustomAttributesDataInterface
{
    /**
     * Constants for data array keys
     */
    const MESSAGE = 'message';

    const PRODUCT_ID = 'product_id';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId);

    /**
     * @return \Danielozano\ProductMessage\Api\Data\MessageExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * @param MessageExtensionInterface $attributes
     * @return $this
     */
    public function setExtensionAttributes(\Danielozano\ProductMessage\Api\Data\MessageExtensionInterface $attributes);
}
