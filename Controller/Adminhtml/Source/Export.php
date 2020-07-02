<?php

namespace MageSuite\StoreExporter\Controller\Adminhtml\Source;

class Export extends \Magento\Backend\App\Action
{
    /**
     * @var \MageSuite\StoreExporter\Service\ConverterFactory
     */
    protected $converterFactory;

    /**
     * @var \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory
     */
    protected $collectionFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\StoreExporter\Service\ConverterFactory $converterFactory,
        \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->converterFactory = $converterFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $converter = $this->converterFactory->create();
        $inventorySourceCollection = $this->collectionFactory->create();
        $converter->convert($inventorySourceCollection);

        return $converter->getFileResponse();
    }
}
