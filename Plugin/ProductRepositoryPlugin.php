<?php

namespace Danielozano\ProductMessage\Plugin;

use Danielozano\ProductMessage\Api\Data\MessageInterface;
use Danielozano\ProductMessage\Api\MessageRepositoryInterface;
use Danielozano\ProductMessage\Model\ResourceModel\Message\Collection;
use Danielozano\ProductMessage\Model\ResourceModel\Message\CollectionFactory;
use Magento\Catalog\Api\Data\ProductExtensionInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductExtensionFactory;

class ProductRepositoryPlugin
{
    /**
     * @var MessageRepositoryInterface
     */
    protected $productMessageRepository;

    /**
     * @var CollectionFactory
     */
    protected $productMessageCollectionFactory;

    /**
     * @var ProductExtensionFactory
     */
    protected $productExtensionFactory;

    /**
     * @var ProductInterface
     */
    private $currentProduct;

    /**
     * ProductRepositoryPlugin constructor.
     * @param MessageRepositoryInterface $productMessageRepository
     * @param CollectionFactory $productMessageCollectionFactory
     * @param ProductExtensionFactory $productExtensionFactory
     */
    public function __construct(
        MessageRepositoryInterface $productMessageRepository,
        CollectionFactory $productMessageCollectionFactory,
        ProductExtensionFactory $productExtensionFactory

    ) {
        $this->productMessageRepository = $productMessageRepository;
        $this->productMessageCollectionFactory = $productMessageCollectionFactory;
        $this->productExtensionFactory = $productExtensionFactory;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     */
    public function beforeSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product
    ) {
        /**
         * Necessary for avoid losing the real
         * content of the product before being prepared
         * to be saved.
         *
         * @var ProductInterface currentProduct
         */
        $this->currentProduct = $product;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     * @param array ...$args
     * @return ProductInterface
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $product,
        ...$args
    ) {
        /** @var Collection $collection */
        $collection = $this->productMessageCollectionFactory->create();
        $collection->addFieldToFilter('product_id', ['eq' => $product->getId()]);

        if ($collection->count()) {
            $extensionAttributes = $product->getExtensionAttributes();
            $extensionAttributes->setCustomMessages($collection->getItems());
            $product->setExtensionAttributes($extensionAttributes);
        }

        return $product;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     * @param array ...$args
     * @return ProductInterface
     */
    public function afterGetById(
        ProductRepositoryInterface $subject,
        ProductInterface $product,
        ...$args
    ) {
        /** @var Collection $collection */
        $collection = $this->productMessageCollectionFactory->create();
        $collection->addFieldToFilter('product_id', ['eq' => $product->getId()]);

        if ($collection->count()) {
            $extensionAttributes = $product->getExtensionAttributes();
            $extensionAttributes->setCustomMessages($collection->getItems());
            $product->setExtensionAttributes($extensionAttributes);
        }

        return $product;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $entity
     * @return ProductInterface
     */
    public function afterSave(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ) {
        if ($this->currentProduct !== null) {
            /** @var ProductExtensionInterface|null $extensionAttributes */
            $extensionAttributes = $this->currentProduct->getExtensionAttributes();

            if ($extensionAttributes && $extensionAttributes->getCustomMessages()) {
                /** @var MessageInterface[]|null $customMessages */
                $customMessages = $extensionAttributes->getCustomMessages();

                if ($customMessages) {
                    $actualProductMessages = $entity->getExtensionAttributes()->getCustomMessages();
                    if ($actualProductMessages) {
                        foreach ($actualProductMessages as $productMessage) {
                            $this->productMessageRepository->delete($productMessage);
                        }
                    }

                    /** @var MessageInterface $customMessage */
                    foreach ($customMessages as $customMessage) {
                        $customMessage->setProductId($entity->getId());
                        $this->productMessageRepository->save($customMessage);
                    }
                }
            }

            $this->currentProduct = null;
        }

        return $entity;
    }
}
