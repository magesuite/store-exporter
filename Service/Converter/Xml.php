<?php

namespace MageSuite\StoreExporter\Service\Converter;

class Xml extends \MageSuite\StoreExporter\Service\BaseConverter
{
    /**
     * @var \Magento\Framework\Convert\ConvertArray
     */
    protected $convertArray;

    public function __construct(
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Convert\ConvertArray $convertArray,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory
    ) {
        parent::__construct($directoryList, $fileFactory);
        $this->convertArray = $convertArray;
        $this->fileName = date('j_m_Y') . '_source.xml';
    }

    public function convert(\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $sourceCollection) {
        $preparedData = $this->convertCollectionToSimpleXml($sourceCollection);
        $this->saveDataAsXml($preparedData);
    }

    protected function convertCollectionToSimpleXml(\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $sourceCollection) {
        $xml = new \SimpleXMLElement("<root></root>");

        foreach ($sourceCollection->getData() as $item) {

            foreach($item as $key => $value) {
                if(is_string($value)) {
                    $item[$key] = htmlspecialchars($value);
                }
            }

            $xmlItem = $this->convertArray->assocToXml($item, 'item');
            self::sxmlAppend($xml, $xmlItem);
        }

        return $xml;
    }

    /**
     * @param mixed $preparedData
     *
     * @return string
     */
    protected function saveDataAsXml($preparedData)
    {
        $content = $preparedData->asXML();

        $fileHandler = fopen($this->getFilePath(), 'w');
        fwrite($fileHandler, $content);
        fclose($fileHandler);
    }

    static function sxmlAppend(\SimpleXMLElement $to, \SimpleXMLElement $from) {
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }

}
