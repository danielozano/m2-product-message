<?php

namespace Danielozano\ProductMessage\Api;

use Danielozano\ProductMessage\Api\Data\MessageInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface MessageRepositoryInterface
{
    /**
     * @param int $id
     * @return \Danielozano\ProductMessage\Api\Data\MessageInterface
     */
    public function getById($id);

    /**
     * @param \Danielozano\ProductMessage\Api\Data\MessageInterface $message
     * @return \Danielozano\ProductMessage\Api\Data\MessageInterface
     */
    public function save(MessageInterface $message);

    /**
     * @param \Danielozano\ProductMessage\Api\Data\MessageInterface $message
     * @return bool Will return true if deleted
     */
    public function delete(MessageInterface $message);

    /**
     * @param int $id
     * @return bool Will return true if deleted
     */
    public function deleteById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Danielozano\ProductMessage\Api\Data\MessageSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
