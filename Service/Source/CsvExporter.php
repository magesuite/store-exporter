<?php

namespace MageSuite\StoreExporter\Service\Source;

class CsvExporter
{

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;


    public function __construct(
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\File\Csv $csvProcessor
    ) {
        $this->directoryList = $directoryList;
        $this->csvProcessor = $csvProcessor;
    }

    public function export(\Magento\Inventory\Model\ResourceModel\Source\Collection $sourceCollection, $fileName) {
        $preparedData = $this->prepareInventorySourceCollention($sourceCollection);

        return $this->saveDataAsCsv($preparedData, $fileName);
    }

    protected function prepareInventorySourceCollention(\Magento\Inventory\Model\ResourceModel\Source\Collection $sourceCollection) {
        $rows = [];
        foreach ($sourceCollection as $data) {
            if(empty($rows['header'])){
                $rows['header'] = array_keys($data->getData());
            }

            $row = $data->getData();
            $row['carrier_links'] = implode("|", $row['carrier_links']);
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @param mixed $preparedData
     *
     * @return string
     */
    protected function saveDataAsCsv($preparedData, $fileName)
    {
        $filePath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)
            . "/" . $fileName;

        $this->csvProcessor
            ->setDelimiter(',')
            ->setEnclosure('"')
            ->saveData($filePath, $preparedData);

        return $filePath;
    }

}