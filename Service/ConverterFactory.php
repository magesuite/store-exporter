<?php

namespace MageSuite\StoreExporter\Service;

class ConverterFactory
{
    /**
     * @var \MageSuite\StoreExporter\Helper\Configuration
     */
    protected $configuration;

    /**
     * @var array
     */
    protected $convertersMap;

    public function __construct(
        \MageSuite\StoreExporter\Helper\Configuration $configuration,
        array $convertersMap
    ) {
        $this->configuration = $configuration;
        $this->convertersMap = $convertersMap;
    }

    /**
     * @return \MageSuite\StoreExporter\Service\ConverterInterface
     */
    public function create()
    {
        $exportType = $this->configuration->getExportFileType();

        if (!isset($this->convertersMap[$exportType])) {
            return null;
        }

        return $this->convertersMap[$exportType];
    }

    public function getConvertersMap(){
        return $this->convertersMap;
    }
}
