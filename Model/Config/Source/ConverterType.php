<?php
namespace MageSuite\StoreExporter\Model\Config\Source;

class ConverterType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \MageSuite\StoreExporter\Service\ConverterFactory
     */
    protected $converterFactory;

    public function __construct(\MageSuite\StoreExporter\Service\ConverterFactory $converterFactory)
    {
        $this->converterFactory = $converterFactory;
    }

    public function toOptionArray()
    {
        $convertersMap = $this->converterFactory->getConvertersMap();
        $convertersTypes = array_combine(array_keys($convertersMap), array_keys($convertersMap));

        return $convertersTypes;
    }
}
