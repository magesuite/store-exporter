<?php

namespace MageSuite\StoreExporter\Controller\Adminhtml\Source;

class ExportToCsv extends \Magento\Backend\App\Action
{
    /**
     * @var \MageSuite\StoreExporter\Service\Source\CsvExporter
     */
    protected $csvExporter;

    /**
     * @var \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\StoreExporter\Service\Source\CsvExporter $csvExporter,
        \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory
    )
    {
        parent::__construct($context);
        $this->csvExporter = $csvExporter;
        $this->collectionFactory = $collectionFactory;
        $this->fileFactory = $fileFactory;
    }

    public function execute()
    {
        $csvFileName = date('j_m_Y') . '_inventory_source.csv';
        
        $inventorySourceCollection = $this->collectionFactory->create();
        $this->csvExporter->export($inventorySourceCollection, $csvFileName);

        $content = [];
        $content['type'] = 'filename';
        $content['value'] = $csvFileName;
        $content['rm'] = '1';

        return $this->fileFactory->create($csvFileName, $content, \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR);
    }
}
