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
    private $coverterFactory;

    /**
     * @var \Magento\Inventory\Model\ResourceModel\Source\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;

    public function setUp(): void
    {
        parent::setUp();

        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->coverterFactory = $this->objectManager->get(\MageSuite\StoreExporter\Service\ConverterFactory::class);
        $this->collectionFactory = $this->objectManager->get(\Magento\Inventory\Model\ResourceModel\Source\CollectionFactory::class);
        $this->filesystem = $this->objectManager->get(\Magento\Framework\Filesystem::class);
        $this->csvProcessor = $this->objectManager->get(\Magento\Framework\File\Csv::class);
    }

    /**
     * @magentoDataFixture loadSources
     * @magentoAppArea adminhtml
     * @magentoAppIsolation enabled
     * @magentoConfigFixture current_store default/store_exporter/general/export_file_type csv
     */
    public function testExport()
    {
        $this->markTestSkipped();
        $csvConverter = $this->coverterFactory->create();
        $inventorySourceCollection = $this->collectionFactory->create();
        $csvConverter->convert($inventorySourceCollection);
        $filePath = $csvConverter->getFilePath();
        $data = $this->csvProcessor->getData($filePath);

        $this->assertEquals($data, $this->getExpectedResult());

        $dir = $this->filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR);
        $dir->delete($filePath);
    }

    public static function loadSources()
    {
        require __DIR__ . '/../../_files/sources.php';
    }

    private function getExpectedResult(){
        return [
            [
                "source_code",
                "name",
                "enabled",
                "description",
                "latitude",
                "longitude",
                "country_id",
                "region_id",
                "region",
                "city",
                "street",
                "postcode",
                "contact_name",
                "email",
                "phone",
                "fax",
                "use_default_carrier_config",
                "is_pickup_location_active",
                "frontend_name",
                "frontend_description",
                "url",
                "carrier_links"
            ],
            [
                "default",
                "Default Source",
                "1",
                "Default Source",
                "0.000000",
                "0.000000",
                "US",
                "",
                "",
                "",
                "",
                "00000",
                "",
                "",
                "",
                "",
                "1",
                "0",
                "",
                "",
                "",
                ""
            ],
            [
                "eu-1",
                "EU-source-1",
                "1",
                "",
                "",
                "",
                "FR",
                "",
                "",
                "",
                "",
                "postcode",
                "",
                "",
                "",
                "",
                "1",
                "0",
                "",
                "",
                "",
                ""
            ],
            [
                "eu-2",
                "EU-source-2",
                "1",
                "",
                "",
                "",
                "FR",
                "",
                "",
                "",
                "",
                "postcode",
                "",
                "",
                "",
                "",
                "1",
                "0",
                "",
                "",
                "",
                ""
            ],
            [
                "eu-3",
                "EU-source-3",
                "1",
                "",
                "",
                "",
                "DE",
                "",
                "",
                "",
                "",
                "postcode",
                "",
                "",
                "",
                "",
                "1",
                "0",
                "",
                "",
                "",
                ""
            ],
            [
                "eu-disabled",
                "EU-source-disabled",
                "0",
                "",
                "",
                "",
                "DE",
                "",
                "",
                "",
                "",
                "postcode",
                "",
                "",
                "",
                "",
                "1",
                "0",
                "",
                "",
                "",
                "",
            ],
            [
                "us-1",
                "US-source-1",
                "1",
                "",
                "",
                "",
                "US",
                "",
                "",
                "",
                "",
                "postcode",
                "",
                "",
                "",
                "",
                "1",
                "0",
                "",
                "",
                "",
                ""
            ]
        ];
    }
}
