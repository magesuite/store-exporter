<?php

namespace MageSuite\StoreExporter\Service\Converter;

class Csv extends \MageSuite\StoreExporter\Service\BaseConverter
{

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;


    public function __construct(
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\File\Csv $csvProcessor
    ) {
        parent::__construct($directoryList, $fileFactory);
        $this->csvProcessor = $csvProcessor;
        $this->fileName = date('j_m_Y') . '_source.csv';
    }

    public function convert(\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $sourceCollection) {
        $preparedData = $this->convertCollectionToArray($sourceCollection);
        $this->saveDataAsCsv($preparedData);
    }

    protected function convertCollectionToArray(\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $sourceCollection) {
        $rows = [];
        foreach ($sourceCollection as $data) {
            if(empty($rows['header'])){
                $rows['header'] = array_keys($data->getData());
            }

            $row = $data->getData();
            foreach($row as $key => $value) {
                if(is_array($value)) {
                    $row[$key] = implode("|", $value);
                }
            }

            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @param mixed $preparedData
     *
     * @return string
     */
    protected function saveDataAsCsv($preparedData)
    {
        $this->csvProcessor
            ->setDelimiter(',')
            ->setEnclosure('"')
            ->saveData($this->getFilePath(), $preparedData);
    }

}