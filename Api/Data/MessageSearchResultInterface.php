<?php

namespace Danielozano\ProductMessage\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface MessageSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Danielozano\ProductMessage\Api\Data\MessageInterface[]
     */
    public function getItems();

    /**
     * @param \Danielozano\ProductMessage\Api\Data\MessageInterface[] $items
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function setItems(array $items);
}
