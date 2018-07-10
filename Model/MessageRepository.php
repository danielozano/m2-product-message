<?php

namespace Danielozano\ProductMessage\Model;

use Danielozano\ProductMessage\Api\Data\MessageInterface;
use Danielozano\ProductMessage\Api\Data\MessageSearchResultInterfaceFactory;
use Danielozano\ProductMessage\Api\MessageRepositoryInterface;
use Danielozano\ProductMessage\Model\ResourceModel\Message as MessageResourceModel;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

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

    /**
     * @var MessageSearchResultInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var MessageResourceModel\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * MessageRepository constructor.
     * @param MessageFactory $messageFactory
     * @param MessageResourceModel $resourceModel
     * @param MessageResourceModel\CollectionFactory $collectionFactory
     * @param MessageSearchResultInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     */
    public function __construct(
        MessageFactory $messageFactory,
        MessageResourceModel $resourceModel,
        MessageResourceModel\CollectionFactory $collectionFactory,
        MessageSearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor

    ) {
        $this->messageFactory = $messageFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
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
     * {@inheritdoc}
     */
    public function delete(MessageInterface $message)
    {
        try {
            $this->resourceModel->delete($message);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to delete message %1', $message->getId()));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        /** @var MessageInterface $message */
        $message = $this->getById($id);

        return $this->delete($message);
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var MessageResourceModel\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->extensionAttributesJoinProcessor->process($collection);

        $collection->addFieldToSelect('*');
        $this->collectionProcessor->process($searchCriteria, $collection);

        $collection->load();
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount(intval($collection->count()));

        return $searchResult;
    }
}
