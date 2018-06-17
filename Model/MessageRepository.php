<?php

namespace Danielozano\ProductMessage\Model;

use Danielozano\ProductMessage\Api\Data\MessageInterface;
use Danielozano\ProductMessage\Api\MessageRepositoryInterface;
use Danielozano\ProductMessage\Model\ResourceModel\Message as MessageResourceModel;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var MessageResourceModel
     */
    protected $resourceModel;

    public function __construct(
        MessageFactory $messageFactory,
        MessageResourceModel $resourceModel

    ) {
        $this->messageFactory = $messageFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * @param int $id
     * @return MessageInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $message = $this->messageFactory->create();
        $this->resourceModel->load($message, $id, 'entity_id');

        if (!$message->getId()) {
            throw new NoSuchEntityException(__("Cannot find message with id %1", $id));
        }

        return $message;
    }

    /**
     * @param MessageInterface $message
     * @return MessageInterface
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(MessageInterface $message)
    {
        $this->resourceModel->save($message);

        return $this->getById($message->getId());
    }

    /**
     * @param MessageInterface $message
     * @throws \Exception
     */
    public function delete(MessageInterface $message)
    {
        $this->resourceModel->delete($message);
    }

    /**
     * {@inheritcod}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }
}
