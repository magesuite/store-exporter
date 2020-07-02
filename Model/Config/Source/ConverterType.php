<?php
namespace MageSuite\StoreExporter\Model\Config\Source;

class ConverterType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected $convertersType;

    public function __construct(array $convertersType)
    {
        $this->convertersType = $convertersType;
    }

    public function toOptionArray()
    {
        return $this->convertersType;
    }
}
