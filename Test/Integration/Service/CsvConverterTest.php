<?php

namespace MageSuite\StoreExporter\Test\Integration\Service;

class CsvConverterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \MageSuite\StoreExporter\Service\ConverterFactory
     */
    protected $converterFactory;

    /**
     * @var \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    public function setUp(): void
    {
        parent::setUp();

        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->converterFactory = $this->objectManager->get(\MageSuite\StoreExporter\Service\ConverterFactory::class);
        $this->collectionFactory = $this->objectManager->get(\Magento\Inventory\Model\ResourceModel\Source\CollectionFactory::class);
        $this->filesystem = $this->objectManager->get(\Magento\Framework\Filesystem::class);
    }

    /**
     * @magentoDataFixture loadSources
     * @magentoAppArea adminhtml
     * @magentoAppIsolation enabled
     * @magentoConfigFixture current_store default/store_exporter/general/export_file_type csv
     */
    public function testExport()
    {
        $csvConverter = $this->converterFactory->create();
        $inventorySourceCollection = $this->collectionFactory->create();
        $csvConverter->convert($inventorySourceCollection);
        $filePath = $csvConverter->getFilePath();
        $data = file_get_contents($filePath);

        foreach ($this->getExpectedSourcesData() as $index => $item) {
            $this->assertContains($item, $data);
        }

        $dir = $this->filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR);
        $dir->delete($filePath);
    }

    public static function loadSources()
    {
        require __DIR__ . '/../../_files/sources.php';
    }

    protected function getExpectedSourcesData()
    {
        return [
            'source_code,name,enabled,description,latitude,longitude,country_id,region_id,region,city,street,postcode',
            'default,"Default Source",1,"Default Source",0.000000,0.000000,US,,,,,00000',
            'eu-1,EU-source-1,1,,,,FR,,,,,postcode',
            'eu-2,EU-source-2,1,,,,FR,,,,,postcode',
            'eu-3,EU-source-3,1,,,,DE,,,,,postcode',
            'eu-disabled,EU-source-disabled,0,,,,DE,,,,,postcode',
            'us-1,US-source-1,1,,,,US,,,,,postcode'
        ];
    }
}
